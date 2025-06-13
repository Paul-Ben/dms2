<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\DatabaseBackupNotification;
use App\Models\BackupLog;

class WeeklyIncrementalBackup extends Command
{
    protected $signature = 'backup:weekly-incremental';
    protected $description = 'Perform a weekly incremental backup of the database';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        try {
            // Define the backup file name
            $backupFileName = 'weekly_incremental_backup_' . now()->format('Y-m-d_H-i-s') . '.sql';
            $backupFilePath = storage_path('app/public/backups/' . $backupFileName);

            // Get all tables except the excluded ones
            $excludedTables = ['migrations', 'cache', 'sessions', 'password_resets', 'failed_jobs'];
            $tables = DB::select('SHOW TABLES');
            $tables = array_map(function ($table) {
                return $table->Tables_in_dms; // Replace 'your_database_name' with your actual database name
            }, $tables);
            $tables = array_diff($tables, $excludedTables);

            // Create the backup command
            $tablesString = implode(' ', $tables);
            $command = "mysqldump --user=" . env('DB_USERNAME') . " --password=" . env('DB_PASSWORD') . " --host=" . env('DB_HOST') . " " . env('DB_DATABASE') . " $tablesString > " . escapeshellarg($backupFilePath);
            exec($command);

            // Check if the backup file exists
            if (!file_exists($backupFilePath)) {
                Log::error('Backup file does not exist: ' . $backupFilePath);
                $this->error('Backup file does not exist.');
                return;
            }

            // Send the backup file via email
            try{
                 $this->sendEmail($backupFilePath);
            }catch (\Exception $e) {
                Log::error('Failed to send backup email: ' . $e->getMessage());
                $this->error('Failed to send backup email.');
            }
           

            BackupLog::create([
                // 'file_name' => $backupFileName,
                'file_path' => $backupFilePath
            ]);

            $this->info('Weekly incremental backup completed successfully.');
        } catch (\Exception $e) {
            Log::error('Weekly incremental backup failed: ' . $e->getMessage());
            $this->error('Weekly incremental backup failed.');
        }
    }

    private function sendEmail($filePath)
    {
        Mail::to('your-email@example.com')->send(new DatabaseBackupNotification($filePath));
    }
}
