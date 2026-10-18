<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Borrowing;

class MemberController extends Controller
{
    public function index()
    {
        Borrowing::where('status', 'dipinjam')
            ->whereDate('jatuh_tempo', '<', today())
            ->update(['status' => 'terlambat']);

        $members = User::where('role', 'user')
            ->with(['borrowings.book'])
            ->latest()
            ->get();

        return view('admin.anggota', compact('members'));
    }
}
