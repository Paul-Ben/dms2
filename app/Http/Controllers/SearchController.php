<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Tenant;
use App\Models\TenantDepartment;
use App\Models\User;
use App\Models\UserDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function searchUser(Request $request)
    {
        $authUser = Auth::user();
        $userdetails = UserDetails::where('user_id', $authUser->id)->first();
        $userTenant = Tenant::where('id', $userdetails->tenant_id)->first();
        $search = $request->input('search');
        $users = User::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('default_role', 'like', "%{$search}%");
        })->paginate(10);
        if ($authUser->default_role === 'superadmin') {
            return view('superadmin.usermanager.index', compact('users', 'authUser', 'userTenant'));
        }
        if ($authUser->default_role === 'Admin') {
            $id = Auth::user()->userDetail->tenant_id;
            $users = UserDetails::with('user') // Load user relationship
                ->where('tenant_id', $id) // Filter by tenant
                ->whereHas('user', function ($query) use ($search) { // Filter by user fields
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('default_role', 'like', "%{$search}%");
                })
                ->paginate(10);
            return view('admin.usermanager.index', compact('users', 'authUser', 'userTenant'));
        }

        return view('errors.404', compact('authUser', 'userTenant'));
    }
    public function searchOrg(Request $request)
    {
        $authUser = Auth::user();
        $userdetails = UserDetails::where('user_id', $authUser->id)->first();
        $userTenant = Tenant::where('id', $userdetails->tenant_id)->first();
        $search = $request->input('search');
        $organisations = Tenant::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%");
        })->paginate(10);
        return view('superadmin.organisations.index', compact('organisations', 'authUser', 'userTenant'));
    }

    public function searchDept(Request $request)
    {
        $authUser = Auth::user();
        $userdetails = UserDetails::where('user_id', $authUser->id)->first();
        $userTenant = Tenant::where('id', $userdetails->tenant_id)->first();
        $search = $request->input('search');

        if ($authUser->default_role === 'superadmin') {

            $departments = TenantDepartment::when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%");
            })->paginate(10);
            return view('superadmin.departments.index', compact('departments', 'authUser', 'userTenant'));
        }
        if ($authUser->default_role === 'Admin') {
            $departments = TenantDepartment::where('tenant_id', $userTenant->id)->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%");
            })->paginate(10);
            return view('admin.departments.index', compact('departments', 'authUser', 'userTenant'));
        }
        return view('errors.404', compact('authUser', 'userTenant'));
    }

    public function searchDoc(Request $request)
    {
        $authUser = Auth::user();
        $userdetails = UserDetails::where('user_id', $authUser->id)->first();
        $userTenant = Tenant::where('id', $userdetails->tenant_id)->first();
        $search = $request->input('search');
        $documents = Document::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%");
        })->paginate(10);
        return view('superadmin.documents.index', compact('documents', 'authUser', 'userTenant'));
    }
}
