<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\Borrowing;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $books = Book::with('category')
            ->when($request->filled('q'), function ($query) use ($request) {
                $search = $request->q;

                $query->where(function ($q) use ($search) {
                    $q->where('judul', 'ilike', "%{$search}%")
                      ->orWhere('penulis', 'ilike', "%{$search}%");
                });
            })
            ->when($request->filled('kategori'), function ($query) use ($request) {
                $query->where('id_kategori', $request->kategori);
            })
            ->when($request->input('stok') === 'tersedia', function ($query) {
                $query->where('stok', '>', 0);
            })
            ->when($request->input('stok') === 'habis', function ($query) {
                $query->where('stok', '<=', 0);
            })
            ->latest()
            ->paginate(8)
            ->withQueryString();

        $categories = Category::orderBy('nama_kategori')->get();

        $borrowings = Borrowing::with('book')
            ->where('id_user', auth()->guard()->id())
            ->latest('tanggal_pinjam')
            ->get();

        return view('member.dashboard', compact(
            'books',
            'categories',
            'borrowings'
        ));
    }
    
    public function riwayat()
    {
        abort_unless(auth()->guard()->user()->role === 'member', 403);

        $peminjaman = Borrowing::with('book')
            ->where('id_user', auth()->guard()->id())
            ->latest('tanggal_pinjam')
            ->get();

        $filter = request('status', 'semua');

        if ($filter === 'dipinjam') {
            $peminjaman = $peminjaman->filter(function ($item) {
                return strtolower($item->status ?? '') === 'dipinjam'
                    && !($item->jatuh_tempo
                        && \Carbon\Carbon::parse($item->jatuh_tempo)->lt(now()->startOfDay()));
            });
        } elseif ($filter === 'dikembalikan') {
            $peminjaman = $peminjaman->filter(function ($item) {
                return strtolower($item->status ?? '') === 'dikembalikan';
            });
        } elseif ($filter === 'terlambat') {
            $peminjaman = $peminjaman->filter(function ($item) {
                return strtolower($item->status ?? '') === 'dipinjam'
                    && $item->jatuh_tempo
                    && \Carbon\Carbon::parse($item->jatuh_tempo)->lt(now()->startOfDay());
            });
        }

        return view('member.riwayat', compact('peminjaman'));
    }

}
