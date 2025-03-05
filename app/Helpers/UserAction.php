<?php

namespace App\Helpers;

use App\Models\Designation;
use App\Models\Tenant;
use App\Models\TenantDepartment;
use App\Models\User;
use App\Models\UserDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class UserAction
{
    public static function userCount()
    {
        $user_count = User::count();
        return $user_count;
    }

    public static function allUsers($perpage = 10)
    {
        $users = User::orderBy('id', 'desc')
            ->paginate($perpage);

        return $users;
    }

    public static function storeUser($data)
    {
        $data->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|string',
        ]);

        $data->password = bcrypt($data->password);
        $user = User::create($data->all());
        return $user;
    }

    public static function updateUser($data, $id)
    {
        $data->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'role' => 'required|string',
        ]);

        $user = User::find($id);
        $user->update($data->all());
        return $user;
    }

    public static function deleteUser($id)
    {
        $user = User::find($id);
        $user->delete();
        return $user;
    }

    public static function getOrganisationDetails()
    {
        try {
            $authUser = Auth::user();
            if ($authUser->default_role == 'superadmin') {
                $organisations = Tenant::with('tenant_departments')->get();
                $roles = Role::all();
                $designations = Designation::all();
                foreach ($organisations as $key => $value) {
                    $departments = TenantDepartment::where('tenant_id', $value->id)->get();
                }
                return [$organisations, $roles, $departments, $designations];
            } else {
                $organisations = Tenant::with('tenant_departments')->get();
                $roles = Role::where('name', '!=', Auth::user()->default_role)->get();
                $designations = Designation::all();
                foreach ($organisations as $key => $value) {
                    $departments = TenantDepartment::where('tenant_id', $value->id)->get();
                }
                return [$organisations, $roles, $departments, $designations];
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while fetching organisation details',
            ], 500);
        }
    }

    public static function getUserDetails()
    {
        $user_details = UserDetails::where('user_id', Auth::user()->id)->first();
        return $user_details;
    }
}
