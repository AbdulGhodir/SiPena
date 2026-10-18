@extends('layouts.admin')

@section('title', 'Dashboard Administrator')
@section('header_title', 'Dashboard Administrator')
@section('header_subtitle', 'Pantau aktivitas dan kelola perpustakaan')

@section('content')
<div class="space-y-8">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

        <a href="{{ route('admin.peminjaman') }}" class="group bg-[#173F35] text-white p-5 rounded-2xl shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-200 flex items-center justify-between cursor-pointer border border-[#173F35]">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center text-[#F4E8CD] group-hover:scale-110 transition-transform">
                    <i data-lucide="book-plus" class="w-6 h-6"></i>
                </div>
                <div>
                    <h3 class="text-base font-bold text-white group-hover:text-[#F4E8CD] transition-colors">Catat Peminjaman</h3>
                    <p class="text-xs text-white/70">Member datang meminjam</p>
                </div>
            </div>
            <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center text-[#F4E8CD] group-hover:bg-[#F4E8CD] group-hover:text-[#173F35] transition-all shrink-0">
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </div>
        </a>

        <a href="{{ route('admin.peminjaman') }}" class="group bg-[#52796F] text-white p-5 rounded-2xl shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-200 flex items-center justify-between cursor-pointer border border-[#52796F]">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-white/15 flex items-center justify-center text-white group-hover:scale-110 transition-transform">
                    <i data-lucide="book-down" class="w-6 h-6"></i>
                </div>
                <div>
                    <h3 class="text-base font-bold text-white">Catat Pengembalian</h3>
                    <p class="text-xs text-white/70">Member mengembalikan buku</p>
                </div>
            </div>
            <div class="w-8 h-8 rounded-full bg-white/15 flex items-center justify-center text-white group-hover:bg-white group-hover:text-[#52796F] transition-all shrink-0">
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </div>
        </a>

        <a href="{{ route('admin.buku') }}" class="group bg-[#F4E8CD] text-[#173F35] p-5 rounded-2xl shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-200 flex items-center justify-between cursor-pointer border border-[#173F35]/15">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-[#173F35]/10 flex items-center justify-center text-[#173F35] group-hover:scale-110 transition-transform">
                    <i data-lucide="plus-circle" class="w-6 h-6"></i>
                </div>
                <div>
                    <h3 class="text-base font-bold text-[#173F35]">Tambah Buku</h3>
                    <p class="text-xs text-[#52796F]">Koleksi baru masuk</p>
                </div>
            </div>
            <div class="w-8 h-8 rounded-full bg-[#173F35]/10 flex items-center justify-center text-[#173F35] group-hover:bg-[#173F35] group-hover:text-[#F4E8CD] transition-all shrink-0">
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </div>
        </a>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="bg-white p-5 rounded-2xl border border-gray-200/60 shadow-xs flex flex-col justify-between">
            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total buku</span>
            <div class="mt-3 flex items-baseline justify-between">
                <span class="text-3xl font-extrabold text-[#173F35]">{{ $totalBuku }}</span>
                <i data-lucide="book" class="w-5 h-5 text-gray-300"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-gray-200/60 shadow-xs flex flex-col justify-between">
            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Anggota aktif</span>
            <div class="mt-3 flex items-baseline justify-between">
                <span class="text-3xl font-extrabold text-[#173F35]">{{ $totalAnggota }}</span>
                <i data-lucide="users" class="w-5 h-5 text-gray-300"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-gray-200/60 shadow-xs flex flex-col justify-between">
            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Sedang dipinjam</span>
            <div class="mt-3 flex items-baseline justify-between">
                <span class="text-3xl font-extrabold text-[#173F35]">{{ $totalSedangDipinjam }}</span>
                <i data-lucide="bookmark" class="w-5 h-5 text-gray-300"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-red-100 shadow-xs flex flex-col justify-between border-b-4 border-b-red-600 overflow-hidden">
            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Terlambat</span>
            <div class="mt-3 flex items-baseline justify-between">
                <span class="text-3xl font-extrabold text-red-600">{{ $totalTerlambat }}</span>
                <i data-lucide="alert-circle" class="w-5 h-5 text-red-400"></i>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white rounded-2xl p-6 border border-gray-200/60 shadow-xs">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h2 class="text-lg font-bold text-[#173F35]">Perlu ditindaklanjuti</h2>
                    <p class="text-xs text-[#52796F] mt-0.5">Peminjaman yang memerlukan konfirmasi atau pengembalian</p>
                </div>
                <span>
                    <a href="{{ route('admin.peminjaman') }}" class="text-xs group text-[#173F35] cursor-pointer hover:underline transition-colors duration-200 font-semibold px-2.5 py-1 rounded-full flex items-center gap-1">
                        Lihat Semua
                        <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-all duration-200"></i>
                    </a>
                </span>
            </div>

            <div class="divide-y divide-gray-100">
                @forelse ($perluTindakLanjut as $item)
                    @php
                        $tenggat = \Carbon\Carbon::parse($item->jatuh_tempo)->locale('id');
                        if ($tenggat->isToday()) {
                            $labelTenggat = 'hari ini';
                        } elseif ($tenggat->isYesterday()) {
                            $labelTenggat = 'kemarin';
                        } elseif ($tenggat->isTomorrow()) {
                            $labelTenggat = 'besok';
                        } else {
                            $labelTenggat = $tenggat->translatedFormat('d M');
                        }
                        $initials = collect(explode(' ', trim($item->user->nama ?? 'Pengguna')))
                            ->filter()
                            ->map(fn($w) => strtoupper(substr($w, 0, 1)))
                            ->take(2)
                            ->join('');
                        if (empty($initials)) { $initials = 'PG'; }
                    @endphp

                    <div class="py-4 px-3 flex items-center justify-between gap-4 hover:bg-[#FCFAF5]/70 rounded-xl transition-colors">
                        <div class="flex items-center gap-3.5 min-w-0">
                            <div class="w-10 h-10 rounded-full bg-[#F4E8CD] text-[#173F35] font-bold text-sm flex items-center justify-center shrink-0">
                                {{ $initials }}
                            </div>
                            <div class="min-w-0">
                                <h4 class="text-sm font-semibold text-[#173F35] truncate">{{ $item->user->nama }}</h4>
                                <p class="text-xs text-gray-500 truncate">
                                    <span class="font-medium text-gray-800">
                                        {{ $item->book->judul }}
                                    </span>
                                    · tenggat {{ $labelTenggat }}
                                </p>
                            </div>
                        </div>

                        @if ($item->status == 'terlambat')
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-600 border border-red-100">
                                Terlambat
                            </span>
                        @else
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                Jatuh Tempo
                            </span>
                        @endif
                    </div>
                @empty
                    <div class="text-center py-12">
                        <i data-lucide="check-circle" class="w-12 h-12 text-green-500 mx-auto mb-3"></i>
                        <h4 class="text-lg font-semibold text-[#173F35]">Tidak ada yang perlu ditindaklanjuti</h4>
                        <p class="text-xs text-gray-500">Semua berjalan lancar</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="lg:col-span-1 bg-white rounded-2xl p-6 border border-gray-200/60 shadow-xs flex flex-col justify-between">
            <div class="flex flex-col gap-3">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-bold text-[#173F35]">Aktivitas terbaru</h2>
                    <i data-lucide="history" class="w-4 h-4 text-gray-400"></i>
                </div>

                <ul class="flex flex-col gap-4">
                    @forelse ($aktivitasTerbaru as $aktivitas)
                        <li class="flex items-start gap-3">
                            <div class="w-2 h-2 rounded-full {{ $aktivitas['warna_dot'] }} mt-1.5 shrink-0"></div>
                            <div class="text-xs text-gray-700 leading-relaxed">
                                <span class="font-bold text-[#173F35]">{{ $aktivitas['waktu_label'] }}</span>
                                <span class="font-semibold text-gray-900">{{ $aktivitas['nama'] }}</span> {{ $aktivitas['aksi'] }}
                                @if ($aktivitas['objek'])
                                    <span class="italic font-medium text-[#173F35]">{{ $aktivitas['objek'] }}</span>
                                @endif
                            </div>
                        </li>
                    @empty
                        <li>
                            <p>Belum ada aktivitas</p>
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection