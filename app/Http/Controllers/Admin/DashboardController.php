<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use App\Models\Borrowing;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBuku = Book::count();
        $totalKategori = Category::count();

        $totalAnggota = User::where('role', 'member')->count();

        $totalPeminjaman = Borrowing::count();

        $peminjamanTerbaru = Borrowing::with(['user', 'book'])
            ->latest('tanggal_pinjam')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalBuku',
            'totalKategori',
            'totalAnggota',
            'totalPeminjaman',
            'peminjamanTerbaru'
        ));
    }
}
