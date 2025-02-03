<?php

namespace App\Http\Controllers;

use App\Helpers\DocumentStorage;
use App\Models\Activity;
use App\Models\User;
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


        list($recieved_documents_count, $sent_documents_count, $uploaded_documents_count) = DocumentStorage::documentCount();
        $activities = Activity::with('user')
            ->where('user_id', $authUser->id)
            ->orderBy('id', 'desc')
            ->paginate(10);


        return view($views[$role], compact('recieved_documents_count', 'sent_documents_count', 'uploaded_documents_count', 'activities', 'authUser'));
    }
}
