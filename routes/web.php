<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LowonganController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PelamarController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| 1. PUBLIC ROUTES (Bisa diakses siapa saja)
|--------------------------------------------------------------------------
*/
Route::get('/', [LowonganController::class, 'index'])->name('home');
Route::get('/careers', [LowonganController::class, 'allCareers'])->name('careers.index');
Route::get('/career-detail/{id}', [LowonganController::class, 'show'])->name('career.detail');

Route::get('/berita', function() {
    return view('berita');
})->name('berita');

/*
|--------------------------------------------------------------------------
| 2. GUEST ROUTES (Hanya untuk yang BELUM login)
|--------------------------------------------------------------------------
*/
Route::middleware(['guest'])->group(function () {
    // Auth Pelamar
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    
    // Auth Admin
    Route::get('/admin/login', [AuthController::class, 'showAdminLogin'])->name('admin.login');
    Route::post('/admin/login', [AuthController::class, 'adminLogin']);
});

/*
|--------------------------------------------------------------------------
| 3. PROTECTED ROUTES (Wajib Login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    /* --- A. AREA PELAMAR --- */
    Route::middleware(['pelamar'])->group(function () {
        // Dashboard & Profil CV
        Route::get('/dashboard', [PelamarController::class, 'dashboard'])->name('pelamar.dashboard');
        Route::get('/create-cv', [PelamarController::class, 'createCv'])->name('pelamar.create_cv');
        Route::post('/store-cv', [PelamarController::class, 'storeCv'])->name('pelamar.store_cv');
        
        // Rute untuk Edit CV
        Route::get('/edit-cv', [PelamarController::class, 'editCv'])->name('pelamar.edit_cv');
        Route::put('/update-cv', [PelamarController::class, 'updateCv'])->name('pelamar.update_cv');

        // Proses Melamar Kerja
        Route::get('/lowongan/{id}/apply', [PelamarController::class, 'showApplyForm'])->name('pelamar.apply');
        Route::post('/lowongan/{id}/apply', [PelamarController::class, 'applyJob'])->name('pelamar.store');
    });

    /* --- B. AREA ADMIN / HRD --- */
    Route::prefix('admin')->middleware(['admin'])->group(function () {
        // Dashboard Admin
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        
        // Manajemen Lowongan (CRUD)
        Route::get('/lowongan', [AdminController::class, 'indexLowongan'])->name('admin.lowongan.index');
        Route::get('/lowongan/create', [AdminController::class, 'createLowongan'])->name('admin.lowongan.create');
        Route::post('/lowongan', [AdminController::class, 'storeLowongan'])->name('admin.lowongan.store');
        Route::get('/lowongan/{id}/edit', [AdminController::class, 'editLowongan'])->name('admin.lowongan.edit');
        Route::put('/lowongan/{id}', [AdminController::class, 'updateLowongan'])->name('admin.lowongan.update');
        Route::delete('/lowongan/{id}', [AdminController::class, 'destroyLowongan'])->name('admin.lowongan.destroy');
        
        // Manajemen Pelamar & Seleksi
        Route::get('/applications', [AdminController::class, 'indexApplications'])->name('admin.applications.index');
        Route::get('/seleksi/detail/{id}', [AdminController::class, 'showApplication'])->name('admin.applications.show');
        Route::patch('/applications/{id}/update', [AdminController::class, 'updateApplicationStatus'])->name('admin.applications.update');

        // Master Data
        Route::prefix('master')->name('admin.master.')->group(function() {
            Route::get('/', [AdminController::class, 'indexMaster'])->name('index');
            Route::post('/category', [AdminController::class, 'storeCategory'])->name('category.store');
            Route::post('/experience', [AdminController::class, 'storeExperience'])->name('experience.store');
            
            Route::delete('/category/{id}', [AdminController::class, 'destroyCategory'])->name('category.destroy');
            Route::delete('/experience/{id}', [AdminController::class, 'destroyExperience'])->name('experience.destroy');
        });

        // ==========================================
        // MANAJEMEN ADMIN (SUDAH AMAN DI DALAM GRUP ADMIN)
        // ==========================================
        Route::get('/users/admin', [AdminController::class, 'indexAdmin'])->name('admin.users.index');
        Route::post('/users/admin', [AdminController::class, 'storeAdmin'])->name('admin.users.store');
        Route::delete('/users/admin/{id}', [AdminController::class, 'destroyAdmin'])->name('admin.users.destroy');
    });

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
// Fitur Lupa Password
    Route::get('/forgot-password', [App\Http\Controllers\PasswordResetController::class, 'requestForm'])->name('password.request');
    Route::post('/forgot-password', [App\Http\Controllers\PasswordResetController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [App\Http\Controllers\PasswordResetController::class, 'resetForm'])->name('password.reset');
    Route::post('/reset-password', [App\Http\Controllers\PasswordResetController::class, 'updatePassword'])->name('password.update');