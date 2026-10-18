<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function show($id)
    {
        $book = Book::with('category')->findOrFail($id);
        $alreadyBorrowed = Borrowing::where('id_user', auth()->id())
            ->where('id_buku', $id)
            ->whereIn('status', ['dipinjam', 'terlambat'])
            ->exists();

        return view('member.book_detail', compact('book', 'alreadyBorrowed'));
    }

    public function borrow(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        if ($book->stok < 1) {
            return back()->with('error', 'Stok buku ini sedang habis!');
        }

        $activeLoan = Borrowing::where('id_user', auth()->id())
            ->where('id_buku', $id)
            ->whereIn('status', ['dipinjam', 'terlambat'])
            ->exists();

        if ($activeLoan) {
            return back()->with('error', 'Kamu sedang meminjam buku ini!');
        }

        Borrowing::create([
            'id_user' => auth()->id(),
            'id_buku' => $book->id,
            'tanggal_pinjam' => now()->format('Y-m-d'),
            'jatuh_tempo' => now()->addDays(7)->format('Y-m-d'),
            'status' => 'dipinjam',
        ]);

        $book->decrement('stok');

        return redirect()->route('member.riwayat')->with('success', 'Buku berhasil dipinjam! Selamat membaca.');
    }
}
