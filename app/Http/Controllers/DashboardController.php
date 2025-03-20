<?php

namespace App\Http\Controllers;

use App\Helpers\DocumentStorage;
use App\Models\Activity;
use App\Models\Tenant;
use App\Models\User;
use App\Models\UserDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Ensure the user is authenticated
    }

    public function index()
    {
        $authUser = Auth::user();
        $role = $authUser->default_role;
        $userdetails = UserDetails::where('user_id', $authUser->id)->first();
        $userTenant = Tenant::where('id', $userdetails->tenant_id)->first();


        $views = [
            'superadmin' => 'superadmin.index',
            'Admin' => 'admin.index',
            'Secretary' => 'secretary.index',
            'Staff' => 'staff.index',
            'User' => 'user.index',
        ];


        if (!array_key_exists($role, $views)) {
            return view('errors.404');
        }


        list($recieved_documents_count, $sent_documents_count, $uploaded_documents_count, $totalAmount) = DocumentStorage::documentCount();
        // $activities = Activity::where('user_id', $authUser->id)->latest()->take(20);
        $activities = Activity::with('user')
            ->where('user_id', $authUser->id)
            ->orderBy('id', 'desc')
            ->limit(20) // Retrieve only the last 20 records
            ->paginate(10);

        return view($views[$role], compact('recieved_documents_count', 'sent_documents_count', 'uploaded_documents_count', 'activities', 'userTenant', 'totalAmount',  'authUser'));
    }
}
