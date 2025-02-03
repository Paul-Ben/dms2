<?php

namespace App\Http\Controllers;

use App\Helpers\DocumentStorage;
use App\Helpers\FileService;
use App\Helpers\SendMailHelper;
use App\Helpers\StampHelper;
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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Expr\List_;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendNotificationMail;
use App\Mail\ReceiveNotificationMail;
use App\Models\Attachments;
use Exception;

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
        $authUser = Auth::user();
        if (Auth::user()->default_role === 'superadmin') {
            $users = User::orderBy('id', 'desc')->paginate(5);
            return view('superadmin.usermanager.index', compact('users', 'authUser'));
        }

        if (Auth::user()->default_role === 'Admin') {
            $id = Auth::user()->userDetail->tenant_id;
            $users = UserDetails::with('user')->where('tenant_id', $id)->get();

            return view('admin.usermanager.index', compact('users', 'authUser'));
        }

        return view('errors.404', compact('authUser'));
    }

    public function user_create()
    {
        $authUser = Auth::user();
        if (Auth::user()->default_role === 'superadmin') {

            list($organisations, $roles, $departments, $designations) = UserAction::getOrganisationDetails();

            return view('superadmin.usermanager.create', compact('organisations', 'roles', 'departments', 'designations', 'authUser'));
        }
        if (Auth::user()->default_role === 'Admin') {
            $id = Auth::user()->userDetail->tenant_id;
            $departments = TenantDepartment::where('tenant_id', $id)->get();
            $designations = Designation::all();
            $roles = Role::whereNotIn('name', [Auth::user()->default_role, 'superadmin', 'User'])->get();

            return view('admin.usermanager.create', compact('departments', 'designations', 'roles', 'authUser'));
        }
        return view('errors.404', compact('authUser'));
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

        $notification = [
            'message' => 'User created successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('users.index')->with($notification);
    }

    public function user_edit(User $user)
    {
        try {
            $authUser = Auth::user();
            if (Auth::user()->default_role === 'superadmin') {
                $user_details = User::with('userDetail')->where('id', $user->id)->first();
                list($organisations, $roles, $departments, $designations) = UserAction::getOrganisationDetails();

                return view('superadmin.usermanager.edit', compact('user', 'roles', 'organisations', 'departments', 'designations', 'user_details', 'authUser'));
            }
            if (Auth::user()->default_role === 'Admin') {
                $user_details = User::with('userDetail')->where('id', $user->id)->first();
                list($organisations, $roles, $departments, $designations) = UserAction::getOrganisationDetails();

                return view('admin.usermanager.edit', compact('user', 'roles', 'organisations', 'departments', 'designations', 'user_details', 'authUser'));
            }
            return view('errors.404', compact('authUser'));
            // $user_details = User::with('userDetail')->where('id', $user->id)->first();


            // list($organisations, $roles, $departments, $designations) = UserAction::getOrganisationDetails();

            // return view('superadmin.usermanager.edit', compact('user', 'roles', 'organisations', 'departments', 'designations', 'user_details'));
        } catch (\Exception $e) {
            Log::error('Error while fetching user details: ' . $e->getMessage());
            $notification = [
                'message' => 'Error while fetching user details',
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($notification);
        }
    }

    public function user_update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'sometimes|required|string|min:8',
            'nin_number' => 'sometimes|string',
            'phone_number' => 'sometimes|string',
            'avatar' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'default_role' => 'required|string',
            'designation' => 'required|string',
            'tenant_id' => 'required|integer',
            'department_id' => 'required|integer',
            'gender' => 'required|string',
            'signature' => 'sometimes|string',
        ]);

        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'default_role' => $request->input('default_role'),
        ]);

        if ($request->input('password')) {
            $user->update([
                'password' => Hash::make($request->input('password')),
            ]);
        }

        $userDetail = $user->userDetail;

        if (!$userDetail) {
            $userDetail = new UserDetails();
            $userDetail->user_id = $user->id;
        }

        $userDetail->update([
            'nin_number' => $request->input('nin_number'),
            'phone_number' => $request->input('phone_number'),
            'designation' => $request->input('designation'),
            'tenant_id' => $request->input('tenant_id'),
            'department_id' => $request->input('department_id'),
            'gender' => $request->input('gender'),
            'signature' => $request->input('signature'),
        ]);

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
            $avatar->storeAs('public/avatars', $avatarName);
            $userDetail->update([
                'avatar' => $avatarName,
            ]);
        }
        $notification = [
            'message' => 'User updated successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('users.index')->with($notification);
    }

    public function user_delete(User $user)
    {
        $user->delete();
        return redirect()->route('user.index')->with('success', 'User  deleted successfully.');
    }

    /**Organisation Management */
    public function org_index()
    {
        $authUser = Auth::user();
        if (Auth::user()->default_role === 'superadmin') {
            $organisations = Tenant::orderBy('id', 'desc')->paginate(10);
            return view('superadmin.organisations.index', compact('organisations', 'authUser'));
        }

        return view('errors.404', compact('authUser'));
    }
    public function org_create()
    {
        $authUser = Auth::user();
        if (Auth::user()->default_role === 'superadmin') {
            return view('superadmin.organisations.create', compact('authUser'));
        }

        return view('errors.404', compact('authUser'));
    }
    public function org_store(Request $request)
    {
        $authUser = Auth::user();
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
            $notification = [
                'message' => 'Organisation created successfully',
                'alert-type' => 'success'
            ];
            return redirect()->route('organisation.index')->with($notification);
        }
        return view('errors.404', compact('authUser'));
    }


    public function org_edit(Tenant $tenant)
    {
        $authUser = Auth::user();
        if (Auth::user()->default_role === 'superadmin') {

            return view('superadmin.organisations.edit', compact('tenant', 'authUser'));
        }
        return view('errors.404', compact('authUser'));
    }


    public function org_update(Request $request, Tenant $tenant)
    {
        $authUser = Auth::user();
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
            $notification = [
                'message' => 'Organisation updated successfully',
                'alert-type' => 'success'
            ];
            return redirect()->route('organisation.index')->with($notification);
        }
        return view('errors.404', compact('authUser'));
    }


    public function org_delete(Tenant $tenant)
    {
        $authUser = Auth::user();
        if (Auth::user()->default_role === 'superadmin') {
            $tenant->delete();
            $notification = [
                'message' => 'Organisation deleted successfully',
                'alert-type' => 'success'
            ];
            return redirect()->route('organisation.index')->with($notification);
        }
        return view('errors.404', compact('authUser'));
    }


    /**Document Management */
    public function document_index()
    {
        $authUser = Auth::user();
        if (Auth::user()->default_role === 'superadmin') {
            $documents = DocumentStorage::myDocuments();

            return view('superadmin.documents.index', compact('documents', 'authUser'));
        }
        if (Auth::user()->default_role === 'Admin') {
            $documents = DocumentStorage::myDocuments();
            // dd($documents);
            return view('admin.documents.index', compact('documents', 'authUser'));
        }
        if (Auth::user()->default_role === 'Secretary') {
            $documents = DocumentStorage::myDocuments();
            return view('secretary.documents.index', compact('documents', 'authUser'));
        }
        if (Auth::user()->default_role === 'User') {
            $documents = DocumentStorage::myDocuments();
            return view('user.documents.index', compact('documents', 'authUser'));
        }
        if (Auth::user()->default_role === 'Staff') {
            $documents = DocumentStorage::myDocuments();

            return view('staff.documents.index', compact('documents', 'authUser'));
        }

        return view('errors.404', compact('authUser'));
    }

    public function document_create()
    {
        $authUser = Auth::user();
        if (Auth::user()->default_role === 'superadmin') {
            return view('superadmin.documents.create', compact('authUser'));
        }
        if (Auth::user()->default_role === 'Admin') {
            return view('admin.documents.create', compact('authUser'));
        }
        if (Auth::user()->default_role === 'Secretary') {
            return view('admin.documents.create', compact('authUser'));
        }
        if (Auth::user()->default_role === 'User') {
            return view('user.documents.create', compact('authUser'));
        }
        if (Auth::user()->default_role === 'Staff') {
            return view('staff.documents.create', compact('authUser'));
        }
        return view('errors.404', compact('authUser'));
    }


    public function user_file_document()
    {
        $authUser = Auth::user();
        if (Auth::user()->default_role === 'User') {
            $recipients = DocumentStorage::getUserRecipients();
            // dd($recipients);
            return view('user.documents.filedocument', compact('recipients', 'authUser'));
        }
        return view('errors.404', compact('authUser'));
    }

    public function user_store_file_document(Request $request)
    {
        // Store the initial data in the session or temporary storage
        $data = $request;
        // session()->put('document_data', $data);
        $result = UserFileDocument::userFileDocument($data);

        $senderName = Auth::user()->name;
        // $receiverName = User::find($data->recipient_id)?->name;
        $receiverName = User::find($data->recipient_id)?->name;
        $documentName = $request->title;
        $documentId = $request->document_number;
        $appName = config('app.name');

        try {
            Mail::to(Auth::user()->email)->send(new SendNotificationMail($senderName, $receiverName,  $documentName, $appName));
            Mail::to(User::find($data->recipient_id)?->email)->send(new ReceiveNotificationMail($senderName, $receiverName, $documentName, $documentId, $appName));
        } catch (\Exception $e) {
            Log::error('Failed to send Document notification');
        }

        // Define the payment link
        $link = "https://app.credodemo.com/pay/benuee-state-digital-infrastructure-company-plc";

        // Append a callback URL to the payment link
        $callbackUrl = route('payment.callback');
        $linkWithCallback = $link . "?callbackUrl=" . urlencode($callbackUrl);

        // Redirect to the payment link
        return redirect($linkWithCallback)->with('success', 'Document uploaded and sent successfully');
    }
    
    // public function user_store_file_document(Request $request)
    // {
    //     // $request->validate([
    //     //     'title' => 'required|string|max:255',
    //     //     'document_number' => 'required|string|max:50|unique:user_file_documents,document_number',
    //     //     'recipient_id' => 'required|exists:users,id',
    //     // ]);

    //     $data = $request->all();
    //     $jsonData = json_encode($data);
    //     // $result = UserFileDocument::userFileDocument($data);
        

    //     //     $documentName = $request->title;
    //     $documentId = $request->document_number;
    //     //     $appName = config('app.name');
    //     $senderName = Auth::user()->name;
    //     $receiverName = User::find($data['recipient_id'])?->name;
    //     $amount = 3000;

    //     try {
    //         $response = $this->initializePayment(Auth::user()->email, $senderName, $receiverName, $documentId, $amount, $jsonData, route("payment.callback"));

    //         if ($response->successful()) {
    //             $responseData = $response->json('data');
    //             if (isset($responseData['authorizationUrl'])) {
    //                 return redirect($responseData['authorizationUrl'])
    //                     ->with('success', 'Redirecting to the payment gateway...');
    //             }
    //         }

    //         return redirect()->back()->with([
    //             'message' => 'Credo E-Tranzact gateway service took too long to respond.',
    //             'alert-type' => 'error',
    //         ]);
    //     } catch (Exception $e) {
    //         Log::error('Error initializing payment gateway: ' . $e->getMessage());
    //         return redirect()->back()->with([
    //             'message' => 'Error initializing payment gateway. Please try again.',
    //             'alert-type' => 'error',
    //         ]);
    //     }
    // }

    // private function initializePayment($email, $senderName, $receiverName, $documentId, $amount, $jsonData, $callbackUrl)
    // {
    //     return Http::accept('application/json')
    //         ->withHeaders([
    //             'Authorization' => env('CREDO_PUBLIC_KEY'),
    //             'Content-Type' => 'application/json',
    //         ])
    //         ->timeout(10)
    //         ->retry(3, 1000)
    //         ->post(env('CREDO_URL') . '/transaction/initialize', [
    //             "email" => $email,
    //             "senderName" => $senderName,
    //             "receiverName" => $receiverName,
    //             "reference" => $documentId,
    //             "amount" => $amount * 100,
    //             "metadata" => $jsonData,
    //             "callbackUrl" => $callbackUrl,
    //             "bearer" => 0,
    //         ]);
    // }

    // public function paymentCallback(Request $request)
    // {

    //     // Validate the callback request
    //     $validated = $request->validate([
    //         'reference' => 'required|string',
    //     ]);
    //     $data = $request->all();
    //     $reference = $validated['reference'];
    //     // dd($data);
    //     try {
    //         // Confirm the transaction with the payment gateway
    //         $response = Http::accept('application/json')
    //             ->withHeaders([
    //                 'Authorization' => env('CREDO_SECRET_KEY'),
    //             ])
    //             ->get(env('CREDO_URL') . "/transaction/{$reference}/verify");

    //         if ($response->successful()) {
    //             $paymentData = $response->json('data');
    //             $data = json_decode($paymentData['metadata'], true);
    //             dd($data);
    //             // Check if payment is successful
    //             if ($paymentData['status'] === 'success') {
    //                 // Extract relevant details
    //                 $paymentDetails = [
    //                     'transaction_id' => $paymentData['transactionId'],
    //                     'reference' => $paymentData['reference'],
    //                     'amount' => $paymentData['amount'] / 100, // Convert to original currency
    //                     'email' => $paymentData['customer']['email'],
    //                     'status' => $paymentData['status'],
    //                     'paid_at' => $paymentData['paidAt'],
    //                 ];

    //                 // Store payment details in the database
    //                 // Payment::updateOrCreate(
    //                 //     ['reference' => $paymentDetails['reference']],
    //                 //     $paymentDetails
    //                 // );

    //                 // Generate receipt (customize as needed)
    //                 $receipt = [
    //                     'receipt_no' => strtoupper(uniqid('RCPT-')),
    //                     'transaction_id' => $paymentDetails['transaction_id'],
    //                     'reference' => $paymentDetails['reference'],
    //                     'amount' => $paymentDetails['amount'],
    //                     'paid_at' => $paymentDetails['paid_at'],
    //                     'email' => $paymentDetails['email'],
    //                 ];

    //                 // Render or save receipt
    //                 return view('payments.receipt', compact('receipt'));
    //             } else {
    //                 return redirect()->route('payment.failed')->withErrors('Payment was not successful.');
    //             }
    //         } else {
    //             throw new Exception('Failed to verify payment.');
    //         }
    //     } catch (Exception $e) {
    //         Log::error('Payment Callback Error: ' . $e->getMessage());
    //         return redirect()->route('payment.failed')->withErrors('Payment verification failed.');
    //     }
    // }


    public function paymentCallback(Request $request)
    {

        // Retrieve the necessary data from the request or session
        $data = session()->get('document_data');

        // Verify payment status (if needed)
        $paymentStatus = $request->query('status');

        if ($paymentStatus === 'success') {
            // Process the document upload or related logic
            $result = UserFileDocument::userFileDocument($data);
            // $response = UserFileDocument::undoDocumentActions($data);
            // session()->forget('document_data');

            $notification = array(
                'message' => 'Document uploaded and sent successfully.',
                'alert-type' => 'success'
            );
            return redirect()->route('document.sent')->with($notification);
        }

        // Handle failed payment
        // $notification = array(
        //     'message' => 'Payment failed. Please try again.',
        //     'alert-type' => 'error'
        // );
        // Handle failed payment
        $notification = array(
            'message' => 'Document uploaded and sent successfully. Payment confirmed.',
            'alert-type' => 'success'
        );
        return redirect()->route('document.index')->with($notification);
    }

    /**Show a document to the user */
    public function document_show($received, Document $document)
    {
        $authUser = Auth::user();
        if (Auth::user()->default_role === 'superadmin') {
            $document_received =  FileMovement::with(['sender', 'recipient', 'document'])->where('id', $received)->first();

            return view('superadmin.documents.show', compact('document_received', 'authUser'));
        }
        if (Auth::user()->default_role === 'Admin') {
            $document_received =  FileMovement::with(['sender', 'recipient', 'document', 'attachments'])->where('id', $received)->first();
            $document_locations = FileMovement::with(['document', 'sender.userDetail', 'recipient.userDetail.tenant_department'])->where('document_id', $document_received->document_id)->get();
           
            return view('admin.documents.show', compact('document_received', 'document_locations', 'authUser'));
        }
        if (Auth::user()->default_role === 'Secretary') {
            $document_received =  FileMovement::with(['sender', 'recipient', 'document', 'attachments'])->where('id', $received)->first();
            $document_locations = FileMovement::with(['document', 'sender.userDetail', 'recipient.userDetail.tenant_department'])->where('document_id', $document_received->document_id)->get();

            return view('secretary.documents.show', compact('document_received', 'document_locations', 'authUser'));
        }
        if (Auth::user()->default_role === 'User') {
            $document_received =  FileMovement::with(['sender', 'recipient', 'document', 'attachments'])->where('id', $received)->first();

            return view('user.documents.show', compact('document_received', 'authUser'));
        }
        if (Auth::user()->default_role === 'Staff') {
            $document_received =  FileMovement::with(['sender', 'recipient', 'document', 'attachments'])->where('id', $received)->first();

            $document_locations = FileMovement::with(['document', 'sender.userDetail', 'recipient.userDetail.tenant_department'])->where('document_id', $document_received->document_id)->get();

            return view('staff.documents.show', compact('document_received', 'document_locations', 'authUser'));
        }
        return view('errors.404', compact('authUser'));
    }


    public function document_show_sent($sent)
    {
        $authUser = Auth::user();
        if (Auth::user()->default_role === 'superadmin') {
            $document_received =  FileMovement::with(['sender', 'recipient', 'document'])->where('id', $sent)->first();

            return view('superadmin.documents.show', compact('document_received', 'authUser'));
        }
        if (Auth::user()->default_role === 'Admin') {
            $document_received =  FileMovement::with(['sender', 'recipient', 'document'])->where('id', $sent)->first();

            return view('admin.documents.show', compact('document_received', 'authUser'));
        }
        if (Auth::user()->default_role === 'Secretary') {
            $document_received =  FileMovement::with(['sender', 'recipient', 'document'])->where('id', $sent)->first();

            return view('admin.documents.show', compact('document_received', 'authUser'));
        }
        if (Auth::user()->default_role === 'User') {
            $document_received =  FileMovement::with(['sender', 'recipient', 'document'])->where('id', $sent)->first();

            return view('user.documents.show', compact('document_received', 'authUser'));
        }
        if (Auth::user()->default_role === 'Staff') {
            $document_received =  FileMovement::with(['sender', 'recipient', 'document'])->where('id', $sent)->first();

            return view('staff.documents.show', compact('document_received', 'authUser'));
        }
        return view('errors.404', compact('authUser'));
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
        $notification = array(
            'message' => 'Document uploaded successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('document.index')->with($notification);
    }

    public function sent_documents()
    {
        $authUser = Auth::user();
        if (Auth::user()->default_role === 'superadmin') {

            list($sent_documents, $recipient) = DocumentStorage::getSentDocuments();

            if (!empty($recipient) && isset($recipient[0])) {
                $mda = UserDetails::with('tenant')->where('id', $recipient[0]->id)->get();
            } else {
                // Handle the case when $recipient is null or empty
                $mda = collect(); // Return an empty collection
            }

            return view('superadmin.documents.sent', compact('sent_documents', 'recipient', 'mda', 'authUser'));
        }
        if (Auth::user()->default_role === 'Admin') {
            list($sent_documents, $recipient) = DocumentStorage::getSentDocuments();

            return view('admin.documents.sent', compact('sent_documents', 'recipient', 'authUser'));
        }
        if (Auth::user()->default_role === 'Secretary') {
            list($sent_documents, $recipient) = DocumentStorage::getSentDocuments();
            return view('secretary.documents.sent', compact('sent_documents', 'recipient', 'authUser'));
        }
        if (Auth::user()->default_role === 'User') {

            list($sent_documents, $recipient) = DocumentStorage::getSentDocuments();

            // Check if $recipient is null or empty
            if (!empty($recipient) && isset($recipient[0])) {
                $mda = UserDetails::with('tenant')->where('id', $recipient[0]->id)->get();
            } else {
                // Handle the case when $recipient is null or empty
                $mda = collect(); // Return an empty collection
            }

            return view('user.documents.sent', compact('sent_documents', 'recipient', 'mda', 'authUser'));
        }
        if (Auth::user()->default_role === 'Staff') {
            list($sent_documents, $recipient) = DocumentStorage::getSentDocuments();

            if (!empty($recipient) && isset($recipient[0])) {
                $mda = UserDetails::with(['tenant', 'tenant_department'])->where('id', $recipient[0]->id)->get();
            } else {
                // Handle the case when $recipient is null or empty
                $mda = collect(); // Return an empty collection
            }
           
            return view('staff.documents.sent', compact('sent_documents', 'recipient', 'mda', 'authUser'));
        }
        return view('errors.404', compact('authUser'));
    }

    public function received_documents()
    {
        $authUser = Auth::user();
        if (Auth::user()->default_role === 'superadmin') {
            list($received_documents) = DocumentStorage::getReceivedDocuments();

            return view('superadmin.documents.received', compact('received_documents', 'authUser'));
        }
        if (Auth::user()->default_role === 'Admin') {
            list($received_documents) = DocumentStorage::getReceivedDocuments();

            return view('admin.documents.received', compact('received_documents', 'authUser'));
        }
        if (Auth::user()->default_role === 'Secretary') {
            list($received_documents) = DocumentStorage::getReceivedDocuments();

            return view('secretary.documents.received', compact('received_documents', 'authUser'));
        }
        if (Auth::user()->default_role === 'User') {
            list($received_documents) = DocumentStorage::getReceivedDocuments();

            return view('user.documents.received', compact('received_documents', 'authUser'));
        }
        if (Auth::user()->default_role === 'Staff') {
            list($received_documents) = DocumentStorage::getReceivedDocuments();
           
            return view('staff.documents.received', compact('received_documents', 'authUser'));
        }
        return view('errors.404', compact('authUser'));
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
        $authUser = Auth::user();
        if (Auth::user()->default_role === 'Admin') {
            $authUser = Auth::user();

            $getter = FileMovement::where('document_id', $document->id)->where('recipient_id', $authUser->id)->get();
            $recipients = User::where('id', $getter[0]->sender_id)->get();


            return view('staff.documents.reply', compact('recipients', 'document', 'authUser'));
        }
        if (Auth::user()->default_role === 'Secretary') {
            $authUser = Auth::user();

            $getter = FileMovement::where('document_id', $document->id)->where('recipient_id', $authUser->id)->get();
            $recipients = User::where('id', $getter[0]->sender_id)->get();


            return view('staff.documents.reply', compact('recipients', 'document', 'authUser'));
        }
        if (Auth::user()->default_role === 'Staff') {
            $authUser = Auth::user();

            $getter = FileMovement::where('document_id', $document->id)->where('recipient_id', $authUser->id)->get();
            $recipients = User::where('id', $getter[0]->sender_id)->get();


            return view('staff.documents.reply', compact('recipients', 'document', 'authUser'));
        }
        return view('errors.404', compact('authUser'));
    }

    public function getSendExternalForm(Request $request, Document $document)
    {
        $authUser = Auth::user();
        if (Auth::user()->default_role === 'Admin') {
            $recipients = User::with(['userDetail.tenant' => function ($query) {
                $query->select('id', 'name'); // Include only relevant columns
            }])
                ->where('default_role', 'Admin') // Admins in other tenants
                ->get();

            if ($recipients->isEmpty()) {
                $notification = [
                    'message' => 'No recipients found.',
                    'alert-type' => 'error'
                ];
                return redirect()->back()->with($notification);
            }
            return view('admin.documents.send_external', compact('recipients', 'document', 'authUser'));
        }
        $notification = [
            'message' => 'You do not have permission to send external documents.',
            'alert-type' => 'error'
        ];
        return view('errors.404', compact('authUser'))->with($notification);
    }

    public function getSendform(Request $request, Document $document)
    {
        $authUser = Auth::user();
        $role = $authUser->default_role;

        switch ($role) {
            case 'superadmin':
                $recipients = User::all();
                return view('superadmin.documents.send', compact('recipients', 'document', 'authUser'));

            case 'Admin':
                $tenantId = $authUser->userDetail->tenant_id ?? null;
                $document_locations = FileMovement::with(['document', 'sender.userDetail', 'recipient.userDetail.tenant_department'])->where('document_id', $document->id)->get();

                if (!$tenantId) {
                    return redirect()->back()->with('error', 'Tenant information is missing.');
                }

                $recipients = User::select('id', 'name')
                    ->with(['userDetail' => function ($query) {
                        $query->select('id', 'user_id', 'designation', 'tenant_id', 'department_id')
                            ->with('tenant_department:id,name'); // Load department name
                    }])
                    ->whereHas('userDetail', function ($query) use ($tenantId) {
                        $query->where('tenant_id', $tenantId);
                    })
                    ->where('id', '!=', $authUser->id)
                    ->get();

                if ($recipients->isEmpty()) {
                    return redirect()->back()->with('error', 'No recipients found.');
                }

                return view('admin.documents.send', compact('recipients', 'document', 'document_locations', 'authUser'));

            case 'User':
                $recipients = User::where('default_role', 'Admin')->get();
                return view('user.documents.send', compact('recipients', 'document', 'authUser'));

            case 'Staff':
                $tenantId = $authUser->userDetail->tenant_id ?? null;
                $document_locations = FileMovement::with(['document', 'sender.userDetail', 'recipient.userDetail.tenant_department'])->where('document_id', $document->id)->get();
                if (!$tenantId) {
                    return redirect()->back()->with('error', 'Tenant information is missing.');
                }
                $recipients = User::select('id', 'name')
                    ->with(['userDetail' => function ($query) {
                        $query->select('id', 'user_id', 'designation', 'tenant_id', 'department_id')
                            ->with('tenant_department:id,name'); // Load department name
                    }])
                    ->whereHas('userDetail', function ($query) use ($tenantId) {
                        $query->where('tenant_id', $tenantId);
                    })
                    ->where('id', '!=', $authUser->id)
                    ->get();

                if ($recipients->isEmpty()) {
                    return redirect()->back()->with('error', 'No recipients found.');
                }

                return view('staff.documents.send', compact('recipients', 'document', 'document_locations', 'authUser'));

            case 'Secretary':
                $tenantId = $authUser->userDetail->tenant_id ?? null;
                $document_locations = FileMovement::with(['document', 'sender.userDetail', 'recipient.userDetail.tenant_department'])->where('document_id', $document->id)->get();

                if (!$tenantId) {
                    return redirect()->back()->with('error', 'Tenant information is missing.');
                }

                $recipients = User::with(['userDetail' => function ($query) {
                    $query->select('id', 'user_id', 'designation', 'tenant_id');
                }])
                    ->whereHas('userDetail', function ($query) use ($tenantId) {
                        $query->where('tenant_id', $tenantId);
                    })
                    ->where('id', '!=', $authUser->id)
                    ->get();


                if ($recipients->isEmpty()) {
                    $notification = [
                        'title' => 'No recipients found.',
                        'message' => 'No recipients found.',
                        'type' => 'error',
                    ];
                    return redirect()->back()->with($notification);
                }

                return view('staff.documents.send', compact('recipients', 'document', 'document_locations', 'authUser'));


            default:
                return view('errors.404', compact('authUser'));
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
        try {
            SendMailHelper::sendNotificationMail($data, $request);
        } catch (\Exception $e) {
            Log::error('Failed to send review notification email: ' . $e->getMessage());
            return redirect()->route('document.index')->with([
                'message' => 'Document was processed, but notification email failed.',
                'alert-type' => 'warning',
            ]);
        }

        $notification = array(
            'message' => 'Document sent successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('document.index')->with($notification);
    }

    public function secSendToAdmin(Request $request, Document $document)
    {

        // Validate request input
        $validated = $request->validate([
            'document_data' => 'required|json',
        ]);

        // Decode the JSON data
        $documentData = json_decode($validated['document_data'], true);

        $documentID = $documentData['document_id'];
        // Validate required fields in the decoded data
        if (!isset($documentData['document']['id'], $documentData['sender']['name'], $documentData['recipient']['name'])) {
            return redirect()->back()->with([
                'message' => 'Invalid document data provided.',
                'alert-type' => 'error',
            ]);
        }

        // Retrieve tenant and role details
        $authUser = Auth::user();
        $tenantId = $authUser->userDetail->tenant_id ?? null;

        // Check for tenant assignment
        if (!$tenantId) {
            return redirect()->back()->with([
                'message' => 'You are not assigned to any tenant.',
                'alert-type' => 'error',
            ]);
        }

        // Fetch the recipient(s)
        $recipient = User::with('userDetail')
            ->where('default_role', 'Admin')
            ->whereHas('userDetail', function ($query) use ($tenantId) {
                $query->where('tenant_id', $tenantId);
            })
            ->get();

        if ($recipient->isEmpty()) {
            return redirect()->back()->with([
                'message' => 'No admin users found for the tenant.',
                'alert-type' => 'error',
            ]);
        }

        // Process the document
        $stamp = StampHelper::stampIncomingMail($documentID);
        $result = DocumentStorage::reviewedDocument($documentData, $recipient);

        // Send notification email
        try {
            SendMailHelper::sendReviewNotificationMail($documentData, $recipient);
        } catch (\Exception $e) {
            Log::error('Failed to send review notification email: ' . $e->getMessage());
            return redirect()->back()->with([
                'message' => 'Document was processed, but notification email failed.',
                'alert-type' => 'warning',
            ]);
        }

        // Redirect with success notification
        return redirect()->route('document.index')->with([
            'message' => 'Document sent successfully.',
            'alert-type' => 'success',
        ]);
    }

    public function track_document(Request $request, Document $document)
    {
        $authUser = Auth::user();
        if (in_array(Auth::user()->default_role, ['Admin', 'Staff', 'Secretary'])) {
            // $document_locations = FileMovement::with(['document', 'sender.userDetail', 'recipient.userDetail.tenant.tenant_departments'])->where('document_id', $document->id)->get();
            $document_locations = FileMovement::with(['document', 'sender.userDetail', 'recipient.userDetail.tenant_department'])->where('document_id', $document->id)->get();

            return view('staff.documents.filemovement', compact('document_locations', 'document', 'authUser'));
        }

        if (Auth::user()->default_role === 'User') {
            $document_locations = FileMovement::with(['document', 'sender.userDetail', 'recipient.userDetail.tenant_department'])->where('document_id', $document->id)->get();
            return view('user.documents.filemovement', compact('document_locations', 'document', 'authUser'));
        }
    }

    public function get_attachments(Request $request, Document $document)
    {
        $authUser = Auth::user();
        if (Auth::user()->default_role === 'Admin') {
            $attachments = Attachments::where('document_id', $document->id)->paginate(5);
            return view('admin.documents.attachments', compact('attachments', 'document', 'authUser'));
        }
        if (Auth::user()->default_role === 'Secretary') {
            $attachments = Attachments::where('document_id', $document->id)->paginate(5);
            return view('secretary.documents.attachments', compact('attachments', 'document', 'authUser'));
        }
        if (Auth::user()->default_role === 'Staff') {
            $attachments = Attachments::where('document_id', $document->id)->paginate(5);
            return view('staff.documents.attachments', compact('attachments', 'document', 'authUser'));
        }
        return view('errors.404', compact('authUser'));
    }

    /**Department Management */
    public function department_index()
    {
        $authUser = Auth::user();
        if (Auth::user()->default_role === 'superadmin') {
            $departments = TenantDepartment::orderBy('id', 'desc')->paginate(10);
            return view('superadmin.departments.index', compact('departments', 'authUser'));
        }
        if (Auth::user()->default_role === 'Admin') {
            // Retrieve the tenant_id of the authenticated user
            $tenantId = Auth::user()->userdetail->tenant_id;

            // Filter TenantDepartment by tenant_id and paginate the results
            $departments = TenantDepartment::where('tenant_id', $tenantId)
                ->orderBy('id', 'desc')
                ->paginate(10);
            return view('admin.departments.index', compact('departments', 'authUser'));
        }
        return view('errors.404', compact('authUser'));
    }
    public function department_create()
    {
        $authUser = Auth::user();
        if (Auth::user()->default_role === 'superadmin') {
            $organisations = Tenant::all();
            return view('superadmin.departments.create', compact('organisations', 'authUser'));
        }
        if (Auth::user()->default_role === 'Admin') {
            // Retrieve the tenant_id of the authenticated user
            $tenantId = Auth::user()->userdetail->tenant_id;
            $organisations = Tenant::where('id', $tenantId)->first();
            return view('admin.departments.create', compact('organisations', 'tenantId', 'authUser'));
        }
        return view('errors.404', compact('authUser'));
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
        if (Auth::user()->default_role === 'Admin') {
            $request->validate([
                'name' => 'required|string|max:255',
                'tenant_id' => 'required|exists:tenants,id',
            ]);
            $department = TenantDepartment::create($request->all());
            return redirect()->route('department.index')->with('success', 'Department created successfully.');
        }
        return view('errors.404');
    }
    public function department_edit(TenantDepartment $department)
    {
        $authUser = Auth::user();
        if (Auth::user()->default_role === 'superadmin') {
            $organisations = Tenant::all();
            return view('superadmin.departments.edit', compact('department', 'organisations', 'authUser'));
        }
        if (Auth::user()->default_role === 'Admin') {
            $organisations = Tenant::all();
            return view('admin.departments.edit', compact('department', 'organisations', 'authUser'));
        }
        return view('errors.404', compact('authUser'));
    }
    public function department_update(Request $request, TenantDepartment $department)
    {
        $authUser = Auth::user();
        if (Auth::user()->default_role === 'superadmin') {
            $request->validate([
                'name' => 'required|string|max:255',
                'tenant_id' => 'required|exists:tenants,id',
            ]);
            $department->update($request->all());
            $notification = [
                'message' => 'Department updated successfully',
                'alert-type' => 'success'
            ];
            return redirect()->route('department.index')->with($notification);
            }
        if (Auth::user()->default_role === 'Admin') {
            $request->validate([
                'name' => 'required|string|max:255',
                'tenant_id' => 'required|exists:tenants,id',
            ]);
            $department->update($request->all());
            $notification = [
                'message' => 'Department updated successfully',
                'alert-type' => 'success'
            ];
            return redirect()->route('department.index')->with($notification);
        }
        return view('errors.404', compact('authUser'));
        }
        public function department_delete(TenantDepartment $department)
        {
            $authUser = Auth::user();
            if (Auth::user()->default_role === 'superadmin') {
                $department->delete();
                $notification = [
                    'message' => 'Department deleted successfully',
                    'alert-type' => 'success'
                ];
                return redirect()->route('department.index')->with($notification);
            }
            if (Auth::user()->default_role === 'Admin') {
                $department->delete();
                $notification = [
                    'message' => 'Department deleted successfully',
                    'alert-type' => 'success'
                ];
                return redirect()->route('department.index')->with($notification);
            }
            return view('errors.404', compact('authUser'));
        }
}
