@extends('layouts.admin')

@section('title', 'Kelola Data Buku')
@section('header_title', 'Kelola Data Buku')
@section('header_subtitle', 'Manajemen data-data buku perpustakaan')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4">
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
            <div class="relative flex items-center">
                <i data-lucide="search" class="w-4 h-4 text-gray-400 absolute left-3.5 pointer-events-none"></i>
                <input
                    type="text"
                    id="searchBuku"
                    placeholder="Cari buku..."
                    class="pl-10 pr-4 py-2 bg-white border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#173F35] w-full sm:w-64"
                >
            </div>

            <select id="filterKategori" class="px-3.5 py-2 bg-white border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#173F35] text-gray-700 cursor-pointer">
                <option value="">Semua Kategori</option>
                @foreach ($kategori as $kat)
                    <option value="{{ $kat->nama_kategori }}">{{ $kat->nama_kategori }}</option>
                @endforeach
            </select>
        </div>

        <button
            type="button"
            onclick="openModalTambahBuku()"
            class="px-4 py-2 bg-[#173F35] text-white rounded-xl text-sm font-semibold hover:bg-[#173F35]/90 transition cursor-pointer flex items-center justify-center gap-2 shrink-0"
        >
            <i data-lucide="plus" class="w-4 h-4"></i>
            <span>Tambah Buku</span>
        </button>
    </div>

    <div id="bookGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        @forelse ($buku as $item)
        @php
            $catName = $item->category->nama_kategori ?? 'Umum';
            $stockText = $item->stok > 0 ? "Tersedia {$item->stok} Buku" : "Stok Habis";
        @endphp
        <div
            class="book-card bg-white p-4 rounded-2xl border border-gray-200/60 shadow-xs flex flex-col justify-between"
            data-judul="{{ strtolower($item->judul) }}"
            data-penulis="{{ strtolower($item->penulis) }}"
            data-kategori="{{ strtolower($catName) }}"
        >
            <div class="space-y-3">
                @if ($item->gambar)
                    <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}" class="w-full h-40 object-cover rounded-xl">
                @else
                    <div class="w-full h-40 bg-gray-100 rounded-xl flex items-center justify-center text-gray-400">
                        <i data-lucide="book" class="w-10 h-10 text-[#173F35]/40"></i>
                    </div>
                @endif
                <div>
                    <h3 class="font-bold text-[#173F35] text-base truncate">{{ $item->judul }}</h3>
                    <p class="text-xs text-gray-500 truncate">{{ $item->penulis }}</p>
                </div>
                <div class="flex items-center justify-between text-xs pt-1">
                    <span class="px-2.5 py-0.5 rounded-md bg-[#F4E8CD] text-[#173F35] font-semibold text-[11px]">{{ $catName }}</span>
                    @if ($item->stok > 0)
                        <span class="text-gray-500 font-medium">{{ $item->stok }} Tersedia</span>
                    @else
                        <span class="text-red-600 font-semibold">Stok Habis</span>
                    @endif
                </div>
            </div>
            <button
                type="button"
                onclick='openBookDrawer({
                    id: @json($item->id),
                    title: @json($item->judul),
                    author: @json($item->penulis),
                    publisher: @json($item->penerbit ?? "-"),
                    year: @json($item->tahun_terbit ?? "-"),
                    categoryId: @json($item->id_kategori),
                    category: @json($catName),
                    stock: @json($stockText),
                    stockRaw: @json($item->stok),
                    isAvailable: @json($item->stok > 0),
                    isbn: @json($item->isbn ?? "-"),
                    description: @json($item->deskripsi ?? ""),
                    image: @json($item->gambar ? asset('storage/' . $item->gambar) : null)
                })'
                class="w-full mt-4 py-2 border border-[#173F35] text-[#173F35] hover:bg-[#173F35] hover:text-white rounded-xl text-xs font-semibold transition cursor-pointer"
            >
                Selengkapnya
            </button>
        </div>
        @empty
        <div class="col-span-full bg-white p-12 rounded-2xl border border-gray-200/60 text-center">
            <div class="flex flex-col items-center gap-2 text-gray-400">
                <i data-lucide="inbox" class="w-10 h-10 text-gray-300"></i>
                <span class="text-sm font-medium">Belum ada koleksi buku</span>
            </div>
        </div>
        @endforelse
    </div>
</div>

<div id="drawerBackdrop" class="fixed inset-0 bg-black/40 z-40 hidden transition-opacity" onclick="closeBookDrawer()"></div>

