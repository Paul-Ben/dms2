<?php

namespace App\Http\Controllers;

use App\Helpers\DocumentStorage;
use App\Helpers\UserAction;
use App\Models\Document;
use App\Models\DocumentRecipient;
use App\Models\FileMovement;
use App\Models\Tenant;
use App\Models\TenantDepartment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Expr\List_;
use Spatie\Permission\Models\Role;

class SuperAdminActions extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * User management Actions Index/create/edit/show/delete
     */
    public function user_index()
    {
        if (Auth::user()->default_role === 'superadmin') {
            $users = User::all();
            return view('superadmin.usermanager.index', compact('users'));
        }

        if (Auth::user()->default_role === 'Admin') {
            $users = User::where('tenant_id', Auth::user()->tenant_id)->where('default_role', '!=', 'superadmin')->get();
            return view('admin.usermanager.index', compact('users'));
        }

        return view('errors.404');
    }

    public function user_create()
    {
        if (Auth::user()->default_role === 'superadmin') {
            // $organisations = Tenant::with('tenant_departments')->get();
            // $roles = Role::where('name', '!=', Auth::user()->default_role)->get();
            // foreach ($organisations as $key => $value) {
            //     $departments = TenantDepartment::where('tenant_id', $value->id)->get();

            // }
        list($organisations, $roles) = UserAction::getOrganisationDetails();
        $departments = TenantDepartment::all();
            
            return view('superadmin.usermanager.create', compact('organisations', 'roles', 'departments'));
        }
        if (Auth::user()->default_role === 'Admin') {
            $organisations = Tenant::with('tenant_departments')->where('id', Auth::user()->tenant_id)->get();
            return view('admin.usermanager.create', compact('organisations'));
        }
        return view('errors.404');
    }

    public function getDepartments($organisationId)
    {
        $departments = TenantDepartment::where('organisation_id', $organisationId)->get();

        return response()->json($departments);
    }

    public function user_store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|integer',
        ]);

        // Create a new user instance
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->role_id = $request->input('role_id');


        $user->save();

        return redirect()->route('user.index')->with('success', 'User  created successfully.');
    }

    public function user_edit(User $user)
    {
        return view('admin.usermanager.edit', compact('user'));
    }

    public function user_update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8', // If you decide to use confirmation
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user->name = $request->input('name');
        $user->email = $request->input('email');

        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        $user->save();

        return redirect()->route('user.index')->with('success', 'User  updated successfully.');
    }

    public function user_delete(User $user)
    {
        $user->delete();
        return redirect()->route('user.index')->with('success', 'User  deleted successfully.');
    }

    /**Organisation Management */
    public function org_index()
    {
        if (Auth::user()->default_role === 'superadmin') {
            $organisations = Tenant::all();
            return view('superadmin.organisations.index', compact('organisations'));
        }

        return view('errors.404');
    }


    /**Document Management */
    public function document_index()
    {
        if (Auth::user()->default_role === 'superadmin') {
            $documents = DocumentStorage::myDocuments();
            return view('superadmin.documents.index', compact('documents'));
        }
        if (Auth::user()->default_role === 'Admin') {
            $documents = DocumentStorage::myDocuments();
            return view('admin.documents.index', compact('documents'));
        }
        if (Auth::user()->default_role === 'User') {
            $documents = DocumentStorage::myDocuments();
            return view('user.documents.index', compact('documents'));
        }
        if (Auth::user()->default_role === 'Staff') {
            $documents = DocumentStorage::myDocuments();
            return view('staff.documents.index', compact('documents'));
        }

        return view('errors.404');
    }

    public function document_create()
    {
        if (Auth::user()->default_role === 'superadmin') {
            return view('superadmin.documents.create');
        }
        if (Auth::user()->default_role === 'Admin') {
            return view('admin.documents.create');
        }
        if (Auth::user()->default_role === 'User') {
            return view('user.documents.create');
        }
        if (Auth::user()->default_role === 'Staff') {
            return view('staff.documents.create');
        }
        return view('errors.404');
    }

    public function document_store(Request $request)
    {
        $data = $request;
        $result = DocumentStorage::storeDocument($data);

        if ($result['status'] === 'error') {
            return redirect()->back()
                ->withErrors($result['errors'])
                ->withInput();
        }
        return redirect()->route('document.index')->with('success', 'Document uploaded successfully');
    }

    public function sent_documents()
    {
        if (Auth::user()->default_role === 'superadmin') {
            list($sent_documents, $recipient) = DocumentStorage::getSentDocuments();
            return view('superadmin.documents.sent', compact('sent_documents', 'recipient'));
        }
        if (Auth::user()->default_role === 'Admin') {
            list($sent_documents, $recipient) = DocumentStorage::getSentDocuments();

            return view('admin.documents.sent', compact('sent_documents', 'recipient'));
        }
        if (Auth::user()->default_role === 'User') {

            list($sent_documents, $recipient) = DocumentStorage::getSentDocuments();

            return view('user.documents.sent', compact('sent_documents', 'recipient'));
        }
        if (Auth::user()->default_role === 'Staff') {
            list($sent_documents, $recipient) = DocumentStorage::getSentDocuments();

            return view('staff.documents.sent', compact('sent_documents', 'recipient'));
        }
        return view('errors.404');
    }

    public function received_documents()
    {
        if (Auth::user()->default_role === 'superadmin') {
            list($received_documents, $sender) = DocumentStorage::getReceivedDocuments();
            return view('superadmin.documents.received', compact('received_documents', 'sender'));
        }
        if (Auth::user()->default_role === 'Admin') {
            list($received_documents, $sender) = DocumentStorage::getReceivedDocuments();
            return view('admin.documents.received', compact('received_documents', 'sender'));
        }
        if (Auth::user()->default_role === 'User') {
            list($received_documents, $sender) = DocumentStorage::getReceivedDocuments();

            return view('user.documents.received', compact('received_documents', 'sender'));
        }
        if (Auth::user()->default_role === 'Staff') {
            list($received_documents, $sender) = DocumentStorage::getReceivedDocuments();
            return view('staff.documents.received', compact('received_documents', 'sender'));
        }
        return view('errors.404');
    }

    public function viewDocument(Document $document)
    {
        $tenantId = $document->tenant_id;
        $departmentId = $document->department_id;
        $filePath = $document->file_path;

        $file = public_path('documents/' . $tenantId . '/' . $departmentId . '/' . $filePath);

        if (file_exists($file)) {
            return response()->file($file, [
                'Content-Disposition' => 'inline; filename="' . basename($file) . '"',
                'Content-Type' => 'application/pdf', // Paul-ben, Change this based on your file type
            ]);
        }

        abort(404);
    }

    public function getSendform(Request $request, Document $document)
    {
        if (Auth::user()->default_role === 'superadmin') {
            $recipients = User::all();
            return view('superadmin.documents.send', compact('recipients', 'document'));
        }
        if (Auth::user()->default_role === 'Admin') {
            $recipients = User::where('tenant_id', Auth::user()->tenant_id)->get();

            return view('admin.documents.send', compact('recipients', 'document'));
        }
        if (Auth::user()->default_role === 'User') {
            $recipients = User::where('default_role', 'Admin')->get();
            // dd($recipients);
            return view('user.documents.send', compact('recipients', 'document'));
        }
        if (Auth::user()->default_role === 'Staff') {
            $recipients = User::where('tenant_id', Auth::user()->tenant_id)->get();
            return view('staff.documents.send', compact('recipients', 'document'));
        }
        return view('errors.404');
    }

    public function sendDocument(Request $request)
    {
        $data = $request;
        $result = DocumentStorage::sendDocument($data);

        if ($result['status'] === 'error') {
            return redirect()->back()
                ->withErrors($result['errors'])
                ->withInput();
        }
        return redirect()->route('document.index')->with('success', 'Document sent successfully');
    }
}
