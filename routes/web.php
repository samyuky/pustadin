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
use App\Http\Controllers\Admin\AnnouncementController; // Menggunakan AnnouncementController untuk pengumuman admin
use App\Http\Controllers\Admin\DataRequestController as AdminDataRequestController;
use App\Http\Controllers\Admin\ErrorReportController as AdminErrorReportController;
use App\Http\Controllers\Admin\ComplaintController as AdminComplaintController;
use App\Http\Controllers\Admin\SimakFeatureRequestController as AdminSimakFeatureRequestController;
use App\Http\Controllers\Admin\FeederSyncRequestController as AdminFeederSyncRequestController;
use App\Http\Controllers\Admin\ServiceHistoryController;

// ... rute lain Anda ...

Route::get('/admin/services/history', [ServiceHistoryController::class, 'index'])->name('admin.services.history');
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di sini Anda dapat mendaftarkan rute web untuk aplikasi Anda. Rute-rute ini
| dimuat oleh RouteServiceProvider dan semuanya akan ditetapkan ke
| grup middleware "web". Buat sesuatu yang hebat!
|
*/

// --- Rute Publik (Tidak Memerlukan Autentikasi) ---

// Halaman utama
Route::get('/', [HomeController::class, 'index'])->name('home');

// Formulir pengajuan layanan yang menghadap pengguna
// Menggunakan Route::resource dengan 'only' dan 'names' untuk definisi yang lebih bersih
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

// Mengarahkan /login ke halaman login admin
Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');


// --- Rute Autentikasi Admin ---
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminLoginController::class, 'login'])->name('login.post');
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');
});

// --- Rute Terlindungi Admin (Membutuhkan Autentikasi Admin) ---
Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Pengumuman Admin
    Route::resource('announcements', AnnouncementController::class);

    // Permintaan Data Admin
    Route::resource('data-requests', AdminDataRequestController::class);
    Route::put('data-requests/{data_request}/status', [AdminDataRequestController::class, 'updateStatus'])->name('data-requests.update_status');

    // Laporan Error Admin
    Route::resource('error-reports', AdminErrorReportController::class);
    Route::put('error-reports/{error_report}/status', [AdminErrorReportController::class, 'updateStatus'])->name('error-reports.update_status');

    // Keluhan Admin
    Route::resource('complaints', AdminComplaintController::class);
    Route::put('complaints/{complaint}/status', [AdminComplaintController::class, 'updateStatus'])->name('complaints.update_status');

    // Permintaan Fitur SIMAK Admin
    Route::resource('simak-feature-requests', AdminSimakFeatureRequestController::class);
    Route::put('simak-feature-requests/{simak_feature_request}/status', [AdminSimakFeatureRequestController::class, 'updateStatus'])->name('simak-feature-requests.update_status');

    // Permintaan Sinkronisasi Feeder Admin
    Route::resource('feeder-sync-requests', AdminFeederSyncRequestController::class);
    // Pastikan baris ini ada:
    Route::put('feeder-sync-requests/{feeder_sync_request}/status', [AdminFeederSyncRequestController::class, 'updateStatus'])->name('feeder-sync-requests.update_status');
});

// --- Rute Publik (Tidak Memerlukan Autentikasi) ---
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');Route::get('/admin/services/history', function () {
    return view('admin.services.history');
})->name('admin.services.history');

Route::get('/admin/services/history', [ServiceHistoryController::class, 'index'])->name('admin.services.history');