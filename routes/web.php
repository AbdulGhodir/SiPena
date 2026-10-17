
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Member\DashboardController as MemberDashboardController;
use App\Http\Controllers\Member\BookController as MemberBookController;
use App\Http\Controllers\Member\ProfileController as MemberProfileController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;

Route::get('/', function () {return redirect()->route('login');});
Route::get('/login', [AuthenticatedSessionController::class, 'create']) ->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']) ->name('logout');
Route::middleware('auth')->prefix('member')->group(function () {
    Route::get('/dashboard', [MemberDashboardController::class, 'index']) ->name('member.dashboard');
    Route::get('/riwayat', [MemberDashboardController::class, 'riwayat']) ->name('member.riwayat');

    // Detail Buku
    Route::get('/buku/{id}', [MemberBookController::class, 'show'])->name('member.buku.show');

    // Profil
    Route::get('/profil', [MemberProfileController::class, 'index'])->name('member.profile.index');
    Route::put('/profil', [MemberProfileController::class, 'update'])->name('member.profile.update');
});
Route::get('/register', [RegisteredUserController::class, 'create']) ->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);
Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index']) ->name('admin.dashboard');
});