<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\UserDetails;
use App\Models\VisitorActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VisitorActivityController extends Controller
{
    public function index()
    {
        $authUser = Auth::user();
         $userdetails = UserDetails::where('user_id', $authUser->id)->first();
        $userTenant = Tenant::where('id', $userdetails->tenant_id)->first();
        if ($authUser->default_role !== 'superadmin') {
            return redirect()->route('home')->with('error', 'You do not have permission to access this page.');
        }
        $activities = VisitorActivity::with('user')->orderBy('id', 'asc')->get();
        return view('superadmin.visitor_activity.index', compact('activities', 'authUser', 'userTenant'));
    }
}
