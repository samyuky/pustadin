<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

// User-facing controllers for forms
use App\Http\Controllers\DataRequestController;
use App\Http\Controllers\ErrorReportController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\SimakFeatureRequestController;
use App\Http\Controllers\FeederSyncRequestController;

// Admin controllers
use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AnnouncementController; // Using AnnouncementController for admin announcements
use App\Http\Controllers\Admin\DataRequestController as AdminDataRequestController;
use App\Http\Controllers\Admin\ErrorReportController as AdminErrorReportController;
use App\Http\Controllers\Admin\ComplaintController as AdminComplaintController;
use App\Http\Controllers\Admin\SimakFeatureRequestController as AdminSimakFeatureRequestController;
use App\Http\Controllers\Admin\FeederSyncRequestController as AdminFeederSyncRequestController;

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

// --- Public Routes (No Authentication Required) ---

// Home page
Route::get('/', [HomeController::class, 'index'])->name('welcome');

// User-facing forms for submitting requests
// Using Route::resource with 'only' and 'names' for cleaner definitions
Route::resource('data-requests', DataRequestController::class)->only(['create', 'store'])->names([
    'create' => 'data_requests.create',
    'store' => 'data_requests.store',
]);

Route::resource('error-reports', ErrorReportController::class)->only(['create', 'store'])->names([
    'create' => 'error_reports.create',
    'store' => 'error_reports.store',
]);

Route::resource('complaints', ComplaintController::class)->only(['create', 'store'])->names([
    'create' => 'complaints.create',
    'store' => 'complaints.store',
]);

Route::resource('simak-feature-requests', SimakFeatureRequestController::class)->only(['create', 'store'])->names([
    'create' => 'simak_feature_requests.create',
    'store' => 'simak_feature_requests.store',
]);

Route::resource('feeder-sync-requests', FeederSyncRequestController::class)->only(['create', 'store'])->names([
    'create' => 'feeder_sync_requests.create',
    'store' => 'feeder_sync_requests.store',
]);

// Redirect /login to admin login page
Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');


// --- Admin Authentication Routes ---
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminLoginController::class, 'login'])->name('login.post');
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');
});

// --- Admin Protected Routes (Requires Admin Authentication) ---
Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Admin Announcements
    Route::resource('announcements', AnnouncementController::class); // Using AnnouncementController

    // Admin Data Requests
    Route::resource('data-requests', AdminDataRequestController::class);
    Route::put('data-requests/{data_request}/status', [AdminDataRequestController::class, 'updateStatus'])->name('data-requests.update_status');

    // Admin Error Reports
    Route::resource('error-reports', AdminErrorReportController::class);
    Route::put('error-reports/{error_report}/status', [AdminErrorReportController::class, 'updateStatus'])->name('error-reports.update_status');

    // Admin Complaints
    Route::resource('complaints', AdminComplaintController::class);
    Route::put('complaints/{complaint}/status', [AdminComplaintController::class, 'updateStatus'])->name('complaints.update_status');

    // Admin SIMAK Feature Requests
    Route::resource('simak-feature-requests', AdminSimakFeatureRequestController::class);
    Route::put('simak-feature-requests/{simak_feature_request}/status', [AdminSimakFeatureRequestController::class, 'updateStatus'])->name('simak-feature-requests.update_status');

    // Admin Feeder Sync Requests
    Route::resource('feeder-sync-requests', AdminFeederSyncRequestController::class);
    Route::put('feeder-sync-requests/{feeder_sync_request}/status', [AdminFeederSyncRequestController::class, 'updateStatus'])->name('feeder-sync-requests.update_status');
});

