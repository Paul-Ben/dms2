<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuperAdminActions;
use App\Models\Tenant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/ministries', function () {
    $ministries = Tenant::where('category', 'Ministry')->paginate(10);
    return view('mdalistings', compact('ministries'));
})->name('mdas');
Route::get('/agencies', function () {
    $agencies =  Tenant::where('category', 'Agency')->paginate(10);
    return view('agencylisting', compact('agencies'));
})->name('agency');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('dashboard')->middleware('auth')->group(function () {
    /**User managem related links */
    Route::get('/superadmin/users', [SuperAdminActions::class, 'user_index'])->name('users.index');
    Route::get('/superadmin/users/create', [SuperAdminActions::class, 'user_create'])->name('user.create');
    Route::post('/superadmin/users/create', [SuperAdminActions::class, 'user_store'])->name('user.save');
    Route::get('/superadmin/users/{user}/edit', [SuperAdminActions::class, 'user_edit'])->name('user.edit');
    Route::put('/superadmin/users/{user}/edit', [SuperAdminActions::class, 'user_update'])->name('user.update');
    Route::get('/get-departments/{organisationId}', [SuperAdminActions::class, 'getDepartments']);

    
    /**Organisation Management realated links */
    Route::get('/superadmin/organisations', [SuperAdminActions::class, 'org_index'])->name('organisation.index');
    Route::get('/superadmin/organisations/create', [SuperAdminActions::class, 'org_create'])->name('organisation.create');
    Route::post('/superadmin/organisations/create', [SuperAdminActions::class, 'org_store'])->name('organisation.store');
    Route::get('/superadmin/organisations/{tenant}/edit', [SuperAdminActions::class, 'org_edit'])->name('organisation.edit');
    Route::put('/superadmin/organisations/{tenant}/edit', [SuperAdminActions::class, 'org_update'])->name('organisation.update');
    Route::delete('/superadmin/organisations/{tenant}/delete', [SuperAdminActions::class, 'org_delete'])->name('organisation.delete');


    /**Document management related links */
    Route::get('/document', [SuperAdminActions::class, 'document_index'])->name('document.index');
    Route::get('/document/create', [SuperAdminActions::class, 'document_create'])->name('document.create');
    Route::post('/document/create', [SuperAdminActions::class, 'document_store'])->name('document.store');
    Route::get('/document/sent', [SuperAdminActions::class, 'sent_documents'])->name('document.sent');
    Route::get('/document/received', [SuperAdminActions::class, 'received_documents'])->name('document.received');
    // Route::get('/document/{document}/view', [SuperAdminActions::class, 'viewDocument'])->name('document.view');
    Route::get('/document/{document}/send', [SuperAdminActions::class, 'getSendform'])->name('document.send');
    Route::post('/document/{document}/send', [SuperAdminActions::class, 'sendDocument'])->name('document.senddoc');




});


require __DIR__.'/auth.php';
