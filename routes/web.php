
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\MemberController as AdminMemberController;
use App\Http\Controllers\Admin\BorrowingController as AdminBorrowingController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Member\DashboardController as MemberDashboardController;
use App\Http\Controllers\Member\BookController as MemberBookController;
use App\Http\Controllers\Member\ProfileController as MemberProfileController;

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

Route::middleware(['auth', 'role:user'])->prefix('member')->group(function () {
    Route::get('/dashboard', [MemberDashboardController::class, 'index']) ->name('member.dashboard');
    Route::get('/riwayat', [MemberDashboardController::class, 'riwayat']) ->name('member.riwayat');
    Route::get('/buku/{id}', [MemberBookController::class, 'show'])->name('member.buku.show');
    Route::get('/profil', [MemberProfileController::class, 'index'])->name('member.profile.index');
    Route::put('/profil', [MemberProfileController::class, 'update'])->name('member.profile.update');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index']) ->name('admin.dashboard');

    Route::get('/buku', [AdminBookController::class, 'index']) ->name('admin.buku');
    Route::post('/buku', [AdminBookController::class, 'store']) ->name('admin.buku.store');
    Route::put('/buku', [AdminBookController::class, 'update']) ->name('admin.buku.update');
    Route::delete('/buku', [AdminBookController::class, 'destroy']) ->name('admin.buku.destroy');

    Route::get('/kategori', [AdminCategoryController::class, 'index']) ->name('admin.kategori');
    Route::post('/kategori', [AdminCategoryController::class, 'store']) ->name('admin.kategori.store');
    Route::put('/kategori', [AdminCategoryController::class, 'update']) ->name('admin.kategori.update');
    Route::delete('/kategori', [AdminCategoryController::class, 'destroy']) ->name('admin.kategori.destroy');

    Route::get('/anggota', [AdminMemberController::class, 'index']) ->name('admin.anggota');

    Route::get('/peminjaman', [AdminBorrowingController::class, 'index']) ->name('admin.peminjaman');
    Route::post('/peminjaman', [AdminBorrowingController::class, 'store']) ->name('admin.peminjaman.store');
    Route::put('/peminjaman/kembalikan', [AdminBorrowingController::class, 'kembalikan']) ->name('admin.peminjaman.kembalikan');

    Route::get('/pengguna', [AdminUserController::class, 'index']) ->name('admin.pengguna');
    Route::post('/pengguna', [AdminUserController::class, 'store']) ->name('admin.pengguna.store');
    Route::put('/pengguna', [AdminUserController::class, 'update']) ->name('admin.pengguna.update');
    Route::delete('/pengguna', [AdminUserController::class, 'destroy']) ->name('admin.pengguna.destroy');
});