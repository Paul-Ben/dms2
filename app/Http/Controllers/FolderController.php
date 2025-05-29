<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use App\Models\User;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Document;
use App\Models\Activity;
use App\Models\UserDetails;

class FolderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $authUser = Auth::user();
        $userdetails = $authUser->userDetail;
        $userTenant = Tenant::where('id', $userdetails->tenant_id)->first();

        if (!in_array($authUser->default_role, ['Secretary', 'Staff', 'Admin', 'IT Admin'])) {
            return view('errors.404', compact('authUser', 'userTenant'));
        }

        $folders = Folder::with(['creator', 'parent', 'documents'])
            ->where('tenant_id', $userdetails->tenant_id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.folders.index', compact('folders', 'authUser', 'userTenant'));
    }

    public function create()
    {
        $authUser = Auth::user();
        $userdetails = $authUser->userDetail;
        $userTenant = Tenant::where('id', $userdetails->tenant_id)->first();
        $folders = Folder::with(['creator', 'parent', 'documents'])
            ->where('tenant_id', $userdetails->tenant_id)
            ->orderBy('created_at', 'desc')
            ->get();

        if (!in_array($authUser->default_role, ['Secretary', 'Admin', 'IT Admin'])) {
            return view('errors.404', compact('authUser', 'userTenant'));
        }

        $parentFolders = Folder::where('tenant_id', $userdetails->tenant_id)
            ->whereNull('parent_id')
            ->get();

        // Get users from the same tenant
        $users = User::whereHas('userDetail', function ($query) use ($userdetails) {
            $query->where('tenant_id', $userdetails->tenant_id);
        })->get();

        return view('admin.folders.create', compact('parentFolders', 'authUser', 'userTenant', 'folders', 'users'));
    }

    public function store(Request $request)
    {
        $authUser = Auth::user();
        $userdetails = $authUser->userDetail;

        if (!in_array($authUser->default_role, ['Secretary', 'Admin', 'IT Admin'])) {
            return redirect()->back()->with('error', 'Unauthorized access');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:folders,id',
            'is_private' => 'boolean',
            'permissions' => 'required_if:is_private,true|array',
            'permissions.*.user_id' => 'required|exists:users,id',
            'permissions.*.permission' => 'required|in:read,write,admin'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            $folder = Folder::create([
                'name' => $request->name,
                'description' => $request->description,
                'tenant_id' => $userdetails->tenant_id,
                'created_by' => $authUser->id,
                'parent_id' => $request->parent_id,
                'is_private' => $request->is_private ?? false
            ]);

            // Add creator as admin by default
            $folder->users()->attach($authUser->id, ['permission' => 'admin']);

            // Add other user permissions if folder is private
            if ($request->is_private && $request->has('permissions')) {
                foreach ($request->permissions as $permission) {
                    if ($permission['user_id'] != $authUser->id) { // Don't add creator again
                        $folder->users()->attach($permission['user_id'], [
                            'permission' => $permission['permission']
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('folders.index')
                ->with(['message' => 'Folder created successfully', 'alert-type' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with(['message' => 'Error creating folder: ' . $e->getMessage(), 'alert-type' => 'error'])
                ->withInput();
        }
    }

    public function show(Folder $folder)
    {
        $authUser = Auth::user();
        $userdetails = $authUser->userDetail;
        $userTenant = Tenant::where('id', $userdetails->tenant_id)->first();

        // Check if user has access to the folder
        if ($folder->is_private) {
            $hasAccess = $folder->users()
                ->where('user_id', $authUser->id)
                ->exists();

            if (!$hasAccess) {
                return redirect()->back()->with(['message' => 'You do not have permission to access this folder', 'alert-type' => 'error']);
            }
        }

        $documents = $folder->documents()
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.folders.show', compact('folder', 'documents', 'authUser', 'userTenant'));
    }

    public function edit(Folder $folder)
    {
        $authUser = Auth::user();
        $userdetails = $authUser->userDetail;
        $userTenant = Tenant::where('id', $userdetails->tenant_id)->first();

        if (!in_array($authUser->default_role, ['Secretary', 'Admin', 'IT Admin'])) {
            return view('errors.404', compact('authUser', 'userTenant'));
        }

        $parentFolders = Folder::where('tenant_id', $userdetails->tenant_id)
            ->where('id', '!=', $folder->id)
            ->whereNull('parent_id')
            ->get();

        $folders = Folder::where('tenant_id', $userdetails->tenant_id)
            ->where('id', '!=', $folder->id)
            ->whereNotNull('parent_id')
            ->get();

        $users = User::whereHas('userDetail', function ($query) use ($userdetails) {
            $query->where('tenant_id', $userdetails->tenant_id);
        })->get();

        return view('admin.folders.edit', compact('folders', 'folder', 'parentFolders', 'users', 'authUser', 'userTenant'));
    }

    public function update(Request $request, Folder $folder)
    {
        $authUser = Auth::user();
        $userdetails = $authUser->userDetail;

        if (!in_array($authUser->default_role, ['Secretary', 'Admin', 'IT Admin'])) {
            return redirect()->back()->with('error', 'Unauthorized access');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:folders,id',
            'is_private' => 'boolean',
            'permissions' => 'required_if:is_private,true|array',
            'permissions.*.user_id' => 'required|exists:users,id',
            'permissions.*.permission' => 'required|in:read,write,admin'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $folder->update([
            'name' => $request->name,
            'description' => $request->description,
            'parent_id' => $request->parent_id,
            'is_private' => $request->is_private ?? false
        ]);

        if ($request->is_private) {
            // Remove all existing permissions
            $folder->users()->detach();

            // Add new permissions
            if ($request->has('permissions')) {
                foreach ($request->permissions as $permission) {
                    $folder->users()->attach($permission['user_id'], [
                        'permission' => $permission['permission']
                    ]);
                }
            }
        } else {
            // If folder is not private, remove all permissions
            $folder->users()->detach();
        }

        return redirect()->route('folders.index')
            ->with('success', 'Folder updated successfully');
    }

    public function destroy(Folder $folder)
    {
        $authUser = Auth::user();
        $userdetails = $authUser->userDetail;

        if (!in_array($authUser->default_role, ['Secretary', 'Admin', 'IT Admin'])) {
            return redirect()->back()->with('error', 'Unauthorized access');
        }

        // Check if folder has documents
        if ($folder->documents()->exists()) {
            return redirect()->back()->with(['message' => 'Cannot delete folder with documents', 'alert-type' => 'error']);
        }

        // Check if folder has subfolders
        if ($folder->children()->exists()) {
            return redirect()->back()->with(['message' => 'Cannot delete folder with subfolders']);
        }

        // Check if folder was not created by the user
        if ($folder->created_by !== $authUser->id) {
            return redirect()->back()->with(['message' => 'Cannot delete folder that was not created by you.', 'alert-type' => 'error']);
        }

        $folder->delete();

        return redirect()->route('folders.index')
            ->with('success', 'Folder deleted successfully');
    }

    public function addDocuments(Request $request, Folder $folder)
    {
        $request->validate([
            'document_id' => 'required|exists:documents,id'
        ]);

        try {
            DB::beginTransaction();

            // Get the document
            $document = Document::findOrFail($request->document_id);

            // Check if document already belongs to a folder
            if ($document->folder_id) {
                return redirect()->back()->with([
                    'message' => 'Document already belongs to a folder',
                    'alert-type' => 'error'
                ]);
            }

            // Update document to add it to the folder
            $document->update(['folder_id' => $folder->id]);

            // Log the activity
            Activity::create([
                'action' => 'Added document to folder: ' . $folder->name,
                'user_id' => Auth::id(),
            ]);

            DB::commit();

            return redirect()->back()->with([
                'message' => 'Document added to folder successfully',
                'alert-type' => 'success'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with([
                'message' => 'Error adding document to folder: ' . $e->getMessage(),
                'alert-type' => 'error'
            ]);
        }
    }

    public function removeDocument(Request $request, Folder $folder, Document $document)
    {
        $authUser = Auth::user();
        $userdetails = $authUser->userDetail;
        if (!in_array($authUser->default_role, ['Secretary', 'Staff', 'Admin', 'IT Admin'])) {
            return redirect()->back()->with('error', 'Unauthorized access');
        }
        try {
            DB::beginTransaction();

            // Check if document belongs to the folder
            if ($document->folder_id !== $folder->id) {
                return redirect()->back()->with([
                    'message' => 'Document does not belong to this folder',
                    'alert-type' => 'error'
                ]);
            }
            // check if the user has permission to remove documents from this folder
            $hasPermission = $folder->users()
                ->where('user_id', $authUser->id)
                ->whereIn('permission', ['write', 'admin'])
                ->exists();
            if (!$hasPermission) {
                return redirect()->back()->with([
                    'message' => 'You do not have permission to remove documents from this folder',
                    'alert-type' => 'error'
                ]);
            }

            // Remove document from folder
            $document->update(['folder_id' => null]);

            // Log the activity
            Activity::create([
                'action' => 'Removed document from folder: ' . $folder->name,
                'user_id' => Auth::id(),
            ]);

            DB::commit();

            return redirect()->back()->with([
                'message' => 'Document removed from folder successfully',
                'alert-type' => 'success'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with([
                'message' => 'Error removing document from folder: ' . $e->getMessage(),
                'alert-type' => 'error'
            ]);
        }
    }

    public function showAddDocuments(Folder $folder)
    {
        $authUser = Auth::user();
        $userdetails = UserDetails::where('user_id', $authUser->id)->first();
        $userTenant = Tenant::where('id', $userdetails->tenant_id)->first();

        // Get documents that don't belong to any folder
        $availableDocuments = Document::whereNull('folder_id')
            ->where('uploaded_by', Auth::id())
            ->get();

        return view('folders.add-documents', compact('folder', 'availableDocuments', 'authUser', 'userTenant'));
    }

    public function selectFolder(Request $request, Document $document)
    {
        // Check if the document is already in a folder
        if ($document->folder_id) {
            return redirect()->back()->with([
                'message' => 'Document already belongs to a folder',
                'alert-type' => 'error'
            ]);
        }
        
        $authUser = Auth::user();
        $userdetails = UserDetails::where('user_id', $authUser->id)->first();
        $userTenant = Tenant::where('id', $userdetails->tenant_id)->first();
        
        if (!in_array($authUser->default_role, ['Secretary', 'Admin', 'IT Admin'])) {
            return view('errors.404', compact('authUser', 'userTenant'));
        }

        // Get all folders the user has access to
        $folders = Folder::where('tenant_id', $userdetails->tenant_id)
            ->where(function($query) use ($authUser) {
                $query->where('created_by', $authUser->id)
                    ->orWhereHas('users', function($q) use ($authUser) {
                        $q->where('user_id', $authUser->id);
                    });
            })
            ->get();

        return view('folders.select-folder', compact('folders', 'authUser', 'userTenant', 'document'));
    }

    public function permissions(Folder $folder)
    {
        $authUser = Auth::user();
        $userdetails = $authUser->userDetail;

        if (!in_array($authUser->default_role, ['Secretary', 'Admin', 'IT Admin'])) {
            return redirect()->back()->with('error', 'Unauthorized access');
        }

        // $users = User::with('UserDetails')->where('tenant_id', $userdetails->tenant_id)->get();
        $users = User::with(['userDetail' => function($query) {
            $query->select('user_id', 'designation', 'department_id');
        }])
        ->whereHas('userDetail', function($q) use ($userdetails) {
            $q->where('tenant_id', $userdetails->tenant_id);
        })
        ->select('id', 'name', 'email')
        ->orderBy('name')
        ->get();
        return view('admin.folders.permissions', compact('folder', 'users', 'authUser'));
    }

    public function updatePermissions(Request $request, Folder $folder)
    {
        $authUser = Auth::user();
        $userdetails = $authUser->userDetail;

        if (!in_array($authUser->default_role, ['Secretary', 'Admin', 'IT Admin'])) {
            return redirect()->back()->with('error', 'Unauthorized access');
        }

        $validator = Validator::make($request->all(), [
            'is_private' => 'boolean',
            'permissions' => 'required_if:is_private,true|array',
            'permissions.*.user_id' => 'required|exists:users,id',
            'permissions.*.permission' => 'required|in:read,write,admin'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            // Update folder privacy
            $folder->update([
                'is_private' => $request->is_private ?? false
            ]);

            // Clear existing permissions
            $folder->users()->detach();

            // Add creator as admin by default
            $folder->users()->attach($authUser->id, ['permission' => 'admin']);

            // Add other user permissions if folder is private
            if ($request->is_private && $request->has('permissions')) {
                foreach ($request->permissions as $permission) {
                    if ($permission['user_id'] != $authUser->id) { // Don't add creator again
                        $folder->users()->attach($permission['user_id'], [
                            'permission' => $permission['permission']
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('folders.index')
                ->with(['message' => 'Folder permissions updated successfully', 'alert-type' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with(['message' => 'Error updating folder permissions: ' . $e->getMessage(), 'alert-type' => 'error'])
                ->withInput();
        }
    }
} 