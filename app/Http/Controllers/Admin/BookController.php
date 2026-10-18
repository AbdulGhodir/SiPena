<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index()
    {
        $buku = Book::with('category')->latest()->get();
        $kategori = Category::orderBy('nama_kategori')->get();

        return view('admin.daftar_buku', compact('buku', 'kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'isbn' => 'required|string|max:20|unique:books,isbn',
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun_terbit' => 'required|string|max:10',
            'id_kategori' => 'required|exists:categories,id',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'isbn.required' => 'ISBN wajib diisi',
            'isbn.unique' => 'ISBN sudah terdaftar',
            'judul.required' => 'Judul buku wajib diisi',
            'penulis.required' => 'Penulis wajib diisi',
            'penerbit.required' => 'Penerbit wajib diisi',
            'tahun_terbit.required' => 'Tahun terbit wajib diisi',
            'id_kategori.required' => 'Kategori wajib dipilih',
            'stok.required' => 'Stok buku wajib diisi',
            'stok.min' => 'Stok tidak boleh bernilai negatif',
            'gambar.image' => 'File harus berupa gambar',
            'gambar.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        $data = $request->only([
            'isbn',
            'judul',
            'penulis',
            'penerbit',
            'tahun_terbit',
            'id_kategori',
            'stok',
            'deskripsi',
        ]);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('buku', 'public');
        }

        Book::create($data);

        return redirect()->route('admin.buku')->with('success', 'Buku berhasil ditambahkan!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:books,id',
            'isbn' => 'required|string|max:20|unique:books,isbn,' . $request->id,
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun_terbit' => 'required|string|max:10',
            'id_kategori' => 'required|exists:categories,id',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'isbn.required' => 'ISBN wajib diisi',
            'isbn.unique' => 'ISBN sudah digunakan buku lain',
            'judul.required' => 'Judul buku wajib diisi',
            'penulis.required' => 'Penulis wajib diisi',
            'penerbit.required' => 'Penerbit wajib diisi',
            'tahun_terbit.required' => 'Tahun terbit wajib diisi',
            'id_kategori.required' => 'Kategori wajib dipilih',
            'stok.required' => 'Stok buku wajib diisi',
            'stok.min' => 'Stok tidak boleh bernilai negatif',
            'gambar.image' => 'File harus berupa gambar',
            'gambar.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        $buku = Book::findOrFail($request->id);
        $data = $request->only([
            'isbn',
            'judul',
            'penulis',
            'penerbit',
            'tahun_terbit',
            'id_kategori',
            'stok',
            'deskripsi',
        ]);

        if ($request->hasFile('gambar')) {
            if ($buku->gambar && Storage::disk('public')->exists($buku->gambar)) {
                Storage::disk('public')->delete($buku->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('buku', 'public');
        }

        $buku->update($data);

        return redirect()->route('admin.buku')->with('success', 'Data buku berhasil diperbarui!');
    }

    public function destroy(Request $request)
    {
        $buku = Book::findOrFail($request->id);

        if ($buku->borrowings()->whereIn('status', ['dipinjam', 'terlambat'])->count() > 0) {
            return redirect()->route('admin.buku')->with('error', 'Buku tidak dapat dihapus karena masih ada yang meminjam!');
        }

        if ($buku->gambar && Storage::disk('public')->exists($buku->gambar)) {
            Storage::disk('public')->delete($buku->gambar);
        }

        $buku->delete();

        return redirect()->route('admin.buku')->with('success', 'Buku berhasil dihapus!');
    }
}
