@extends('layouts.admin')

@section('title', 'Transaksi Peminjaman')
@section('header_title', 'Transaksi Peminjaman')
@section('header_subtitle', 'Pantau dan kelola sirkulasi buku')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4">
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
            <div class="relative flex items-center">
                <i data-lucide="search" class="w-4 h-4 text-gray-400 absolute left-3.5 pointer-events-none"></i>
                <input
                    type="text"
                    id="searchBorrowing"
                    placeholder="Cari nama peminjam atau judul buku..."
                    class="pl-10 pr-4 py-2 bg-white border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#173F35] w-full sm:w-80"
                >
            </div>

            <select id="filterStatusBorrowing" class="px-3.5 py-2 bg-white border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#173F35] text-gray-700 cursor-pointer">
                <option value="">Semua Status</option>
                <option value="dipinjam">Dipinjam</option>
                <option value="terlambat">Terlambat</option>
                <option value="dikembalikan">Dikembalikan</option>
            </select>
        </div>

        <button
            type="button"
            onclick="openModalPeminjaman()"
            class="px-4 py-2 bg-[#173F35] text-white rounded-xl text-sm font-semibold hover:bg-[#173F35]/90 transition cursor-pointer flex items-center justify-center gap-2 shrink-0"
        >
            <i data-lucide="plus" class="w-4 h-4"></i>
            <span>Catat Peminjaman</span>
        </button>
    </div>

    <div class="bg-white rounded-2xl border border-gray-200/60 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 bg-[#FCFAF5]">
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Peminjam</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Buku</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal / Tenggat</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="text-right px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody id="borrowingTable" class="divide-y divide-gray-100">
                    @forelse ($borrowings as $b)
                    @php
                        $userName = $b->user->nama ?? 'Pengguna Dihapus';
                        $userId = $b->user ? ('ID: #' . $b->user->id) : '-';
                        $initials = collect(explode(' ', trim($userName)))
                            ->filter()
                            ->map(fn($w) => strtoupper(substr($w, 0, 1)))
                            ->take(2)
                            ->join('');
                        if (empty($initials)) { $initials = 'PG'; }

                        $bookTitle = $b->book->judul ?? 'Buku Tidak Diketahui';
                        $bookAuthor = $b->book->penulis ?? '-';
                    @endphp
                    <tr class="borrowing-row hover:bg-[#FCFAF5]/70 transition-colors"
                        data-user="{{ strtolower($userName) }}"
                        data-book="{{ strtolower($bookTitle) }}"
                        data-status="{{ $b->status }}"
                    >
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-[#173F35] text-[#F4E8CD] font-bold flex items-center justify-center text-xs shrink-0">
                                    {{ $initials }}
                                </div>
                                <div>
                                    <span class="font-bold text-[#173F35] block leading-snug">{{ $userName }}</span>
                                    <span class="text-xs text-gray-400 font-medium">{{ $userId }}</span>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-[#173F35] text-[#F4E8CD] flex items-center justify-center shrink-0">
                                    <i data-lucide="book" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <span class="font-bold text-[#173F35] block leading-snug">{{ $bookTitle }}</span>
                                    <span class="text-xs text-gray-400 font-medium">{{ $bookAuthor }}</span>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="font-medium text-gray-800 block">
                                {{ \Carbon\Carbon::parse($b->tanggal_pinjam)->locale('id')->translatedFormat('d M Y') }}
                            </span>
                            @if ($b->status === 'dikembalikan')
                                <span class="text-xs text-gray-400 block mt-0.5 font-medium">
                                    Kembali: {{ $b->tanggal_kembali ? \Carbon\Carbon::parse($b->tanggal_kembali)->locale('id')->translatedFormat('d M Y') : '-' }}
                                </span>
                            @elseif ($b->status === 'terlambat')
                                <span class="text-xs text-red-500 block mt-0.5 font-semibold">
                                    Tenggat: {{ \Carbon\Carbon::parse($b->jatuh_tempo)->locale('id')->translatedFormat('d M Y') }}
                                </span>
                            @else
                                <span class="text-xs text-[#52796F] block mt-0.5 font-medium">
                                    Tenggat: {{ \Carbon\Carbon::parse($b->jatuh_tempo)->locale('id')->translatedFormat('d M Y') }}
                                </span>
                            @endif
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($b->status === 'terlambat')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-600 border border-red-100">
                                    <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>
                                    <span>Terlambat</span>
                                </span>
                            @elseif ($b->status === 'dipinjam')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                    <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                                    <span>Dipinjam</span>
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-gray-50 text-gray-600 border border-gray-200">
                                    <i data-lucide="check" class="w-3.5 h-3.5"></i>
                                    <span>Dikembalikan</span>
                                </span>
                            @endif
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            @if ($b->status !== 'dikembalikan')
                                <button
                                    type="button"
                                    onclick='openModalKembalikan(@json($b->id), @json($bookTitle), @json($userName))'
                                    class="px-3.5 py-1.5 rounded-xl text-xs font-semibold bg-[#173F35] text-white hover:bg-[#173F35]/90 transition cursor-pointer inline-flex items-center gap-1.5"
                                >
                                    <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                                    <span>Kembalikan</span>
                                </button>
                            @else
                                <span class="text-xs text-gray-400 font-medium inline-flex items-center gap-1">
                                    <i data-lucide="check-circle" class="w-3.5 h-3.5 text-emerald-600"></i>
                                    <span>Selesai</span>
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center gap-2 text-gray-400">
                                <i data-lucide="inbox" class="w-10 h-10 text-gray-300"></i>
                                <span class="text-sm font-medium">Belum ada catatan peminjaman</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-gray-500">
            <span>Menampilkan {{ $borrowings->count() > 0 ? 1 : 0 }}-{{ $borrowings->count() }} dari {{ $borrowings->count() }} transaksi</span>
            <div class="flex items-center gap-1">
                <button type="button" class="px-3 py-1.5 rounded-lg border border-gray-200 text-gray-400 hover:bg-gray-50 cursor-pointer transition">
                    &lt;
                </button>
                <button type="button" class="px-3 py-1.5 rounded-lg bg-[#173F35] text-white font-semibold cursor-pointer">
                    1
                </button>
                <button type="button" class="px-3 py-1.5 rounded-lg border border-gray-200 text-gray-400 hover:bg-gray-50 cursor-pointer transition">
                    &gt;
                </button>
            </div>
        </div>
    </div>

</div>

<div id="modalPeminjamanBackdrop" class="fixed inset-0 bg-black/40 z-40 hidden" onclick="closeModalPeminjaman()"></div>

<div id="modalCatatPeminjaman" class="fixed z-50 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-md bg-white rounded-2xl shadow-2xl hidden p-6">
    <div class="flex items-center justify-between mb-5">
        <h3 class="text-base font-bold text-[#173F35]">Catat Peminjaman Buku</h3>
        <button type="button" onclick="closeModalPeminjaman()" class="text-gray-400 hover:text-gray-700 p-1 rounded-lg cursor-pointer transition">
            <i data-lucide="x" class="w-5 h-5"></i>
        </button>
    </div>
    <form method="POST" action="{{ route('admin.peminjaman.store') }}">
        @csrf
        <div class="space-y-4">
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Pilih Anggota</label>
                <select name="id_user" class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#173F35]" required>
                    <option value="">Pilih Anggota Peminjam</option>
                    @foreach ($members as $m)
                        <option value="{{ $m->id }}">{{ $m->nama }} ({{ $m->email }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Pilih Buku</label>
                <select name="id_buku" class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#173F35]" required>
                    <option value="">Pilih Buku yang Dipinjam</option>
                    @foreach ($books as $bk)
                        <option value="{{ $bk->id }}">{{ $bk->judul }} - Stok: {{ $bk->stok }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Tanggal Pinjam</label>
                <input
                    type="date"
                    name="tanggal_pinjam"
                    value="{{ date('Y-m-d') }}"
                    class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#173F35]"
                    required
                >
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Jatuh Tempo</label>
                <input
                    type="date"
                    name="jatuh_tempo"
                    value="{{ date('Y-m-d', strtotime('+7 days')) }}"
                    class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#173F35]"
                    required
                >
            </div>
        </div>

        <div class="flex gap-3 mt-6">
            <button type="button" onclick="closeModalPeminjaman()"
                class="flex-1 py-2.5 border border-gray-200 text-gray-700 hover:bg-gray-50 rounded-xl text-xs font-semibold transition cursor-pointer">
                Batal
            </button>
            <button type="submit"
                class="flex-1 py-2.5 bg-[#173F35] text-white hover:bg-[#173F35]/90 rounded-xl text-xs font-semibold transition cursor-pointer">
                Simpan Transaksi
            </button>
        </div>
    </form>
</div>

<div id="modalKembalikan" class="fixed z-50 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-sm bg-white rounded-2xl shadow-2xl hidden p-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-base font-bold text-[#173F35]">Konfirmasi Pengembalian</h3>
        <button type="button" onclick="closeModalPeminjaman()" class="text-gray-400 hover:text-gray-700 p-1 rounded-lg cursor-pointer transition">
            <i data-lucide="x" class="w-5 h-5"></i>
        </button>
    </div>
    <form method="POST" action="{{ route('admin.peminjaman.kembalikan') }}">
        @csrf
        @method('PUT')
        <input type="text" name="id" id="kembalikanId" hidden>
        <p class="text-xs text-gray-600 leading-relaxed mb-6">
            Apakah benar buku <strong id="kembalikanBukuJudul" class="text-[#173F35] font-bold"></strong> yang dipinjam oleh <strong id="kembalikanUserNama" class="text-gray-800 font-bold"></strong> ini dikembalikan?
        </p>
        <div class="flex gap-3">
            <button type="button" onclick="closeModalPeminjaman()"
                class="flex-1 py-2.5 border border-gray-200 text-gray-700 hover:bg-gray-50 rounded-xl text-xs font-semibold transition cursor-pointer">
                Batal
            </button>
            <button type="submit"
                class="flex-1 py-2.5 bg-[#173F35] text-white hover:bg-[#173F35]/90 rounded-xl text-xs font-semibold transition cursor-pointer">
                Ya, Kembalikan
            </button>
        </div>
    </form>
</div>

<script>
    function openModalPeminjaman() {
        document.getElementById('modalPeminjamanBackdrop').classList.remove('hidden');
        document.getElementById('modalCatatPeminjaman').classList.remove('hidden');
    }

    function openModalKembalikan(id, buku, user) {
        document.getElementById('kembalikanId').value = id;
        document.getElementById('kembalikanBukuJudul').innerText = buku;
        document.getElementById('kembalikanUserNama').innerText = user;
        document.getElementById('modalPeminjamanBackdrop').classList.remove('hidden');
        document.getElementById('modalKembalikan').classList.remove('hidden');
    }

    function closeModalPeminjaman() {
        document.getElementById('modalPeminjamanBackdrop').classList.add('hidden');
        document.getElementById('modalCatatPeminjaman').classList.add('hidden');
        document.getElementById('modalKembalikan').classList.add('hidden');
    }

    document.getElementById('searchBorrowing').addEventListener('input', filterBorrowings);
    document.getElementById('filterStatusBorrowing').addEventListener('change', filterBorrowings);

    function filterBorrowings() {
        const q = document.getElementById('searchBorrowing').value.toLowerCase();
        const status = document.getElementById('filterStatusBorrowing').value;

        document.querySelectorAll('.borrowing-row').forEach(row => {
            const user = row.getAttribute('data-user') || '';
            const book = row.getAttribute('data-book') || '';
            const rowStatus = row.getAttribute('data-status') || '';

            const matchQuery = user.includes(q) || book.includes(q);
            const matchStatus = !status || rowStatus === status;

            row.style.display = (matchQuery && matchStatus) ? '' : 'none';
        });
    }
</script>
@endsection
