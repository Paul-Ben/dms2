<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardAPIController;
use App\Http\Controllers\Api\SuperAdminAPIController;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return response()->json([
        'message' => 'Welcome to the API',
    ]);
});

// Ministries route
Route::get('/ministries', function () {
    $ministries = Tenant::where('category', 'Ministry')->paginate(10);
    return response()->json([
        'ministries' => $ministries,
    ]);
});

// Agencies route
Route::get('/agencies', function () {
    $agencies = Tenant::where('category', 'Agency')->paginate(10);
    return response()->json([
        'agencies' => $agencies,
    ]);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/dashboard', [DashboardAPIController::class, 'index']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
 
Route::prefix('dashboard')->middleware('auth:sanctum')->group(function () {
    /** User Management Routes */
    Route::get('/users', [SuperAdminAPIController::class, 'userIndex']);
    Route::get('/users/create', [SuperAdminAPIController::class, 'userCreate']);
    Route::post('/users/create', [SuperAdminAPIController::class, 'userStore']);
    Route::get('/users/{user}/edit', [SuperAdminAPIController::class, 'userEdit']);
    Route::put('/users/{user}/edit', [SuperAdminAPIController::class, 'userUpdate']);
    Route::get('/get-departments/{organisationId}', [SuperAdminAPIController::class, 'getDepartments']);

    /** Organisation Management Routes */
    Route::get('/superadmin/organisations', [SuperAdminAPIController::class, 'orgIndex']);
    Route::get('/superadmin/organisations/create', [SuperAdminAPIController::class, 'orgCreate']);
    Route::post('/superadmin/organisations/create', [SuperAdminAPIController::class, 'orgStore']);
    Route::get('/superadmin/organisations/{tenant}/edit', [SuperAdminAPIController::class, 'orgEdit']);
    Route::put('/superadmin/organisations/{tenant}/edit', [SuperAdminAPIController::class, 'orgUpdate']);
    Route::delete('/superadmin/organisations/{tenant}/delete', [SuperAdminAPIController::class, 'orgDelete']);

    /** Department Management Routes */
    Route::get('/departments', [SuperAdminAPIController::class, 'departmentIndex']);
    Route::get('/departments/create', [SuperAdminAPIController::class, 'departmentCreate']);
    Route::post('/departments/create', [SuperAdminAPIController::class, 'departmentStore']);
    Route::get('/departments/{department}/edit', [SuperAdminAPIController::class, 'departmentEdit']);
    Route::put('/departments/{department}/edit', [SuperAdminAPIController::class, 'departmentUpdate']);
    Route::delete('/departments/{department}/delete', [SuperAdminAPIController::class, 'departmentDelete']);

    /** Document Management Routes */
    Route::get('/document', [SuperAdminAPIController::class, 'documentIndex']);
    Route::get('/document/create', [SuperAdminAPIController::class, 'documentCreate']);
    Route::post('/document/create', [SuperAdminAPIController::class, 'documentStore']);
    Route::get('/document/sent', [SuperAdminAPIController::class, 'sentDocuments']);
    Route::get('/document/received', [SuperAdminAPIController::class, 'receivedDocuments']);
    Route::get('/document/{document}/send', [SuperAdminAPIController::class, 'getSendform']);
    Route::get('/document/{document}/sendout', [SuperAdminAPIController::class, 'getSendExternalForm']);
    Route::get('/document/{document}/reply', [SuperAdminAPIController::class, 'getReplyform']);
    Route::post('/document/{document}/send', [SuperAdminAPIController::class, 'sendDocument']);
    Route::post('/document/send2admin', [SuperAdminAPIController::class, 'secSendToAdmin']);
    Route::get('/document/file/document', [SuperAdminAPIController::class, 'userFileDocument']);
    Route::get('/document/document/{received}/view', [SuperAdminAPIController::class, 'documentShow']);
    Route::get('/document/document/{sent}/view', [SuperAdminAPIController::class, 'documentShowSent']);
    Route::post('/document/file/document', [SuperAdminAPIController::class, 'userStoreFileDocument']);
    Route::get('/etranzact/callback', [SuperAdminAPIController::class, 'handleETranzactCallback']);
    Route::get('/document/{document}/location', [SuperAdminAPIController::class, 'trackDocument']);
    Route::get('/document/{document}/attachments', [SuperAdminAPIController::class, 'getAttachments']);

    /** Memo Management Routes */
    Route::get('/document/memo', [SuperAdminAPIController::class, 'memoIndex']);
    Route::get('/document/memo/create', [SuperAdminAPIController::class, 'createMemo']);
    Route::post('/document/memo/create', [SuperAdminAPIController::class, 'storeMemo']);
    Route::get('/document/memo/{memo}/edit', [SuperAdminAPIController::class, 'editMemo']);
    Route::put('/document/memo/{memo}/edit', [SuperAdminAPIController::class, 'updateMemo']);
    Route::delete('/document/memo/{memo}/delete', [SuperAdminAPIController::class, 'deleteMemo']);
    Route::get('/document/memo/{memo}/view', [SuperAdminAPIController::class, 'getMemo']);
    Route::get('/generate-letter/{memo}/memo', [SuperAdminAPIController::class, 'generateMemoPdf']);
    Route::get('/document/memo/template', [SuperAdminAPIController::class, 'createMemoTemplateForm']);
    Route::post('/document/memo/template', [SuperAdminAPIController::class, 'storeMemoTemplate']);
    Route::get('/document/memo/template/{template}/edit', [SuperAdminAPIController::class, 'editMemoTemplateForm']);
    Route::get('/document/memo/{memo}/send', [SuperAdminAPIController::class, 'getSendMemoform']);
    Route::get('/document/memo/{memo}/sendout', [SuperAdminAPIController::class, 'getSendMemoExternalForm']);
    Route::post('/document/memo/{memo}/send', [SuperAdminAPIController::class, 'sendMemo']);
    Route::get('/document/sent/memo', [SuperAdminAPIController::class, 'sentMemos']);
    Route::get('/document/received/memo', [SuperAdminAPIController::class, 'receivedMemos']);
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