<div id="bookDrawer" class="fixed top-0 right-0 h-full w-full max-w-md bg-white z-50 shadow-2xl flex flex-col justify-between translate-x-full transition-transform duration-300 ease-in-out">
    <div class="p-6 border-b border-gray-100 flex items-center justify-between shrink-0">
        <h3 class="text-lg font-bold text-[#173F35]">Detail Lengkap Buku</h3>
        <button type="button" onclick="closeBookDrawer()" class="text-gray-400 hover:text-gray-700 p-1 rounded-lg cursor-pointer transition">
            <i data-lucide="x" class="w-5 h-5"></i>
        </button>
    </div>

    <div class="p-6 overflow-y-auto space-y-6 flex-1">
        <div class="w-full h-52 rounded-2xl overflow-hidden bg-gray-100 flex items-center justify-center border border-gray-100">
            <img id="drawerImage" src="" alt="Cover Buku" class="w-full h-full object-cover hidden">
            <div id="drawerIconPlaceholder" class="w-full h-full bg-[#173F35] flex items-center justify-center text-[#F4E8CD]">
                <i data-lucide="book-open" class="w-16 h-16"></i>
            </div>
        </div>

        <div>
            <h2 id="drawerTitle" class="text-2xl font-bold text-[#173F35]"></h2>
            <p id="drawerAuthor" class="text-sm text-gray-500 mt-0.5"></p>
        </div>

        <div class="flex items-center gap-2">
            <span id="drawerCategory" class="px-3 py-1 rounded-full text-xs font-semibold bg-[#F4E8CD] text-[#173F35]"></span>
            <span id="drawerStock" class="px-3 py-1 rounded-full text-xs font-semibold"></span>
        </div>

        <div class="grid grid-cols-2 gap-4 pt-2 border-t border-gray-100">
            <div>
                <span class="text-xs text-gray-400 block font-medium">ISBN</span>
                <span id="drawerIsbn" class="text-sm font-bold text-gray-800"></span>
            </div>
            <div>
                <span class="text-xs text-gray-400 block font-medium">Penerbit</span>
                <span id="drawerPublisher" class="text-sm font-bold text-gray-800"></span>
            </div>
            <div>
                <span class="text-xs text-gray-400 block font-medium">Tahun Terbit</span>
                <span id="drawerYear" class="text-sm font-bold text-gray-800"></span>
            </div>
        </div>

        <div class="pt-2 border-t border-gray-100">
            <span class="text-xs font-semibold text-gray-700 block mb-1.5">Deskripsi</span>
            <p id="drawerDescription" class="text-xs text-gray-600 leading-relaxed"></p>
        </div>
    </div>

    <div class="p-6 border-t border-gray-100 flex items-center gap-3 bg-white shrink-0">
        <button
            type="button"
            onclick="openModalEditBukuFromDrawer()"
            class="flex-1 py-2.5 px-4 border border-gray-200 text-gray-700 hover:bg-gray-50 rounded-xl text-xs font-semibold transition cursor-pointer flex items-center justify-center gap-1.5"
        >
            <i data-lucide="pencil" class="w-4 h-4"></i>
            <span>Edit Buku</span>
        </button>
        <button
            type="button"
            onclick="openModalDeleteBukuFromDrawer()"
            class="flex-1 py-2.5 px-4 bg-red-600 text-white hover:bg-red-700 rounded-xl text-xs font-semibold transition cursor-pointer flex items-center justify-center gap-1.5"
        >
            <i data-lucide="trash-2" class="w-4 h-4"></i>
            <span>Hapus Buku</span>
        </button>
    </div>
</div>

<div id="modalBukuBackdrop" class="fixed inset-0 bg-black/40 z-50 hidden" onclick="closeModalBuku()"></div>

