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
        Borrowing::where('status', 'dipinjam')
            ->whereDate('jatuh_tempo', '<', today())
            ->update(['status' => 'terlambat']);

        $totalBuku = Book::count();

        $totalAnggota = User::where('role', 'user')->count();

        $totalSedangDipinjam = Borrowing::where('status', 'dipinjam')->count();

        $totalTerlambat = Borrowing::where('status', 'terlambat')->count();

        $perluTindakLanjut = Borrowing::with(['user', 'book'])
            ->where(function ($query) {
                $query->where(function ($q) {
                    $q->whereDate('jatuh_tempo', today())
                      ->where('status', 'dipinjam');
                })->orWhere('status', 'terlambat');
            })
            ->get();

        

        $aktivitasUser = User::where('role', 'user')
            ->latest('created_at')
            ->take(5)
            ->get()
            ->map(function ($user) {
                return [
                    'waktu' => $user->created_at,
                    'waktu_label' => $user->created_at->diffForHumans(),
                    'nama' => $user->nama,
                    'aksi' => 'mendaftar sebagai anggota baru',
                    'objek' => null,
                    'warna_dot' => 'bg-amber-500',
                ];
            });

        $aktivitasPeminjaman = Borrowing::with(['user', 'book'])
            ->latest('created_at')
            ->take(5)
            ->get()
            ->map(function ($borrowing) {
                return [
                    'waktu' => $borrowing->created_at,
                    'waktu_label' => $borrowing->created_at->diffForHumans(),
                    'nama' => $borrowing->user->nama ?? 'Pengguna',
                    'aksi' => 'meminjam',
                    'objek' => $borrowing->book->judul ?? 'Buku',
                    'warna_dot' => 'bg-[#173F35]',
                ];
            });

        $aktivitasPengembalian = Borrowing::with(['user', 'book'])
            ->where('status', 'dikembalikan')
            ->latest('updated_at')
            ->take(5)
            ->get()
            ->map(function ($borrowing) {
                return [
                    'waktu' => $borrowing->updated_at,
                    'waktu_label' => $borrowing->updated_at->diffForHumans(),
                    'nama' => $borrowing->user->nama ?? 'Pengguna',
                    'aksi' => 'mengembalikan',
                    'objek' => $borrowing->book->judul ?? 'Buku',
                    'warna_dot' => 'bg-[#173F35]',
                ];
            });

        $aktivitasTerbaru = $aktivitasUser
            ->merge($aktivitasPeminjaman)
            ->merge($aktivitasPengembalian)
            ->sortByDesc('waktu')
            ->take(5)
            ->values();

        return view('admin.dashboard', compact(
            'totalBuku',
            'totalAnggota',
            'totalSedangDipinjam',
            'totalTerlambat',
            'perluTindakLanjut',
            'aktivitasTerbaru'
        ));
    }
}
