<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FileCharge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FileChargeAPIController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Get all file charges
     */
    public function index()
    {
        try {
            $user = Auth::user();
            
            // Only superadmin and admin can view all file charges
            if (!in_array($user->default_role, ['superadmin', 'Admin'])) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            $fileCharges = FileCharge::orderBy('created_at', 'desc')->paginate(10);
            
            return response()->json(['file_charges' => $fileCharges], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch file charges'], 500);
        }
    }

    /**
     * Create new file charge
     */
    public function store(Request $request)
    {
        try {
            $user = Auth::user();
            
            // Only superadmin can create file charges
            if ($user->default_role !== 'superadmin') {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'amount' => 'required|numeric|min:0',
                'description' => 'nullable|string',
                'is_active' => 'boolean'
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $fileCharge = FileCharge::create([
                'name' => $request->name,
                'amount' => $request->amount,
                'description' => $request->description,
                'is_active' => $request->is_active ?? true,
                'created_by' => $user->id
            ]);

            return response()->json([
                'message' => 'File charge created successfully',
                'file_charge' => $fileCharge
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create file charge'], 500);
        }
    }

    /**
     * Get specific file charge
     */
    public function show(FileCharge $fileCharge)
    {
        try {
            $user = Auth::user();
            
            // Only superadmin and admin can view file charges
            if (!in_array($user->default_role, ['superadmin', 'Admin'])) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            return response()->json(['file_charge' => $fileCharge], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch file charge'], 500);
        }
    }

    /**
     * Update file charge
     */
    public function update(Request $request, FileCharge $fileCharge)
    {
        try {
            $user = Auth::user();
            
            // Only superadmin can update file charges
            if ($user->default_role !== 'superadmin') {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'amount' => 'required|numeric|min:0',
                'description' => 'nullable|string',
                'is_active' => 'boolean'
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $fileCharge->name = $request->name;
            $fileCharge->amount = $request->amount;
            $fileCharge->description = $request->description;
            $fileCharge->is_active = $request->is_active ?? $fileCharge->is_active;
            $fileCharge->save();

            return response()->json([
                'message' => 'File charge updated successfully',
                'file_charge' => $fileCharge
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update file charge'], 500);
        }
    }

    /**
     * Delete file charge
     */
    public function destroy(FileCharge $fileCharge)
    {
        try {
            $user = Auth::user();
            
            // Only superadmin can delete file charges
            if ($user->default_role !== 'superadmin') {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            $fileCharge->delete();

            return response()->json(['message' => 'File charge deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete file charge'], 500);
        }
    }

    /**
     * Get active file charges for public use
     */
    public function getActiveCharges()
    {
        try {
            $activeCharges = FileCharge::where('is_active', true)
                ->select('id', 'name', 'amount', 'description')
                ->orderBy('name')
                ->get();

            return response()->json(['file_charges' => $activeCharges], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch active file charges'], 500);
        }
    }

    /**
     * Toggle file charge status
     */
    public function toggleStatus(FileCharge $fileCharge)
    {
        try {
            $user = Auth::user();
            
            // Only superadmin can toggle status
            if ($user->default_role !== 'superadmin') {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            $fileCharge->is_active = !$fileCharge->is_active;
            $fileCharge->save();

            return response()->json([
                'message' => 'File charge status updated successfully',
                'file_charge' => $fileCharge
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to toggle file charge status'], 500);
        }
    }
}