<div id="modalTambahBuku" class="fixed z-50 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-lg bg-white rounded-2xl shadow-2xl hidden p-6 max-h-[90vh] overflow-y-auto">
    <div class="flex items-center justify-between mb-5">
        <h3 class="text-base font-bold text-[#173F35]">Tambah Koleksi Buku</h3>
        <button type="button" onclick="closeModalBuku()" class="text-gray-400 hover:text-gray-700 p-1 rounded-lg cursor-pointer transition">
            <i data-lucide="x" class="w-5 h-5"></i>
        </button>
    </div>
    <form method="POST" action="{{ route('admin.buku.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Judul Buku</label>
                    <input type="text" name="judul" placeholder="Judul buku" class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#173F35]" required>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">ISBN</label>
                    <input type="text" name="isbn" placeholder="978-..." class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#173F35]" required>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Penulis</label>
                    <input type="text" name="penulis" placeholder="Nama penulis" class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#173F35]" required>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Penerbit</label>
                    <input type="text" name="penerbit" placeholder="Nama penerbit" class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#173F35]" required>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Tahun Terbit</label>
                    <input type="text" name="tahun_terbit" placeholder="Contoh: 2024" class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#173F35]" required>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Kategori</label>
                    <select name="id_kategori" class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#173F35]" required>
                        <option value="">Pilih Kategori</option>
                        @foreach ($kategori as $kat)
                            <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Stok Buku</label>
                    <input type="number" name="stok" min="0" placeholder="0" class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#173F35]" required>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Sampul Buku (Opsional)</label>
                <input type="file" name="gambar" accept="image/*" class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-[#173F35] file:text-white hover:file:bg-[#173F35]/90">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Deskripsi / Sinopsis</label>
                <textarea name="deskripsi" rows="3" placeholder="Sinopsis singkat..." class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#173F35]"></textarea>
            </div>
        </div>

        <div class="flex gap-3 mt-6">
            <button type="button" onclick="closeModalBuku()" class="flex-1 py-2.5 border border-gray-200 text-gray-700 hover:bg-gray-50 rounded-xl text-xs font-semibold transition cursor-pointer">
                Batal
            </button>
            <button type="submit" class="flex-1 py-2.5 bg-[#173F35] text-white hover:bg-[#173F35]/90 rounded-xl text-xs font-semibold transition cursor-pointer">
                Simpan Buku
            </button>
        </div>
    </form>
</div>

<div id="modalEditBuku" class="fixed z-50 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-lg bg-white rounded-2xl shadow-2xl hidden p-6 max-h-[90vh] overflow-y-auto">
    <div class="flex items-center justify-between mb-5">
        <h3 class="text-base font-bold text-[#173F35]">Edit Data Buku</h3>
        <button type="button" onclick="closeModalBuku()" class="text-gray-400 hover:text-gray-700 p-1 rounded-lg cursor-pointer transition">
            <i data-lucide="x" class="w-5 h-5"></i>
        </button>
    </div>
    <form method="POST" action="{{ route('admin.buku.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="text" name="id" id="editBukuId" hidden>
        <div class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Judul Buku</label>
                    <input type="text" id="editBukuJudul" name="judul" class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#173F35]" required>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">ISBN</label>
                    <input type="text" id="editBukuIsbn" name="isbn" class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#173F35]" required>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Penulis</label>
                    <input type="text" id="editBukuPenulis" name="penulis" class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#173F35]" required>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Penerbit</label>
                    <input type="text" id="editBukuPenerbit" name="penerbit" class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#173F35]" required>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Tahun Terbit</label>
                    <input type="text" id="editBukuTahun" name="tahun_terbit" class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#173F35]" required>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Kategori</label>
                    <select id="editBukuKategori" name="id_kategori" class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#173F35]" required>
                        @foreach ($kategori as $kat)
                            <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Stok Buku</label>
                    <input type="number" id="editBukuStok" name="stok" min="0" class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#173F35]" required>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Ganti Sampul (Opsional)</label>
                <input type="file" name="gambar" accept="image/*" class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-[#173F35] file:text-white hover:file:bg-[#173F35]/90">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Deskripsi / Sinopsis</label>
                <textarea id="editBukuDeskripsi" name="deskripsi" rows="3" class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#173F35]"></textarea>
            </div>
        </div>

        <div class="flex gap-3 mt-6">
            <button type="button" onclick="closeModalBuku()" class="flex-1 py-2.5 border border-gray-200 text-gray-700 hover:bg-gray-50 rounded-xl text-xs font-semibold transition cursor-pointer">
                Batal
            </button>
            <button type="submit" class="flex-1 py-2.5 bg-[#173F35] text-white hover:bg-[#173F35]/90 rounded-xl text-xs font-semibold transition cursor-pointer">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<div id="modalHapusBuku" class="fixed z-50 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-sm bg-white rounded-2xl shadow-2xl hidden p-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-base font-bold text-[#173F35]">Hapus Buku</h3>
        <button type="button" onclick="closeModalBuku()" class="text-gray-400 hover:text-gray-700 p-1 rounded-lg cursor-pointer transition">
            <i data-lucide="x" class="w-5 h-5"></i>
        </button>
    </div>
    <form method="POST" action="{{ route('admin.buku.destroy') }}">
        @csrf
        @method('DELETE')
        <input type="text" name="id" id="hapusBukuId" hidden>
        <p class="text-xs text-gray-600 leading-relaxed mb-6">
            Apakah Anda yakin ingin menghapus buku <strong id="hapusBukuJudul" class="text-red-600 font-bold"></strong>? Tindakan ini tidak dapat dibatalkan.
        </p>
        <div class="flex gap-3">
            <button type="button" onclick="closeModalBuku()" class="flex-1 py-2.5 border border-gray-200 text-gray-700 hover:bg-gray-50 rounded-xl text-xs font-semibold transition cursor-pointer">
                Batal
            </button>
            <button type="submit" class="flex-1 py-2.5 bg-red-600 text-white hover:bg-red-700 rounded-xl text-xs font-semibold transition cursor-pointer">
                Ya, Hapus
            </button>
        </div>
    </form>
</div>

<script>
    let currentDrawerBook = null;

    function openBookDrawer(data) {
        currentDrawerBook = data;

        document.getElementById('drawerTitle').innerText = data.title;
        document.getElementById('drawerAuthor').innerText = data.author;
        document.getElementById('drawerCategory').innerText = data.category;

        const stockEl = document.getElementById('drawerStock');
        stockEl.innerText = data.stock;
        if (data.isAvailable) {
            stockEl.className = 'px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100';
        } else {
            stockEl.className = 'px-3 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-600 border border-red-100';
        }

        document.getElementById('drawerIsbn').innerText = data.isbn;
        document.getElementById('drawerPublisher').innerText = data.publisher;
        document.getElementById('drawerYear').innerText = data.year;
        document.getElementById('drawerDescription').innerText = data.description;

        const drawerImg = document.getElementById('drawerImage');
        const drawerPlaceholder = document.getElementById('drawerIconPlaceholder');
        if (data.image) {
            drawerImg.src = data.image;
            drawerImg.classList.remove('hidden');
            drawerPlaceholder.classList.add('hidden');
        } else {
            drawerImg.src = '';
            drawerImg.classList.add('hidden');
            drawerPlaceholder.classList.remove('hidden');
        }

        const drawer = document.getElementById('bookDrawer');
        const backdrop = document.getElementById('drawerBackdrop');

        backdrop.classList.remove('hidden');
        setTimeout(() => {
            drawer.classList.remove('translate-x-full');
        }, 10);

        if (window.lucide) {
            window.lucide.createIcons();
        }
    }

    function closeBookDrawer() {
        const drawer = document.getElementById('bookDrawer');
        const backdrop = document.getElementById('drawerBackdrop');

        drawer.classList.add('translate-x-full');
        setTimeout(() => {
            backdrop.classList.add('hidden');
        }, 300);
    }

    function openModalTambahBuku() {
        document.getElementById('modalBukuBackdrop').classList.remove('hidden');
        document.getElementById('modalTambahBuku').classList.remove('hidden');
    }

    function openModalEditBukuFromDrawer() {
        if (!currentDrawerBook) return;
        closeBookDrawer();

        document.getElementById('editBukuId').value = currentDrawerBook.id;
        document.getElementById('editBukuJudul').value = currentDrawerBook.title;
        document.getElementById('editBukuIsbn').value = currentDrawerBook.isbn === '-' ? '' : currentDrawerBook.isbn;
        document.getElementById('editBukuPenulis').value = currentDrawerBook.author;
        document.getElementById('editBukuPenerbit').value = currentDrawerBook.publisher === '-' ? '' : currentDrawerBook.publisher;
        document.getElementById('editBukuTahun').value = currentDrawerBook.year === '-' ? '' : currentDrawerBook.year;
        document.getElementById('editBukuKategori').value = currentDrawerBook.categoryId;
        document.getElementById('editBukuStok').value = currentDrawerBook.stockRaw;
        document.getElementById('editBukuDeskripsi').value = currentDrawerBook.description;

        document.getElementById('modalBukuBackdrop').classList.remove('hidden');
        document.getElementById('modalEditBuku').classList.remove('hidden');
    }

    function openModalDeleteBukuFromDrawer() {
        if (!currentDrawerBook) return;
        closeBookDrawer();

        document.getElementById('hapusBukuId').value = currentDrawerBook.id;
        document.getElementById('hapusBukuJudul').innerText = currentDrawerBook.title;

        document.getElementById('modalBukuBackdrop').classList.remove('hidden');
        document.getElementById('modalHapusBuku').classList.remove('hidden');
    }

    function closeModalBuku() {
        document.getElementById('modalBukuBackdrop').classList.add('hidden');
        document.getElementById('modalTambahBuku').classList.add('hidden');
        document.getElementById('modalEditBuku').classList.add('hidden');
        document.getElementById('modalHapusBuku').classList.add('hidden');
    }

    document.getElementById('searchBuku').addEventListener('input', filterBooks);
    document.getElementById('filterKategori').addEventListener('change', filterBooks);

    function filterBooks() {
        const q = document.getElementById('searchBuku').value.toLowerCase();
        const cat = document.getElementById('filterKategori').value.toLowerCase();

        document.querySelectorAll('.book-card').forEach(card => {
            const judul = card.getAttribute('data-judul') || '';
            const penulis = card.getAttribute('data-penulis') || '';
            const kategori = card.getAttribute('data-kategori') || '';

            const matchSearch = judul.includes(q) || penulis.includes(q);
            const matchCat = !cat || kategori === cat;

            card.style.display = (matchSearch && matchCat) ? '' : 'none';
        });
    }
</script>
@endsection