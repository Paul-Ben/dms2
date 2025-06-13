<?php

namespace App\Http\Controllers;

use App\Models\BackupLog;
use App\Models\Tenant;
use App\Models\UserDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BackupLogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $authUser = Auth::user();
        $userdetails = UserDetails::where('user_id', $authUser->id)->first();
        $userTenant = Tenant::where('id', $userdetails->tenant_id)->first();
        $backups = BackupLog::orderBy('created_at', 'asc')->get();
        if (Auth::user()->default_role === 'superadmin') {
            
            return view('superadmin.backups', compact('backups', 'userTenant', 'authUser'));
        }
        return view('errors.404', compact('authUser', 'userTenant'));
    }

    public function download(BackupLog $backup)
    {
        // $backup = BackupLog::findOrFail($id);
        
        $path = $backup->file_path;
        // dd($path);
    
        if (file_exists($path)) {
            return response()->download($path);
        }
        abort(404, 'Backup file not found.');
    }

    public function destroy(BackupLog $backup)
{
    // Check if user is superadmin
    if (Auth::user()->default_role !== 'superadmin') {
        abort(403, 'Unauthorized action.');
    }

    $path = $backup->file_path;

    // First check if file exists
    if (file_exists($path)) {
        // Delete the file
        if (unlink($path)) {
            // Delete the database record
            $backup->delete();
            $notification = [
                'message' => 'Backup file deleted successfully.',
                'alert-type' => 'success'
            ];
            return redirect()
                ->route('backup.index')
                ->with($notification);
        } else {
            $notification = [
                'message' => 'Failed to delete backup file',
                'alert-type' => 'error'
            ];
            return back()
                ->with($notification );
        }
    }

    // If file doesn't exist, just delete the record
    $backup->delete();
    $notification = [
        'message' => 'Backup record deleted but file was not found',
        'alert-type' => 'warning'
    ];
    return redirect()
        ->route('backup.index')
        ->with($notification);
}
}
