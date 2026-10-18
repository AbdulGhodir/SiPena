<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    public function index()
    {
        Borrowing::where('status', 'dipinjam')
            ->whereDate('jatuh_tempo', '<', today())
            ->update(['status' => 'terlambat']);

        $borrowings = Borrowing::with(['user', 'book'])->latest()->get();
        $members = User::where('role', 'user')->orderBy('nama')->get();
        $books = Book::where('stok', '>', 0)->orderBy('judul')->get();

        return view('admin.peminjaman', compact('borrowings', 'members', 'books'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_user' => 'required|exists:users,id',
            'id_buku' => 'required|exists:books,id',
            'tanggal_pinjam' => 'required|date',
            'jatuh_tempo' => 'required|date|after_or_equal:tanggal_pinjam'
        ], [
            'id_user.required' => 'Anggota peminjam wajib dipilih',
            'id_buku.required' => 'Buku yang dipinjam wajib dipilih',
            'tanggal_pinjam.required' => 'Tanggal pinjam wajib diisi',
            'jatuh_tempo.required' => 'Tanggal jatuh tempo wajib diisi',
            'jatuh_tempo.after_or_equal' => 'Jatuh tempo tidak boleh sebelum tanggal pinjam'
        ]);

        $book = Book::findOrFail($request->id_buku);
        if ($book->stok < 1) {
            return redirect()->route('admin.peminjaman')->with('error', 'Stok buku ini sedang habis!');
        }

        Borrowing::create([
            'id_user' => $request->id_user,
            'id_buku' => $request->id_buku,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'jatuh_tempo' => $request->jatuh_tempo,
            'status' => 'dipinjam',
        ]);

        $book->decrement('stok');

        return redirect()->route('admin.peminjaman')->with('success', 'Transaksi peminjaman berhasil dicatat!');
    }

    public function kembalikan(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:borrowings,id'
        ]);

        $borrowing = Borrowing::findOrFail($request->id);

        if ($borrowing->status === 'dikembalikan') {
            return redirect()->route('admin.peminjaman')->with('error', 'Buku ini sudah dikembalikan sebelumnya!');
        }

        $borrowing->update([
            'status' => 'dikembalikan',
            'tanggal_kembali' => now()->format('Y-m-d')
        ]);

        if ($borrowing->book) {
            $borrowing->book->increment('stok');
        }

        return redirect()->route('admin.peminjaman')->with('success', 'Buku berhasil dikembalikan!');
    }
}
