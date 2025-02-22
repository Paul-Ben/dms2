<?php

namespace App\Http\Controllers\Api;

use App\Helpers\DocumentStorage;
use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardAPIController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum'); // Ensure the user is authenticated via API
    }

    public function index()
    {
        $authUser = Auth::user();
        $role = $authUser->default_role;

        // Define roles and their corresponding data
        $roles = ['superadmin', 'Admin', 'Secretary', 'Staff', 'User'];

        // Check if the user's role is valid
        if (!in_array($role, $roles)) {
            return response()->json(['error' => 'Unauthorized role'], 403);
        }

        // Get document counts
        list($received_documents_count, $sent_documents_count, $uploaded_documents_count) = DocumentStorage::documentCount();

        // Get user activities
        $activities = Activity::with('user')
            ->where('user_id', $authUser->id)
            ->orderBy('id', 'desc')
            ->paginate(10);

        // Return JSON response
        return response()->json([
            'role' => $role,
            'received_documents_count' => $received_documents_count,
            'sent_documents_count' => $sent_documents_count,
            'uploaded_documents_count' => $uploaded_documents_count,
            'activities' => $activities,
            'user' => $authUser,
        ], 200);
    }
}
