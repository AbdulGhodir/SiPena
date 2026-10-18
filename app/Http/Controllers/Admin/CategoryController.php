<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index() {
        $kategori = Category::withCount('books')
            ->orderBy('nama_kategori')
            ->get();

        $totalKategori = $kategori->count();

        return view('admin.kategori', compact('kategori', 'totalKategori'));
    }

    public function store(Request $request) {
        $request->validate([
            'nama_kategori' => 'required|string|max:50|unique:categories,nama_kategori'
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi',
            'nama_kategori.max' => 'Nama kategori maksimal 50 karakter',
            'nama_kategori.unique' => 'Nama kategori sudah ada'
        ]);

        Category::create([
            'nama_kategori' => $request->nama_kategori
        ]);

        return redirect()->route('admin.kategori')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function update(Request $request) {
        $request->validate([
            'id' => 'required|exists:categories,id',
            'nama_kategori' => 'required|string|max:50|unique:categories,nama_kategori,' . $request->id
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi',
            'nama_kategori.max' => 'Nama kategori maksimal 50 karakter',
            'nama_kategori.unique' => 'Nama kategori sudah ada'
        ]);

        $kategori = Category::findOrFail($request->id);
        $kategori->update([
            'nama_kategori' => $request->nama_kategori
        ]);

        return redirect()->route('admin.kategori')->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy(Request $request) {
        $kategori = Category::findOrFail($request->id);

        if ($kategori->books()->count() > 0) {
            return redirect()->route('admin.kategori')->with('error', 'Kategori tidak dapat dihapus karena masih memiliki buku terkait!');
        }

        $kategori->delete();

        return redirect()->route('admin.kategori')->with('success', 'Kategori berhasil dihapus!');
    }
}
