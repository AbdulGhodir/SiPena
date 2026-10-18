@extends('layouts.admin')

@section('title', 'Kelola Pengguna')
@section('header_title', 'Kelola Pengguna')
@section('header_subtitle', 'Manajemen daftar seluruh pengguna sistem SiPena')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4">
        <div class="relative flex items-center">
            <i data-lucide="search" class="w-4 h-4 text-gray-400 absolute left-3.5 pointer-events-none"></i>
            <input
                type="text"
                id="searchUser"
                placeholder="Cari nama atau email..."
                class="pl-10 pr-4 py-2 bg-white border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#173F35] w-full sm:w-72"
            >
        </div>

        <button
            type="button"
            onclick="openModalTambah()"
            class="px-4 py-2 bg-[#173F35] text-white rounded-xl text-sm font-semibold hover:bg-[#173F35]/90 transition cursor-pointer flex items-center justify-center gap-2 shrink-0"
        >
            <i data-lucide="plus" class="w-4 h-4"></i>
            <span>Tambah Pengguna</span>
        </button>
    </div>

    <div class="bg-white rounded-2xl border border-gray-200/60 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 bg-[#FCFAF5]">
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider w-12">No</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Pengguna</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">No. Telepon</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Role</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Bergabung</th>
                        <th class="text-right px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody id="userTable" class="divide-y divide-gray-100">
                    @forelse ($users as $index => $u)
                    @php
                        $initials = collect(explode(' ', trim($u->nama)))
                            ->filter()
                            ->map(fn($w) => strtoupper(substr($w, 0, 1)))
                            ->take(2)
                            ->join('');
                        if (empty($initials)) { $initials = 'US'; }
                    @endphp
                    <tr class="user-row hover:bg-[#FCFAF5]/70 transition-colors"
                        data-nama="{{ strtolower($u->nama) }}"
                        data-email="{{ strtolower($u->email) }}"
                    >
                        <td class="px-6 py-4 text-xs text-gray-400 whitespace-nowrap">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-[#173F35] text-[#F4E8CD] font-bold flex items-center justify-center text-xs shrink-0">
                                    {{ $initials }}
                                </div>
                                <div>
                                    <span class="font-bold text-[#173F35] block leading-snug">{{ $u->nama }}</span>
                                    <span class="text-xs text-gray-400 font-medium">{{ $u->email }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-600 text-xs font-medium whitespace-nowrap">
                            {{ $u->no_tlp ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($u->role === 'admin')
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-[#173F35] text-[#F4E8CD]">
                                    <i data-lucide="shield" class="w-3 h-3"></i>
                                    <span>Administrator</span>
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-[#FCFAF5] text-[#52796F] border border-gray-200">
                                    <i data-lucide="user" class="w-3 h-3"></i>
                                    <span>Anggota</span>
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-xs text-gray-500 whitespace-nowrap">
                            {{ $u->created_at ? $u->created_at->locale('id')->translatedFormat('d M Y') : '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <div class="flex items-center justify-end gap-1">
                                <button
                                    type="button"
                                    onclick='openModalEdit({
                                        id: @json($u->id),
                                        nama: @json($u->nama),
                                        email: @json($u->email),
                                        no_tlp: @json($u->no_tlp ?? ""),
                                        role: @json($u->role)
                                    })'
                                    class="p-1.5 rounded-lg text-gray-400 hover:text-[#173F35] hover:bg-gray-100 transition-colors cursor-pointer"
                                    title="Edit"
                                >
                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                </button>
                                <button
                                    type="button"
                                    onclick='openModalDelete(@json($u->id), @json($u->nama))'
                                    class="p-1.5 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition-colors cursor-pointer"
                                    title="Hapus"
                                >
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center gap-2 text-gray-400">
                                <i data-lucide="users" class="w-10 h-10 text-gray-300"></i>
                                <span class="text-sm font-medium">Belum ada data pengguna</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<div id="modalUserBackdrop" class="fixed inset-0 bg-black/40 z-40 hidden" onclick="closeUserModal()"></div>

<div id="modalTambahUser" class="fixed z-50 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-md bg-white rounded-2xl shadow-2xl hidden p-6">
    <div class="flex items-center justify-between mb-5">
        <h3 class="text-base font-bold text-[#173F35]">Tambah Pengguna Baru</h3>
        <button type="button" onclick="closeUserModal()" class="text-gray-400 hover:text-gray-700 p-1 rounded-lg cursor-pointer transition">
            <i data-lucide="x" class="w-5 h-5"></i>
        </button>
    </div>
    <form method="POST" action="{{ route('admin.pengguna.store') }}">
        @csrf
        <div class="space-y-4">
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Nama Lengkap</label>
                <input
                    type="text"
                    name="nama"
                    placeholder="Contoh: Budi Santoso"
                    class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#173F35]"
                    required
                >
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Email</label>
                <input
                    type="email"
                    name="email"
                    placeholder="Contoh: budi@gmail.com"
                    class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#173F35]"
                    required
                >
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">No. Telepon</label>
                <input
                    type="text"
                    name="no_tlp"
                    placeholder="Contoh: 081234567890"
                    class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#173F35]"
                    required
                >
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Peran / Role</label>
                <select name="role" class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#173F35]" required>
                    <option value="user">Anggota (User)</option>
                    <option value="admin">Administrator</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Password</label>
                <input
                    type="password"
                    name="password"
                    placeholder="Minimal 6 karakter"
                    class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#173F35]"
                    required
                >
            </div>
        </div>

        <div class="flex gap-3 mt-6">
            <button type="button" onclick="closeUserModal()"
                class="flex-1 py-2.5 border border-gray-200 text-gray-700 hover:bg-gray-50 rounded-xl text-xs font-semibold transition cursor-pointer">
                Batal
            </button>
            <button type="submit"
                class="flex-1 py-2.5 bg-[#173F35] text-white hover:bg-[#173F35]/90 rounded-xl text-xs font-semibold transition cursor-pointer">
                Simpan
            </button>
        </div>
    </form>
</div>

<div id="modalEditUser" class="fixed z-50 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-md bg-white rounded-2xl shadow-2xl hidden p-6">
    <div class="flex items-center justify-between mb-5">
        <h3 class="text-base font-bold text-[#173F35]">Edit Data Pengguna</h3>
        <button type="button" onclick="closeUserModal()" class="text-gray-400 hover:text-gray-700 p-1 rounded-lg cursor-pointer transition">
            <i data-lucide="x" class="w-5 h-5"></i>
        </button>
    </div>
    <form method="POST" action="{{ route('admin.pengguna.update') }}">
        @csrf
        @method('PUT')
        <input type="text" name="id" id="editUserId" hidden>
        <div class="space-y-4">
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Nama Lengkap</label>
                <input
                    type="text"
                    id="editNama"
                    name="nama"
                    class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#173F35]"
                    required
                >
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Email</label>
                <input
                    type="email"
                    id="editEmail"
                    name="email"
                    class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#173F35]"
                    required
                >
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">No. Telepon</label>
                <input
                    type="text"
                    id="editNoTlp"
                    name="no_tlp"
                    class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#173F35]"
                    required
                >
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Peran / Role</label>
                <select id="editRole" name="role" class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#173F35]" required>
                    <option value="user">Anggota (User)</option>
                    <option value="admin">Administrator</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Ganti Password (Opsional)</label>
                <input
                    type="password"
                    name="password"
                    placeholder="Kosongkan jika tidak ingin mengubah"
                    class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#173F35]"
                >
            </div>
        </div>

        <div class="flex gap-3 mt-6">
            <button type="button" onclick="closeUserModal()"
                class="flex-1 py-2.5 border border-gray-200 text-gray-700 hover:bg-gray-50 rounded-xl text-xs font-semibold transition cursor-pointer">
                Batal
            </button>
            <button type="submit"
                class="flex-1 py-2.5 bg-[#173F35] text-white hover:bg-[#173F35]/90 rounded-xl text-xs font-semibold transition cursor-pointer">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<div id="modalHapusUser" class="fixed z-50 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-sm bg-white rounded-2xl shadow-2xl hidden p-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-base font-bold text-[#173F35]">Hapus Pengguna</h3>
        <button type="button" onclick="closeUserModal()" class="text-gray-400 hover:text-gray-700 p-1 rounded-lg cursor-pointer transition">
            <i data-lucide="x" class="w-5 h-5"></i>
        </button>
    </div>
    <form method="POST" action="{{ route('admin.pengguna.destroy') }}">
        @csrf
        @method('DELETE')
        <input type="text" name="id" id="hapusUserId" hidden>
        <p class="text-xs text-gray-600 leading-relaxed mb-6">
            Apakah Anda yakin ingin menghapus akun <strong id="hapusUserNama" class="text-red-600 font-bold"></strong>? Tindakan ini tidak dapat dibatalkan.
        </p>
        <div class="flex gap-3">
            <button type="button" onclick="closeUserModal()"
                class="flex-1 py-2.5 border border-gray-200 text-gray-700 hover:bg-gray-50 rounded-xl text-xs font-semibold transition cursor-pointer">
                Batal
            </button>
            <button type="submit"
                class="flex-1 py-2.5 bg-red-600 text-white hover:bg-red-700 rounded-xl text-xs font-semibold transition cursor-pointer">
                Ya, Hapus
            </button>
        </div>
    </form>
</div>

<script>
    function openModalTambah() {
        document.getElementById('modalUserBackdrop').classList.remove('hidden');
        document.getElementById('modalTambahUser').classList.remove('hidden');
    }

    function openModalEdit(data) {
        document.getElementById('editUserId').value = data.id;
        document.getElementById('editNama').value = data.nama;
        document.getElementById('editEmail').value = data.email;
        document.getElementById('editNoTlp').value = data.no_tlp;
        document.getElementById('editRole').value = data.role;

        document.getElementById('modalUserBackdrop').classList.remove('hidden');
        document.getElementById('modalEditUser').classList.remove('hidden');
    }

    function openModalDelete(id, nama) {
        document.getElementById('hapusUserId').value = id;
        document.getElementById('hapusUserNama').innerText = nama;
        document.getElementById('modalUserBackdrop').classList.remove('hidden');
        document.getElementById('modalHapusUser').classList.remove('hidden');
    }

    function closeUserModal() {
        document.getElementById('modalUserBackdrop').classList.add('hidden');
        document.getElementById('modalTambahUser').classList.add('hidden');
        document.getElementById('modalEditUser').classList.add('hidden');
        document.getElementById('modalHapusUser').classList.add('hidden');
    }

    document.getElementById('searchUser').addEventListener('input', function () {
        const q = this.value.toLowerCase();
        document.querySelectorAll('.user-row').forEach(row => {
            const nama = row.getAttribute('data-nama') || '';
            const email = row.getAttribute('data-email') || '';
            row.style.display = (nama.includes(q) || email.includes(q)) ? '' : 'none';
        });
    });
</script>
@endsection
