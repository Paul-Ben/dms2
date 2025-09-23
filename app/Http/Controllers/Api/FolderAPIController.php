<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Folder;
use App\Models\FolderPermission;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FolderAPIController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Get all folders for authenticated user
     */
    public function index()
    {
        try {
            $user = Auth::user();
            $folders = Folder::where('created_by', $user->id)
                ->orWhereHas('permissions', function($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->with(['permissions.user', 'documents'])
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            return response()->json(['folders' => $folders], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch folders'], 500);
        }
    }

    /**
     * Create a new folder
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'parent_id' => 'nullable|exists:folders,id'
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $folder = Folder::create([
                'name' => $request->name,
                'description' => $request->description,
                'parent_id' => $request->parent_id,
                'created_by' => Auth::id(),
            ]);

            return response()->json([
                'message' => 'Folder created successfully',
                'folder' => $folder
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create folder'], 500);
        }
    }

    /**
     * Get specific folder with documents
     */
    public function show(Folder $folder)
    {
        try {
            $user = Auth::user();
            
            // Check if user has access to this folder
            if ($folder->created_by !== $user->id && 
                !$folder->permissions()->where('user_id', $user->id)->exists()) {
                return response()->json(['error' => 'Unauthorized access to folder'], 403);
            }

            $folder->load(['documents', 'permissions.user', 'subfolders']);
            
            return response()->json(['folder' => $folder], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch folder'], 500);
        }
    }

    /**
     * Update folder
     */
    public function update(Request $request, Folder $folder)
    {
        try {
            $user = Auth::user();
            
            // Check if user owns the folder
            if ($folder->created_by !== $user->id) {
                return response()->json(['error' => 'Unauthorized to update folder'], 403);
            }

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $folder->name = $request->name;
            $folder->description = $request->description;
            $folder->save();

            return response()->json([
                'message' => 'Folder updated successfully',
                'folder' => $folder
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update folder'], 500);
        }
    }

    /**
     * Delete folder
     */
    public function destroy(Folder $folder)
    {
        try {
            $user = Auth::user();
            
            // Check if user owns the folder
            if ($folder->created_by !== $user->id) {
                return response()->json(['error' => 'Unauthorized to delete folder'], 403);
            }

            // Check if folder has documents
            if ($folder->documents()->count() > 0) {
                return response()->json(['error' => 'Cannot delete folder with documents'], 422);
            }

            $folder->delete();

            return response()->json(['message' => 'Folder deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete folder'], 500);
        }
    }

    /**
     * Share folder with users
     */
    public function share(Request $request, Folder $folder)
    {
        try {
            $user = Auth::user();
            
            // Check if user owns the folder
            if ($folder->created_by !== $user->id) {
                return response()->json(['error' => 'Unauthorized to share folder'], 403);
            }

            $validator = Validator::make($request->all(), [
                'user_ids' => 'required|array',
                'user_ids.*' => 'exists:users,id',
                'permission_type' => 'required|in:read,write,admin'
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            foreach ($request->user_ids as $userId) {
                FolderPermission::updateOrCreate(
                    ['folder_id' => $folder->id, 'user_id' => $userId],
                    ['permission_type' => $request->permission_type]
                );
            }

            return response()->json(['message' => 'Folder shared successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to share folder'], 500);
        }
    }

    /**
     * Remove folder sharing
     */
    public function unshare(Request $request, Folder $folder)
    {
        try {
            $user = Auth::user();
            
            // Check if user owns the folder
            if ($folder->created_by !== $user->id) {
                return response()->json(['error' => 'Unauthorized to unshare folder'], 403);
            }

            $validator = Validator::make($request->all(), [
                'user_ids' => 'required|array',
                'user_ids.*' => 'exists:users,id'
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            FolderPermission::where('folder_id', $folder->id)
                ->whereIn('user_id', $request->user_ids)
                ->delete();

            return response()->json(['message' => 'Folder unshared successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to unshare folder'], 500);
        }
    }

    /**
     * Add document to folder
     */
    public function addDocument(Request $request, Folder $folder)
    {
        try {
            $user = Auth::user();
            
            // Check if user has write access to folder
            if ($folder->created_by !== $user->id && 
                !$folder->permissions()->where('user_id', $user->id)->where('permission_type', 'write')->exists()) {
                return response()->json(['error' => 'Unauthorized to add documents to folder'], 403);
            }

            $validator = Validator::make($request->all(), [
                'document_id' => 'required|exists:documents,id'
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $document = Document::find($request->document_id);
            $document->folder_id = $folder->id;
            $document->save();

            return response()->json(['message' => 'Document added to folder successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to add document to folder'], 500);
        }
    }

    /**
     * Remove document from folder
     */
    public function removeDocument(Request $request, Folder $folder)
    {
        try {
            $user = Auth::user();
            
            // Check if user has write access to folder
            if ($folder->created_by !== $user->id && 
                !$folder->permissions()->where('user_id', $user->id)->where('permission_type', 'write')->exists()) {
                return response()->json(['error' => 'Unauthorized to remove documents from folder'], 403);
            }

            $validator = Validator::make($request->all(), [
                'document_id' => 'required|exists:documents,id'
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $document = Document::find($request->document_id);
            $document->folder_id = null;
            $document->save();

            return response()->json(['message' => 'Document removed from folder successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to remove document from folder'], 500);
        }
    }
}