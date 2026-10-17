@extends('layouts.admin')

@section('title', 'Dashboard Administrator')


@section('content')
<div class="space-y-8">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

        <a href="#" class="group bg-[#173F35] text-white p-5 rounded-2xl shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-200 flex items-center justify-between cursor-pointer border border-[#173F35]">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center text-[#F4E8CD] group-hover:scale-110 transition-transform">
                    <i data-lucide="book-plus" class="w-6 h-6"></i>
                </div>
                <div>
                    <h3 class="text-base font-bold text-white group-hover:text-[#F4E8CD] transition-colors">+ Catat Peminjaman</h3>
                    <p class="text-xs text-white/70">Member datang meminjam</p>
                </div>
            </div>
            <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center text-[#F4E8CD] group-hover:bg-[#F4E8CD] group-hover:text-[#173F35] transition-all shrink-0">
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </div>
        </a>

        <a href="#" class="group bg-[#52796F] text-white p-5 rounded-2xl shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-200 flex items-center justify-between cursor-pointer border border-[#52796F]">
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

        <a href="#" class="group bg-[#F4E8CD] text-[#173F35] p-5 rounded-2xl shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-200 flex items-center justify-between cursor-pointer border border-[#173F35]/15">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-[#173F35]/10 flex items-center justify-center text-[#173F35] group-hover:scale-110 transition-transform">
                    <i data-lucide="plus-circle" class="w-6 h-6"></i>
                </div>
                <div>
                    <h3 class="text-base font-bold text-[#173F35]">+ Tambah Buku</h3>
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
                <span class="text-3xl font-extrabold text-[#173F35]">1.240</span>
                <i data-lucide="book" class="w-5 h-5 text-gray-300"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-gray-200/60 shadow-xs flex flex-col justify-between">
            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Anggota aktif</span>
            <div class="mt-3 flex items-baseline justify-between">
                <span class="text-3xl font-extrabold text-[#173F35]">312</span>
                <i data-lucide="users" class="w-5 h-5 text-gray-300"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-gray-200/60 shadow-xs flex flex-col justify-between">
            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Sedang dipinjam</span>
            <div class="mt-3 flex items-baseline justify-between">
                <span class="text-3xl font-extrabold text-[#173F35]">24</span>
                <i data-lucide="bookmark" class="w-5 h-5 text-gray-300"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-red-100 shadow-xs flex flex-col justify-between border-b-4 border-b-red-600 overflow-hidden">
            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Terlambat</span>
            <div class="mt-3 flex items-baseline justify-between">
                <span class="text-3xl font-extrabold text-red-600">2</span>
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
                <span class="text-xs bg-red-50 text-red-600 font-semibold px-2.5 py-1 rounded-full border border-red-100">
                    3 Perlu Perhatian
                </span>
            </div>

            <div class="divide-y divide-gray-100">
                <div class="py-4 px-3 flex items-center justify-between gap-4 hover:bg-[#FCFAF5]/70 rounded-xl transition-colors">
                    <div class="flex items-center gap-3.5 min-w-0">
                        <div class="w-10 h-10 rounded-full bg-[#F4E8CD] text-[#173F35] font-bold text-sm flex items-center justify-center shrink-0">
                            DL
                        </div>
                        <div class="min-w-0">
                            <h4 class="text-sm font-semibold text-[#173F35] truncate">Dewi Lestari</h4>
                            <p class="text-xs text-gray-500 truncate">
                                <span class="font-medium text-gray-800">Bumi Manusia</span> · tenggat 9 Okt
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 shrink-0">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-600 border border-red-100">
                            Terlambat
                        </span>
                        <button type="button" class="px-3.5 py-1.5 rounded-lg bg-[#173F35] text-white hover:bg-[#173F35]/90 text-xs font-semibold transition cursor-pointer flex items-center gap-1.5">
                            <span>Kembalikan</span>
                        </button>
                    </div>
                </div>

                <div class="py-4 px-3 flex items-center justify-between gap-4 hover:bg-[#FCFAF5]/70 rounded-xl transition-colors">
                    <div class="flex items-center gap-3.5 min-w-0">
                        <div class="w-10 h-10 rounded-full bg-[#F4E8CD] text-[#173F35] font-bold text-sm flex items-center justify-center shrink-0">
                            RS
                        </div>
                        <div class="min-w-0">
                            <h4 class="text-sm font-semibold text-[#173F35] truncate">Rina Safitri</h4>
                            <p class="text-xs text-gray-500 truncate">
                                <span class="font-medium text-gray-800">Laskar Pelangi</span> · tenggat hari ini
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 shrink-0">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                            Jatuh tempo
                        </span>
                        <button type="button" class="px-3.5 py-1.5 rounded-lg bg-[#173F35] text-white hover:bg-[#173F35]/90 text-xs font-semibold transition cursor-pointer flex items-center gap-1.5">
                            <span>Kembalikan</span>
                        </button>
                    </div>
                </div>

                <div class="py-4 px-3 flex items-center justify-between gap-4 hover:bg-[#FCFAF5]/70 rounded-xl transition-colors">
                    <div class="flex items-center gap-3.5 min-w-0">
                        <div class="w-10 h-10 rounded-full bg-[#F4E8CD] text-[#173F35] font-bold text-sm flex items-center justify-center shrink-0">
                            BS
                        </div>
                        <div class="min-w-0">
                            <h4 class="text-sm font-semibold text-[#173F35] truncate">Budi Santoso</h4>
                            <p class="text-xs text-gray-500 truncate">
                                <span class="font-medium text-gray-800">Atomic Habits</span> · tenggat 19 Okt
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 shrink-0">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-600 border border-gray-200">
                            Dipinjam
                        </span>
                        <button type="button" class="px-3.5 py-1.5 rounded-lg bg-[#173F35] text-white hover:bg-[#173F35]/90 text-xs font-semibold transition cursor-pointer flex items-center gap-1.5">
                            <span>Kembalikan</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-1 bg-white rounded-2xl p-6 border border-gray-200/60 shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-5">
                    <h2 class="text-lg font-bold text-[#173F35]">Aktivitas terbaru</h2>
                    <i data-lucide="history" class="w-4 h-4 text-gray-400"></i>
                </div>

                <ul class="flex flex-col gap-4">
                    <li class="flex items-start gap-3">
                        <div class="w-2 h-2 rounded-full bg-[#173F35] mt-1.5 shrink-0"></div>
                        <div class="text-xs text-gray-700 leading-relaxed">
                            <span class="font-bold text-[#173F35]">09.12</span>
                            <span class="font-semibold text-gray-900">Siti Aminah</span> meminjam
                            <span class="italic font-medium text-[#173F35]">Filosofi Teras</span>
                        </div>
                    </li>

                    <li class="flex items-start gap-3">
                        <div class="w-2 h-2 rounded-full bg-[#52796F] mt-1.5 shrink-0"></div>
                        <div class="text-xs text-gray-700 leading-relaxed">
                            <span class="font-bold text-[#173F35]">08.47</span>
                            <span class="font-semibold text-gray-900">Agus Wijaya</span> mengembalikan
                            <span class="italic font-medium text-[#173F35]">Sapiens</span>
                        </div>
                    </li>

                    <li class="flex items-start gap-3">
                        <div class="w-2 h-2 rounded-full bg-[#173F35] mt-1.5 shrink-0"></div>
                        <div class="text-xs text-gray-700 leading-relaxed">
                            <span class="font-bold text-[#173F35]">08.15</span>
                            <span class="font-semibold text-gray-900">Rina Safitri</span> meminjam
                            <span class="italic font-medium text-[#173F35]">Cantik Itu Luka</span>
                        </div>
                    </li>

                    <li class="flex items-start gap-3">
                        <div class="w-2 h-2 rounded-full bg-amber-500 mt-1.5 shrink-0"></div>
                        <div class="text-xs text-gray-700 leading-relaxed">
                            <span class="font-bold text-[#173F35]">Kemarin</span>
                            <span class="font-semibold text-gray-900">Budi Santoso</span> mendaftar anggota baru
                        </div>
                    </li>
                </ul>
            </div>

            <div class="pt-6 border-t border-gray-100 mt-6 text-center">
                <a href="#" class="inline-flex items-center gap-1.5 text-xs font-bold text-[#173F35] hover:text-[#52796F] transition-colors">
                    <span>Lihat Seluruh Aktivitas</span>
                    <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection