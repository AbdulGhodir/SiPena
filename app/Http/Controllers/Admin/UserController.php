<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('nama')->get();

        return view('admin.pengguna', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'no_tlp' => 'required|string|max:20',
            'role' => 'required|in:admin,user',
            'password' => 'required|min:6'
        ], [
            'nama.required' => 'Nama pengguna wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.unique' => 'Email sudah terdaftar',
            'no_tlp.required' => 'Nomor telepon wajib diisi',
            'role.required' => 'Peran pengguna wajib dipilih',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter'
        ]);

        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'no_tlp' => $request->no_tlp,
            'role' => $request->role,
            'password' => $request->password,
        ]);

        return redirect()->route('admin.pengguna')->with('success', 'Pengguna berhasil ditambahkan!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:users,id',
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $request->id,
            'no_tlp' => 'required|string|max:20',
            'role' => 'required|in:admin,user',
        ], [
            'nama.required' => 'Nama pengguna wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.unique' => 'Email sudah digunakan pengguna lain',
            'no_tlp.required' => 'Nomor telepon wajib diisi',
            'role.required' => 'Peran pengguna wajib dipilih',
        ]);

        $user = User::findOrFail($request->id);
        $userData = [
            'nama' => $request->nama,
            'email' => $request->email,
            'no_tlp' => $request->no_tlp,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $userData['password'] = $request->password;
        }

        $user->update($userData);

        return redirect()->route('admin.pengguna')->with('success', 'Data pengguna berhasil diperbarui!');
    }

    public function destroy(Request $request)
    {
        $user = User::findOrFail($request->id);

        if (auth()->guard()->id() === $user->id) {
            return redirect()->route('admin.pengguna')->with('error', 'Anda tidak dapat menghapus akun sendiri yang sedang login!');
        }

        if ($user->borrowings()->whereIn('status', ['dipinjam', 'terlambat'])->count() > 0) {
            return redirect()->route('admin.pengguna')->with('error', 'Pengguna tidak dapat dihapus karena masih memiliki pinjaman buku yang aktif!');
        }

        $user->delete();

        return redirect()->route('admin.pengguna')->with('success', 'Pengguna berhasil dihapus!');
    }
}
