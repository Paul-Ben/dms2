<?php

namespace App\Http\Controllers;

use App\Helpers\DocumentStorage;
use App\Helpers\FileService;
use App\Helpers\UserAction;
use App\Helpers\UserFileDocument;
use App\Models\Designation;
use App\Models\Document;
use App\Models\DocumentRecipient;
use App\Models\FileMovement;
use App\Models\Tenant;
use App\Models\TenantDepartment;
use App\Models\User;
use App\Models\UserDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
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
            $users = User::orderBy('id', 'desc')->paginate(5);
            return view('superadmin.usermanager.index', compact('users'));
        }

        if (Auth::user()->default_role === 'Admin') {
            $id = Auth::user()->userDetail->tenant_id;
            $users = UserDetails::with('user')->where('tenant_id', $id)->get();

            return view('admin.usermanager.index', compact('users'));
        }

        return view('errors.404');
    }

    public function user_create()
    {
        if (Auth::user()->default_role === 'superadmin') {

            list($organisations, $roles, $departments, $designations) = UserAction::getOrganisationDetails();


            return view('superadmin.usermanager.create', compact('organisations', 'roles', 'departments', 'designations'));
        }
        if (Auth::user()->default_role === 'Admin') {
            $id = Auth::user()->userDetail->tenant_id;
            $departments = TenantDepartment::where('tenant_id', $id)->get();
            $designations = Designation::all();
            return view('admin.usermanager.create', compact('departments', 'designations'));
        }
        return view('errors.404');
    }

    public function getDepartments($organisationId)
    {
        $departments = TenantDepartment::where('tenant_id', $organisationId)->get();

        return response()->json($departments);
    }

    public function user_store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',

        ]);


        // Create a new user instance
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->default_role = $request->input('default_role');
        // Assign the user a role
        if ($request->input('default_role') === 'Admin') {
            // dd($request->input('default_role'));
            $user->assignRole('Admin');
        }
        if ($request->input('default_role') === 'Staff') {
            // dd($request->input('default_role'));
            $user->assignRole('Staff');
        }
        if ($request->input('default_role') === 'User') {
            // dd($request->input('default_role'));
            $user->assignRole('User');
        }


        $user->save();


        // if ($request->default_role === 'User') {
        $user->userDetail()->create([
            'user_id' => $user->id,
            'department_id' => $request->input('department_id'),
            'tenant_id' => $request->input('tenant_id'),
            'phone_number' => $request->input('phone_number'),
            'designation' => $request->input('designation'),
            'avatar' => $request->input('avatar'),
            'signature' => $request->input('signature'),
            'nin_number' => $request->input('nin_number'),

        ]);

        return redirect()->route('users.index')->with('success', 'User  created successfully.');
    }

    public function user_edit(User $user)
    {
        try {
            $user_details = User::with('userDetail')->where('id', $user->id)->first();


            list($organisations, $roles, $departments, $designations) = UserAction::getOrganisationDetails();

            return view('superadmin.usermanager.edit', compact('user', 'roles', 'organisations', 'departments', 'designations', 'user_details'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while fetching user details');
        }
    }

    public function user_update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
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
            $organisations = Tenant::orderBy('id', 'desc')->paginate(10);
            return view('superadmin.organisations.index', compact('organisations'));
        }

        return view('errors.404');
    }
    public function org_create()
    {
        if (Auth::user()->default_role === 'superadmin') {
            return view('superadmin.organisations.create');
        }

        return view('errors.404');
    }
    public function org_store(Request $request)
    {
        if (Auth::user()->default_role === 'superadmin') {
            $request->validate([
                'name' => 'required|string|max:255',
                'code' => 'required|string|max:255|unique:tenants',
                'email' => 'required|string|email|max:255|unique:tenants',
                'phone' => 'nullable|string|max:255',
                'category' => 'required|string',
                'address' => 'nullable|string',
                'status' => 'required|string',
            ]);

            $tenant = new Tenant();
            $tenant->name = $request->input('name');
            $tenant->code = $request->input('code');
            $tenant->email = $request->input('email');
            $tenant->phone = $request->input('phone');
            $tenant->category = $request->input('category');
            $tenant->address = $request->input('address');
            $tenant->status = $request->input('status');

            $tenant->save();

            return redirect()->route('organisation.index')->with('success', 'Organisation created successfully.');
        }
        return view('errors.404');
    }
    public function org_edit(Tenant $tenant)
    {
        if (Auth::user()->default_role === 'superadmin') {

            return view('superadmin.organisations.edit', compact('tenant'));
        }
        return view('errors.404');
    }
    public function org_update(Request $request, Tenant $tenant)
    {
        if (Auth::user()->default_role === 'superadmin') {
            $request->validate([
                'name' => 'required|string|max:255',
                'code' => 'required|string|max:255|unique:tenants,code,' . $tenant->id,
                'email' => 'required|string|email|max:255|unique:tenants,email,' . $tenant->id,
                'phone' => 'nullable|string|max:255',
                'category' => 'required|string',
                'address' => 'nullable|string',
                'status' => 'required|string',
            ]);
            $tenant->name = $request->input('name');
            $tenant->code = $request->input('code');
            $tenant->email = $request->input('email');
            $tenant->phone = $request->input('phone');
            $tenant->category = $request->input('category');
            $tenant->address = $request->input('address');
            $tenant->status = $request->input('status');
            $tenant->save();
            return redirect()->route('organisation.index')->with('success', 'Organisation updated successfully.');
        }
        return view('errors.404');
    }
    public function org_delete(Tenant $tenant)
    {
        if (Auth::user()->default_role === 'superadmin') {
            $tenant->delete();
            return redirect()->route('organisation.index')->with('success', 'Organisation deleted successfully.');
        }
        return view('errors.404');
    }


    /**Document Management */
    public function document_index()
    {
        if (Auth::user()->default_role === 'superadmin') {
            $documents = DocumentStorage::myDocuments();
            toastr('success', 'Document sent.');
            return view('superadmin.documents.index', compact('documents'));
        }
        if (Auth::user()->default_role === 'Admin') {
            $documents = DocumentStorage::myDocuments();
            toastr('success', 'Document sent.');
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


    public function user_file_document()
    {
        if (Auth::user()->default_role === 'User') {
            $recipients = DocumentStorage::getUserRecipients();

            return view('user.documents.filedocument', compact('recipients'));
        }
        return view('errors.404');
    }

    public function user_store_file_document(Request $request)
    {
        // Store the initial data in the session or temporary storage
        $data = $request;
        $result = UserFileDocument::userFileDocument($data);

        // Define the payment link
        $link = "https://app.credodemo.com/pay/benuee-state-digital-infrastructure-company-plc";

        // Append a callback URL to the payment link
        $callbackUrl = route('payment.callback');
        $linkWithCallback = $link . "?callbackUrl=" . urlencode($callbackUrl);

        // Redirect to the payment link
        return redirect($linkWithCallback)->with('success', 'Document uploaded and sent successfully');
    }
    public function paymentCallback(Request $request)
    {
        // Retrieve the necessary data from the request or session
        $data = session()->get('document_data');

        // Verify payment status (if needed)
        $paymentStatus = $request->query('status');

        if ($paymentStatus === 'success') {
            // Process the document upload or related logic

            // Redirect to the document index with a success message
            toastr('success', 'Document uploaded and sent successfully' );
            return redirect()->route('document.index')->with('success', 'Document uploaded and sent successfully');
        }
        // $response = UserFileDocument::undoDocumentActions();
        // Handle failed payment
        return redirect()->route('document.index')->with('error', 'Payment failed. Please try again.');
    }

    public function document_show($received)
    {
        if (Auth::user()->default_role === 'superadmin') {
            $document_received =  FileMovement::with(['sender', 'recipient', 'document'])->where('id', $received)->first();

            return view('superadmin.documents.show', compact('document_received'));
        }
        if (Auth::user()->default_role === 'Admin') {
            $document_received =  FileMovement::with(['sender', 'recipient', 'document'])->where('id', $received)->first();

            return view('admin.documents.show', compact('document_received'));
        }
        if (Auth::user()->default_role === 'User') {
            $document_received =  FileMovement::with(['sender', 'recipient', 'document'])->where('id', $received)->first();

            return view('user.documents.show', compact('document_received'));
        }
        if (Auth::user()->default_role === 'Staff') {
            $document_received =  FileMovement::with(['sender', 'recipient', 'document'])->where('id', $received)->first();

            return view('staff.documents.show', compact('document_received'));
        }
        return view('errors.404');
    }
    public function document_show_sent($sent)
    {
        if (Auth::user()->default_role === 'superadmin') {
            $document_received =  FileMovement::with(['sender', 'recipient', 'document'])->where('id', $sent)->first();

            return view('superadmin.documents.show', compact('document_received'));
        }
        if (Auth::user()->default_role === 'Admin') {
            $document_received =  FileMovement::with(['sender', 'recipient', 'document'])->where('id', $sent)->first();

            return view('admin.documents.show', compact('document_received'));
        }
        if (Auth::user()->default_role === 'User') {
            $document_received =  FileMovement::with(['sender', 'recipient', 'document'])->where('id', $sent)->first();

            return view('user.documents.show', compact('document_received'));
        }
        if (Auth::user()->default_role === 'Staff') {
            $document_received =  FileMovement::with(['sender', 'recipient', 'document'])->where('id', $sent)->first();

            return view('staff.documents.show', compact('document_received'));
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
        toastr('success', 'Document Uploaded!!');
        return redirect()->route('document.index')->with('success', 'Document uploaded successfully');
    }

    public function sent_documents()
    {
        if (Auth::user()->default_role === 'superadmin') {

            list($sent_documents, $recipient) = DocumentStorage::getSentDocuments();
            $mda = UserDetails::with('tenant')->where('id', $recipient[0]->id)->get();

            return view('superadmin.documents.sent', compact('sent_documents', 'recipient', 'mda'));
        }
        if (Auth::user()->default_role === 'Admin') {
            list($sent_documents, $recipient) = DocumentStorage::getSentDocuments();
            // $mda = UserDetails::with('tenant')->where('id', $recipient[0]->id)->get();
            $mda = UserDetails::with('tenant')->where('id', $recipient[0]->id)->firstOrFail();
            // dd($mda);
            return view('admin.documents.sent', compact('sent_documents', 'recipient', 'mda'));
        }
        if (Auth::user()->default_role === 'User') {

            list($sent_documents, $recipient) = DocumentStorage::getSentDocuments();
            $mda = UserDetails::with('tenant')->where('id', $recipient[0]->id)->get();
           
            return view('user.documents.sent', compact('sent_documents', 'recipient', 'mda'));
        }
        if (Auth::user()->default_role === 'Staff') {
            list($sent_documents, $recipient) = DocumentStorage::getSentDocuments();
            $mda = UserDetails::with('tenant')->where('id', $recipient[0]->id)->get();

            return view('staff.documents.sent', compact('sent_documents', 'recipient', 'mda'));
        }
        return view('errors.404');
    }

    public function received_documents()
    {
        if (Auth::user()->default_role === 'superadmin') {
            list($received_documents) = DocumentStorage::getReceivedDocuments();
            // dd($received_documents);
            return view('superadmin.documents.received', compact('received_documents'));
        }
        if (Auth::user()->default_role === 'Admin') {
            list($received_documents) = DocumentStorage::getReceivedDocuments();
            // dd($received_documents);
            return view('admin.documents.received', compact('received_documents'));
        }
        if (Auth::user()->default_role === 'User') {
            list($received_documents) = DocumentStorage::getReceivedDocuments();

            return view('user.documents.received', compact('received_documents'));
        }
        if (Auth::user()->default_role === 'Staff') {
            list($received_documents) = DocumentStorage::getReceivedDocuments();
            return view('staff.documents.received', compact('received_documents'));
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

    public function getReplyform(Request $request, Document $document)
    {
        if (Auth::user()->default_role === 'Admin') {
            $authUser = Auth::user();

            $getter = FileMovement::where('document_id', $document->id)->where('recipient_id', $authUser->id)->get();
            $recipients = User::where('id', $getter[0]->sender_id)->get();


            return view('staff.documents.reply', compact('recipients', 'document'));
        }
        if (Auth::user()->default_role === 'Staff') {
            $authUser = Auth::user();

            $getter = FileMovement::where('document_id', $document->id)->where('recipient_id', $authUser->id)->get();
            $recipients = User::where('id', $getter[0]->sender_id)->get();


            return view('staff.documents.reply', compact('recipients', 'document'));
        }
        return view('errors.404');
    }

    public function getSendform(Request $request, Document $document)
{
    $authUser = Auth::user();
    $role = $authUser->default_role;

    switch ($role) {
        case 'superadmin':
            $recipients = User::all();
            return view('superadmin.documents.send', compact('recipients', 'document'));

        case 'Admin':
            $tenantId = $authUser->userDetail->tenant_id ?? null;

            if (!$tenantId) {
                return redirect()->back()->with('error', 'Tenant information is missing.');
            }

            $recipients = User::with(['userDetail.tenant' => function ($query) {
                $query->select('id', 'name'); // Include only relevant columns
            }])
                ->whereHas('userDetail', function ($query) use ($tenantId) {
                    $query->where('tenant_id', $tenantId); // Users in the same tenant
                })
                ->orWhere('default_role', 'Admin') // Admins in other tenants
                ->get();

            if ($recipients->isEmpty()) {
                return redirect()->back()->with('error', 'No recipients found.');
            }

            return view('admin.documents.send', compact('recipients', 'document'));

        case 'User':
            $recipients = User::where('default_role', 'Admin')->get();
            return view('user.documents.send', compact('recipients', 'document'));

        case 'Staff':
            $tenantId = $authUser->userDetail->tenant_id ?? null;

            if (!$tenantId) {
                return redirect()->back()->with('error', 'Tenant information is missing.');
            }

            // $recipients = User::with('userDetail')
            //     ->whereHas('userDetail', function ($query) use ($tenantId) {
            //         $query->where('tenant_id', $tenantId);
            //     })
            //     ->where('id', '!=', $authUser->id)
            //     ->get();
            $recipients = User::with(['userDetail' => function ($query) {
                $query->select('id', 'user_id', 'designation', 'tenant_id');
            }])
            ->whereHas('userDetail', function ($query) use ($tenantId) {
                $query->where('tenant_id', $tenantId);
            })
            ->where('id', '!=', $authUser->id)
            ->get();
    

            if ($recipients->isEmpty()) {
                return redirect()->back()->with('error', 'No recipients found.');
            }

            return view('staff.documents.send', compact('recipients', 'document'));

        default:
            return redirect()->route('dashboard')->with('error', 'Unauthorized access.');
    }
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
        toastr('success', 'Document sent successfully.');
        return redirect()->route('document.index')->with('success', 'Document sent successfully');
    }

    /**Department Management */
    public function department_index()
    {
        if (Auth::user()->default_role === 'superadmin') {
            $departments = TenantDepartment::orderBy('id', 'desc')->paginate(10);
            return view('superadmin.departments.index', compact('departments'));
        }
        return view('errors.404');
    }
    public function department_create()
    {
        if (Auth::user()->default_role === 'superadmin') {
            $organisations = Tenant::all();
            return view('superadmin.departments.create', compact('organisations'));
        }
        return view('errors.404');
    }
    public function department_store(Request $request)
    {
        if (Auth::user()->default_role === 'superadmin') {
            $request->validate([
                'name' => 'required|string|max:255',
                'tenant_id' => 'required|exists:tenants,id',
            ]);
            $department = TenantDepartment::create($request->all());

            return redirect()->route('department.index')->with('success', 'Department created successfully.');
        }
        return view('errors.404');
    }
}
