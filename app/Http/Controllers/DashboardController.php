<?php

namespace App\Http\Controllers;

use App\Helpers\DocumentStorage;
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
           
            return view('superadmin.index', compact('recieved_documents_count', 'sent_documents_count', 'uploaded_documents_count'));
        }
        if (Auth::user()->default_role === 'Admin') {
            list($recieved_documents_count, $sent_documents_count, $uploaded_documents_count) = DocumentStorage::documentCount();
           
            return view('admin.index', compact('recieved_documents_count', 'sent_documents_count', 'uploaded_documents_count'));
        }
        if (Auth::user()->default_role === 'Staff') {
            list($recieved_documents_count, $sent_documents_count, $uploaded_documents_count) = DocumentStorage::documentCount();
           
            return view('staff.index', compact('recieved_documents_count', 'sent_documents_count', 'uploaded_documents_count'));
        }
        if (Auth::user()->default_role === 'User') {
            list($recieved_documents_count, $sent_documents_count, $uploaded_documents_count) = DocumentStorage::documentCount();
        //    dd(Auth::user()->userDetail);
            return view('user.index', compact('recieved_documents_count', 'sent_documents_count', 'uploaded_documents_count'));
        }
        return view('errors.404');
    }
}
