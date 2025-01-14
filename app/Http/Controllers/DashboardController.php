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
        if (Auth::user()->default_role === 'superadmin') {
            list($recieved_documents_count, $sent_documents_count, $uploaded_documents_count) = DocumentStorage::documentCount();
            $activities = Activity::with('user')->where('user_id', Auth::user()->id)->orderBy('id', 'desc')->paginate(10);
            return view('superadmin.index', compact('recieved_documents_count', 'sent_documents_count', 'uploaded_documents_count', 'activities'));
        }
        if (Auth::user()->default_role === 'Admin') {
            list($recieved_documents_count, $sent_documents_count, $uploaded_documents_count) = DocumentStorage::documentCount();
            $activities = Activity::with('user')->where('user_id', Auth::user()->id)->orderBy('id', 'desc')->paginate(10);

            return view('admin.index', compact('recieved_documents_count', 'sent_documents_count', 'uploaded_documents_count', 'activities'));
        }
        if (Auth::user()->default_role === 'Secretary') {
            list($recieved_documents_count, $sent_documents_count, $uploaded_documents_count) = DocumentStorage::documentCount();
            $activities = Activity::with('user')->where('user_id', Auth::user()->id)->orderBy('id', 'desc')->paginate(10);

            return view('secretary.index', compact('recieved_documents_count', 'sent_documents_count', 'uploaded_documents_count', 'activities'));
        }
        if (Auth::user()->default_role === 'Staff') {
            list($recieved_documents_count, $sent_documents_count, $uploaded_documents_count) = DocumentStorage::documentCount();
            $activities = Activity::with('user')->where('user_id', Auth::user()->id)->orderBy('id', 'desc')->paginate(10);
            return view('staff.index', compact('recieved_documents_count', 'sent_documents_count', 'uploaded_documents_count', 'activities'));
        }
        if (Auth::user()->default_role === 'User') {
            list($recieved_documents_count, $sent_documents_count, $uploaded_documents_count) = DocumentStorage::documentCount();
            $activities = Activity::with('user')->where('user_id', Auth::user()->id)->orderBy('id', 'desc')->paginate(10);

            return view('user.index', compact('recieved_documents_count', 'sent_documents_count', 'uploaded_documents_count', 'activities'));
        }
        return view('errors.404');
    }
}
