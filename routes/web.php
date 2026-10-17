
<?php

use App\Http\Controllers\Admin\BookController as AdminBookController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Member\DashboardController as MemberDashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;

Route::get('/', function () {return redirect()->route('login');});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm']) ->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'registerForm']) ->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']) ->name('logout');
});

Route::middleware(['auth', 'role:user'])->prefix('user')->group(function () {
    Route::get('/dashboard', [MemberDashboardController::class, 'index']) ->name('member.dashboard');
    Route::get('/riwayat', [MemberDashboardController::class, 'riwayat']) ->name('member.riwayat');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index']) ->name('admin.dashboard');
    Route::get('/buku', [AdminBookController::class, 'index']) ->name('admin.buku');
});