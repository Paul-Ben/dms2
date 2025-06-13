<?php

namespace App\Console\Commands;

use App\Mail\VisitorActivitiesBackup;
use App\Models\BackupLog;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class BackupVisitorActivities extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'visitor:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup and purge visitor activities table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            // Generate filename with timestamp
            $filename = 'visitor_activities_' . Carbon::now()->format('Y-m-d_H-i-s') . '.csv';
            $filepath = storage_path('app/public/backups/' . $filename);
            $adminEmail = config('app.admin_email');

            // Ensure directory exists
            if (!file_exists(storage_path('app/public/backups/'))) {
                mkdir(storage_path('app/public/backups/'), 0755, true);
            }

            // Get all data from the table
            $activities = DB::table('visitor_activities')->get();

            // Create CSV file
            $file = fopen($filepath, 'w');

            // Write headers
            fputcsv($file, [
                'ID',
                'User ID',
                'IP Address',
                'Country',
                'Region',
                'City',
                'Browser',
                'Device',
                'URL',
                'Method',
                'User Agent',
                'Created At',
                'Updated At'
            ]);

            // Write data
            foreach ($activities as $activity) {
                fputcsv($file, [
                    $activity->id,
                    $activity->user_id,
                    $activity->ip_address,
                    $activity->country,
                    $activity->region,
                    $activity->city,
                    $activity->browser,
                    $activity->device,
                    $activity->url,
                    $activity->method,
                    $activity->user_agent,
                    $activity->created_at,
                    $activity->updated_at
                ]);
            }

            fclose($file);

            if (empty($adminEmail)) {
                $this->error('Admin email is not configured.');
                return;
            }
            // Email the backup
            try {
                Mail::to(config('app.admin_email'))
                    ->send(new VisitorActivitiesBackup($filepath));
            } catch (\Exception $e) {
                Log::error('Failed to send Document notification');
            }

            // Purge records older than 7 days
            $cutoffDate = Carbon::now()->subDays(7)->format('Y-m-d H:i:s');

            $this->info("Attempting to purge records older than: {$cutoffDate}");

            $recordsToDelete = DB::table('visitor_activities')
                ->where('created_at', '<', $cutoffDate)
                ->count();

            $this->info("Found {$recordsToDelete} records to delete");

            if ($recordsToDelete > 0) {
                $deleted = DB::table('visitor_activities')
                    ->where('created_at', '<', $cutoffDate)
                    ->delete();

                $this->info("Successfully deleted {$deleted} records");

                // Log the purge operation

                Log::info("Purged {$deleted} visitor_activities records older than {$cutoffDate}");
            } else {
                $this->info("No records found older than cutoff date");
            }

            BackupLog::create([
                // 'backup_name' => $filename,
                'file_path' =>  $filepath, // relative to storage_path()
            ]);
            

            $this->info('Visitor activities backed up and purged successfully.');
        } catch (\Exception $e) {
            $this->error("Error during backup/purge: " . $e->getMessage());
            Log::error("Visitor activities backup failed: " . $e->getMessage());
        }
    }
}
