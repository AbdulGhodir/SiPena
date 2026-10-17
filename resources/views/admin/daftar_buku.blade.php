@extends('layouts.admin')

@section('title', 'Kelola Data Buku')
@section('header_title', 'Kelola Data Buku')
@section('header_subtitle', 'Manajemen katalog perpustakaan')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4">
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
            <div class="relative flex items-center">
                <i data-lucide="search" class="w-4 h-4 text-gray-400 absolute left-3.5 pointer-events-none"></i>
                <input type="text" placeholder="Cari buku..." class="pl-10 pr-4 py-2 bg-white border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#173F35] w-full sm:w-64">
            </div>

            <select class="px-3.5 py-2 bg-white border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#173F35] text-gray-700 cursor-pointer">
                <option value="">Semua Kategori</option>
                <option value="novel">Novel</option>
                <option value="pengembangan_diri">Pengembangan Diri</option>
                <option value="sastra">Sastra</option>
                <option value="filsafat">Filsafat</option>
            </select>
        </div>

        <button type="button" class="px-4 py-2 bg-[#173F35] text-white rounded-xl text-sm font-semibold hover:bg-[#173F35]/90 transition cursor-pointer flex items-center justify-center gap-2 shrink-0">
            <i data-lucide="plus" class="w-4 h-4"></i>
            <span>+ Tambah Buku</span>
        </button>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="bg-white p-4 rounded-2xl border border-gray-200/60 shadow-xs flex flex-col justify-between">
            <div class="space-y-3">
                <div class="w-full h-40 bg-gray-100 rounded-xl flex items-center justify-center text-gray-400">
                    <i data-lucide="book" class="w-10 h-10 text-[#173F35]/40"></i>
                </div>
                <div>
                    <h3 class="font-bold text-[#173F35] text-base truncate">Laskar Pelangi</h3>
                    <p class="text-xs text-gray-500 truncate">Andrea Hirata</p>
                </div>
                <div class="flex items-center justify-between text-xs pt-1">
                    <span class="px-2.5 py-0.5 rounded-md bg-[#F4E8CD] text-[#173F35] font-semibold text-[11px]">Novel</span>
                    <span class="text-gray-500 font-medium">5 Tersedia</span>
                </div>
            </div>
            <button type="button" onclick="openBookDrawer({
                title: 'Laskar Pelangi',
                author: 'Andrea Hirata',
                category: 'Novel',
                stock: 'Tersedia 5 Buku',
                isbn: '978-602-1234',
                publisher: 'Bentang Pustaka',
                year: '2005',
                shelf: 'Rak Sastra-01',
                synopsis: 'Buku ini merupakan karya fiksi yang menceritakan perjalanan sekelompok anak di pedalaman dalam meraih pendidikan dan cita-cita mereka di tengah berbagai keterbatasan...'
            })" class="w-full mt-4 py-2 border border-[#173F35] text-[#173F35] hover:bg-[#173F35] hover:text-white rounded-xl text-xs font-semibold transition cursor-pointer">
                Selengkapnya
            </button>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-gray-200/60 shadow-xs flex flex-col justify-between">
            <div class="space-y-3">
                <div class="w-full h-40 bg-gray-100 rounded-xl flex items-center justify-center text-gray-400">
                    <i data-lucide="book" class="w-10 h-10 text-[#173F35]/40"></i>
                </div>
                <div>
                    <h3 class="font-bold text-[#173F35] text-base truncate">Atomic Habits</h3>
                    <p class="text-xs text-gray-500 truncate">James Clear</p>
                </div>
                <div class="flex items-center justify-between text-xs pt-1">
                    <span class="px-2.5 py-0.5 rounded-md bg-[#F4E8CD] text-[#173F35] font-semibold text-[11px]">Pengembangan Diri</span>
                    <span class="text-red-600 font-semibold">Stok Habis</span>
                </div>
            </div>
            <button type="button" onclick="openBookDrawer({
                title: 'Atomic Habits',
                author: 'James Clear',
                category: 'Pengembangan Diri',
                stock: 'Stok Habis',
                isbn: '978-602-5678',
                publisher: 'Gramedia Pustaka Utama',
                year: '2018',
                shelf: 'Rak Self-03',
                synopsis: 'Perubahan kecil yang memberikan hasil luar biasa. Buku panduan praktis untuk membangun kebiasaan baik dan membuang kebiasaan buruk setiap harinya.'
            })" class="w-full mt-4 py-2 border border-[#173F35] text-[#173F35] hover:bg-[#173F35] hover:text-white rounded-xl text-xs font-semibold transition cursor-pointer">
                Selengkapnya
            </button>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-gray-200/60 shadow-xs flex flex-col justify-between">
            <div class="space-y-3">
                <div class="w-full h-40 bg-gray-100 rounded-xl flex items-center justify-center text-gray-400">
                    <i data-lucide="book" class="w-10 h-10 text-[#173F35]/40"></i>
                </div>
                <div>
                    <h3 class="font-bold text-[#173F35] text-base truncate">Bumi Manusia</h3>
                    <p class="text-xs text-gray-500 truncate">Pramoedya A. Toer</p>
                </div>
                <div class="flex items-center justify-between text-xs pt-1">
                    <span class="px-2.5 py-0.5 rounded-md bg-[#F4E8CD] text-[#173F35] font-semibold text-[11px]">Sastra</span>
                    <span class="text-gray-500 font-medium">3 Tersedia</span>
                </div>
            </div>
            <button type="button" onclick="openBookDrawer({
                title: 'Bumi Manusia',
                author: 'Pramoedya A. Toer',
                category: 'Sastra',
                stock: 'Tersedia 3 Buku',
                isbn: '978-979-9731',
                publisher: 'Lentera Dipantara',
                year: '1980',
                shelf: 'Rak Sastra-02',
                synopsis: 'Kisah Minke, seorang pribumi cerdas di masa kolonial Belanda, dan perjuangannya menghadapi diskriminasi sosial serta cintanya pada Annelies Mellema.'
            })" class="w-full mt-4 py-2 border border-[#173F35] text-[#173F35] hover:bg-[#173F35] hover:text-white rounded-xl text-xs font-semibold transition cursor-pointer">
                Selengkapnya
            </button>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-gray-200/60 shadow-xs flex flex-col justify-between">
            <div class="space-y-3">
                <div class="w-full h-40 bg-gray-100 rounded-xl flex items-center justify-center text-gray-400">
                    <i data-lucide="book" class="w-10 h-10 text-[#173F35]/40"></i>
                </div>
                <div>
                    <h3 class="font-bold text-[#173F35] text-base truncate">Filosofi Teras</h3>
                    <p class="text-xs text-gray-500 truncate">Henry Manampiring</p>
                </div>
                <div class="flex items-center justify-between text-xs pt-1">
                    <span class="px-2.5 py-0.5 rounded-md bg-[#F4E8CD] text-[#173F35] font-semibold text-[11px]">Filsafat</span>
                    <span class="text-gray-500 font-medium">12 Tersedia</span>
                </div>
            </div>
            <button type="button" onclick="openBookDrawer({
                title: 'Filosofi Teras',
                author: 'Henry Manampiring',
                category: 'Filsafat',
                stock: 'Tersedia 12 Buku',
                isbn: '978-602-4123',
                publisher: 'Buku Kompas',
                year: '2019',
                shelf: 'Rak Filsafat-01',
                synopsis: 'Penerapan filsafat Stoisisme kuno untuk mengatasi emosi negatif, kekhawatiran berlebihan, dan menemukan kedamaian mental dalam kehidupan modern.'
            })" class="w-full mt-4 py-2 border border-[#173F35] text-[#173F35] hover:bg-[#173F35] hover:text-white rounded-xl text-xs font-semibold transition cursor-pointer">
                Selengkapnya
            </button>
        </div>
    </div>
</div>

<div id="drawerBackdrop" class="fixed inset-0 bg-black/40 z-40 hidden transition-opacity" onclick="closeBookDrawer()"></div>

<div id="bookDrawer" class="fixed top-0 right-0 h-full w-full max-w-md bg-white z-50 shadow-2xl flex flex-col justify-between translate-x-full transition-transform duration-300 ease-in-out">
    <div class="p-6 border-b border-gray-100 flex items-center justify-between">
        <h3 class="text-lg font-bold text-[#173F35]">Detail Lengkap Buku</h3>
        <button type="button" onclick="closeBookDrawer()" class="text-gray-400 hover:text-gray-700 p-1 rounded-lg cursor-pointer transition">
            <i data-lucide="x" class="w-5 h-5"></i>
        </button>
    </div>

    <div class="p-6 overflow-y-auto space-y-6">
        <div class="w-full h-44 bg-[#173F35] rounded-2xl flex items-center justify-center text-[#F4E8CD]">
            <i data-lucide="book-open" class="w-16 h-16"></i>
        </div>

        <div>
            <h2 id="drawerTitle" class="text-2xl font-bold text-[#173F35]">Laskar Pelangi</h2>
            <p id="drawerAuthor" class="text-sm text-gray-500 mt-0.5">Andrea Hirata</p>
        </div>

        <div class="flex items-center gap-2">
            <span id="drawerCategory" class="px-3 py-1 rounded-full text-xs font-semibold bg-[#F4E8CD] text-[#173F35]">Novel</span>
            <span id="drawerStock" class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">Tersedia 5 Buku</span>
        </div>

        <div class="grid grid-cols-2 gap-4 pt-2 border-t border-gray-100">
            <div>
                <span class="text-xs text-gray-400 block font-medium">ISBN</span>
                <span id="drawerIsbn" class="text-sm font-bold text-gray-800">978-602-1234</span>
            </div>
            <div>
                <span class="text-xs text-gray-400 block font-medium">Penerbit</span>
                <span id="drawerPublisher" class="text-sm font-bold text-gray-800">Bentang Pustaka</span>
            </div>
            <div>
                <span class="text-xs text-gray-400 block font-medium">Tahun Terbit</span>
                <span id="drawerYear" class="text-sm font-bold text-gray-800">2005</span>
            </div>
            <div>
                <span class="text-xs text-gray-400 block font-medium">Lokasi Rak</span>
                <span id="drawerShelf" class="text-sm font-bold text-gray-800">Rak Sastra-01</span>
            </div>
        </div>

        <div class="pt-2 border-t border-gray-100">
            <span class="text-xs font-semibold text-gray-700 block mb-1.5">Sinopsis</span>
            <p id="drawerSynopsis" class="text-xs text-gray-600 leading-relaxed"></p>
        </div>
    </div>

    <div class="p-6 border-t border-gray-100 flex items-center gap-3 bg-white">
        <button type="button" class="flex-1 py-2.5 px-4 border border-gray-200 text-gray-700 hover:bg-gray-50 rounded-xl text-xs font-semibold transition cursor-pointer">
            Edit Data
        </button>
        <button type="button" class="flex-1 py-2.5 px-4 bg-[#173F35] text-white hover:bg-[#173F35]/90 rounded-xl text-xs font-semibold transition cursor-pointer">
            Lihat Peminjaman
        </button>
    </div>
</div>

<script>
    function openBookDrawer(data) {
        document.getElementById('drawerTitle').innerText = data.title;
        document.getElementById('drawerAuthor').innerText = data.author;
        document.getElementById('drawerCategory').innerText = data.category;
        document.getElementById('drawerStock').innerText = data.stock;
        document.getElementById('drawerIsbn').innerText = data.isbn;
        document.getElementById('drawerPublisher').innerText = data.publisher;
        document.getElementById('drawerYear').innerText = data.year;
        document.getElementById('drawerShelf').innerText = data.shelf;
        document.getElementById('drawerSynopsis').innerText = data.synopsis;

        const drawer = document.getElementById('bookDrawer');
        const backdrop = document.getElementById('drawerBackdrop');

        backdrop.classList.remove('hidden');
        setTimeout(() => {
            drawer.classList.remove('translate-x-full');
        }, 10);
    }

    function closeBookDrawer() {
        const drawer = document.getElementById('bookDrawer');
        const backdrop = document.getElementById('drawerBackdrop');

        drawer.classList.add('translate-x-full');
        setTimeout(() => {
            backdrop.classList.add('hidden');
        }, 300);
    }
</script>
@endsection