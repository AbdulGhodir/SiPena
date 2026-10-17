<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('member.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'no_tlp' => ['nullable', 'string', 'max:15'],
            'password' => ['nullable', 'min:8', 'confirmed'],
        ]);

        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->no_tlp = $request->no_tlp;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        /** @var \App\Models\User $user */
        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
