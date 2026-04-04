<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LowonganController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PelamarController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApplicantDetailController;

/*
|--------------------------------------------------------------------------
| 1. PUBLIC ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', [LowonganController::class, 'index'])->name('home');
Route::get('/careers', [LowonganController::class, 'allCareers'])->name('careers.index');
Route::get('/career-detail/{slug}', [LowonganController::class, 'show'])->name('career.detail');
Route::get('/berita', fn() => view('berita'))->name('berita');

/*
|--------------------------------------------------------------------------
| 2. GUEST ROUTES (Login/Register)
|--------------------------------------------------------------------------
*/
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    
    Route::get('/admin/login', [AuthController::class, 'showAdminLogin'])->name('admin.login');
    Route::post('/admin/login', [AuthController::class, 'adminLogin']);

    // Password Reset
    Route::controller(App\Http\Controllers\PasswordResetController::class)->group(function () {
        Route::get('/forgot-password', 'requestForm')->name('password.request');
        Route::post('/forgot-password', 'sendResetLink')->name('password.email');
        Route::get('/reset-password/{token}', 'resetForm')->name('password.reset');
        Route::post('/reset-password', 'updatePassword')->name('password.update');
    });
});

/*
|--------------------------------------------------------------------------
| 3. PROTECTED ROUTES (Wajib Login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    /* --- AREA PELAMAR --- */
    Route::middleware(['pelamar'])->group(function () {
        Route::get('/dashboard', [PelamarController::class, 'dashboard'])->name('pelamar.dashboard');

        // MANAJEMEN CV (Satu pintu di PelamarController)
        Route::prefix('cv')->group(function () {
            Route::get('/create', [PelamarController::class, 'createCv'])->name('pelamar.create_cv');
            Route::post('/store', [PelamarController::class, 'storeCv'])->name('pelamar.store_cv');
            Route::get('/edit', [PelamarController::class, 'editCv'])->name('pelamar.edit_cv');
            Route::put('/update', [PelamarController::class, 'updateCv'])->name('pelamar.update_cv');
        });

        // PROSES LAMAR KERJA (Gua arahin ke PelamarController@applyJob biar sinkron)
        Route::get('/lowongan/{id}/apply', [PelamarController::class, 'showApplyForm'])->name('pelamar.apply');
        Route::post('/lowongan/{id}/apply', [PelamarController::class, 'applyJob'])->name('pelamar.apply.submit');

        // Lengkapi Profil Tambahan (Jika masih dipisah)
        Route::get('/lengkapi-profil', [ApplicantDetailController::class, 'create'])->name('profil.create');
        Route::post('/lengkapi-profil', [ApplicantDetailController::class, 'store'])->name('profil.store');
    });

    /* --- AREA ADMIN / HRD --- */
    Route::prefix('admin')->middleware(['admin'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        
        // Lowongan CRUD (INI YANG DIBENERIN BIAR GAK ERROR!)
        Route::get('/lowongan', [AdminController::class, 'indexLowongan'])->name('admin.lowongan.index');
        Route::get('/lowongan/create', [AdminController::class, 'createLowongan'])->name('admin.lowongan.create');
        Route::post('/lowongan', [AdminController::class, 'storeLowongan'])->name('admin.lowongan.store');
        Route::get('/lowongan/{id}/edit', [AdminController::class, 'editLowongan'])->name('admin.lowongan.edit');
        Route::put('/lowongan/{id}', [AdminController::class, 'updateLowongan'])->name('admin.lowongan.update');
        Route::delete('/lowongan/{id}', [AdminController::class, 'destroyLowongan'])->name('admin.lowongan.destroy');

        // Pelamar & Seleksi
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

        // User Admin
        Route::get('/users/admin', [AdminController::class, 'indexAdmin'])->name('admin.users.index');
        Route::post('/users/admin', [AdminController::class, 'storeAdmin'])->name('admin.users.store');
        Route::delete('/users/admin/{id}', [AdminController::class, 'destroyAdmin'])->name('admin.users.destroy');
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

/* --- DEV TOOLS --- */
Route::get('/clear-cache', function() {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
    return 'Cache dibersihkan Bos!';
});