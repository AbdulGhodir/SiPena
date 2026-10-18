@extends('layouts.admin')

@section('title', 'Kategori Buku')
@section('header_title', 'Kategori Buku')
@section('header_subtitle', 'Kelola pengelompokan koleksi buku perpustakaan')

@section('content')
<div class="space-y-6">

    <div class="grid grid-cols-2 sm:grid-cols-4 gap-5">
        <div class="bg-white p-5 rounded-2xl border border-gray-200/60 shadow-xs flex flex-col justify-between">
            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Kategori</span>
            <div class="mt-3 flex items-baseline justify-between">
                <span class="text-3xl font-extrabold text-[#173F35]">{{ $totalKategori ?? '--' }}</span>
                <i data-lucide="tag" class="w-5 h-5 text-gray-300"></i>
            </div>
        </div>
    </div>

    <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4">
        <div class="relative flex items-center">
            <i data-lucide="search" class="w-4 h-4 text-gray-400 absolute left-3.5 pointer-events-none"></i>
            <input
                type="text"
                id="searchKategori"
                placeholder="Cari kategori..."
                class="pl-10 pr-4 py-2 bg-white border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#173F35] w-full sm:w-64"
            >
        </div>

        <button
            type="button"
            onclick="openModal()"
            class="px-4 py-2 bg-[#173F35] text-white rounded-xl text-sm font-semibold hover:bg-[#173F35]/90 transition cursor-pointer flex items-center justify-center gap-2 shrink-0"
        >
            <i data-lucide="plus" class="w-4 h-4"></i>
            <span>Tambah Kategori</span>
        </button>
    </div>

    <div id="kategoriGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
        @forelse ($kategori as $kategori_item)
        <div class="kategori-card bg-white p-5 rounded-2xl border border-gray-200/60 shadow-xs hover:border-[#173F35]/30 hover:shadow-sm transition flex flex-col justify-between gap-4">
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <div class="w-10 h-10 rounded-xl bg-[#FCFAF5] border border-gray-200/60 flex items-center justify-center text-[#173F35]">
                        <i data-lucide="tag" class="w-5 h-5"></i>
                    </div>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-[#F4E8CD] text-[#173F35]">
                        <i data-lucide="book" class="w-3 h-3"></i>
                        {{ $kategori_item->books_count }} Buku
                    </span>
                </div>

                <div>
                    <h3 class="kategori-nama font-bold text-[#173F35] text-base leading-snug truncate">{{ $kategori_item->nama_kategori }}</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Kategori koleksi perpustakaan</p>
                </div>
            </div>

            <div class="pt-3 border-t border-gray-100 flex items-center justify-end gap-2">
                <button
                    type="button"
                    onclick='openEditModal(@json($kategori_item->id), @json($kategori_item->nama_kategori))'
                    class="flex-1 py-2 px-3 rounded-xl text-xs font-semibold text-[#173F35] bg-[#FCFAF5] hover:bg-[#173F35] hover:text-white border border-gray-200/60 transition cursor-pointer flex items-center justify-center gap-1.5"
                >
                    <i data-lucide="pencil" class="w-3.5 h-3.5"></i>
                    <span>Edit</span>
                </button>
                <button
                    type="button"
                    onclick='openDeleteModal(@json($kategori_item->id), @json($kategori_item->nama_kategori))'
                    class="py-2 px-3 rounded-xl text-xs font-semibold text-red-600 bg-red-50 hover:bg-red-600 hover:text-white border border-red-100 transition cursor-pointer flex items-center justify-center gap-1.5"
                >
                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                    <span>Hapus</span>
                </button>
            </div>
        </div>
        @empty
        <div class="col-span-full bg-white p-12 rounded-2xl border border-gray-200/60 text-center">
            <div class="flex flex-col items-center gap-2 text-gray-400">
                <i data-lucide="inbox" class="w-10 h-10 text-gray-300"></i>
                <span class="text-sm font-medium">Belum ada kategori</span>
            </div>
        </div>
        @endforelse
    </div>

</div>

<div id="modalBackdrop" class="fixed inset-0 bg-black/40 z-40 hidden" onclick="closeModal()"></div>

<div id="modalTambah" class="fixed z-50 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-sm bg-white rounded-2xl shadow-2xl hidden p-6">
    <div class="flex items-center justify-between mb-5">
        <h3 class="text-base font-bold text-[#173F35]">Tambah Kategori</h3>
        <button type="button" onclick="closeModal()" class="text-gray-400 hover:text-gray-700 p-1 rounded-lg cursor-pointer transition">
            <i data-lucide="x" class="w-5 h-5"></i>
        </button>
    </div>
    <form method="POST" action="{{ route('admin.kategori.store') }}">
        @csrf
        <div class="mb-4">
            <label class="block text-xs font-semibold text-gray-700 mb-1.5">Nama Kategori</label>
            <input
                type="text"
                name="nama_kategori"
                placeholder="Contoh: Filsafat"
                class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#173F35]"
                required
                autofocus
            >
        </div>
        <div class="flex gap-3 mt-5">
            <button type="button" onclick="closeModal()"
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

<div id="modalEdit" class="fixed z-50 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-sm bg-white rounded-2xl shadow-2xl hidden p-6">
    <div class="flex items-center justify-between mb-5">
        <h3 class="text-base font-bold text-[#173F35]">Edit Kategori</h3>
        <button type="button" onclick="closeModal()" class="text-gray-400 hover:text-gray-700 p-1 rounded-lg cursor-pointer transition">
            <i data-lucide="x" class="w-5 h-5"></i>
        </button>
    </div>
    <form method="POST" id="editForm" action="{{ route('admin.kategori.update') }}">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block text-xs font-semibold text-gray-700 mb-1.5">Nama Kategori</label>
            <input
                type="text"
                id="editNamaKategori"
                name="nama_kategori"
                placeholder="Nama kategori"
                class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#173F35]"
                required
            >
            <input type="text" name="id" id="editKategoriId" hidden>
        </div>
        <div class="flex gap-3 mt-5">
            <button type="button" onclick="closeModal()"
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

<div id="modalHapus" class="fixed z-50 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-sm bg-white rounded-2xl shadow-2xl hidden p-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-base font-bold text-[#173F35]">Hapus Kategori</h3>
        <button type="button" onclick="closeModal()" class="text-gray-400 hover:text-gray-700 p-1 rounded-lg cursor-pointer transition">
            <i data-lucide="x" class="w-5 h-5"></i>
        </button>
    </div>
    <form method="POST" action="{{ route('admin.kategori.destroy') }}">
        @csrf
        @method('DELETE')
        <input type="text" name="id" id="hapusKategoriId" hidden>
        <p class="text-xs text-gray-600 leading-relaxed mb-6">
            Apakah Anda yakin ingin menghapus kategori <strong id="hapusKategoriNama" class="text-red-600 font-bold"></strong>? Tindakan ini tidak dapat dibatalkan.
        </p>
        <div class="flex gap-3">
            <button type="button" onclick="closeModal()"
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
    function openModal() {
        document.getElementById('modalBackdrop').classList.remove('hidden');
        document.getElementById('modalTambah').classList.remove('hidden');
    }

    function openEditModal(id, nama) {
        document.getElementById('editKategoriId').value = id;
        document.getElementById('editNamaKategori').value = nama;
        document.getElementById('modalBackdrop').classList.remove('hidden');
        document.getElementById('modalEdit').classList.remove('hidden');
    }

    function openDeleteModal(id, nama) {
        document.getElementById('hapusKategoriId').value = id;
        document.getElementById('hapusKategoriNama').innerText = nama;
        document.getElementById('modalBackdrop').classList.remove('hidden');
        document.getElementById('modalHapus').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('modalBackdrop').classList.add('hidden');
        document.getElementById('modalTambah').classList.add('hidden');
        document.getElementById('modalEdit').classList.add('hidden');
        document.getElementById('modalHapus').classList.add('hidden');
    }

    document.getElementById('searchKategori').addEventListener('input', function () {
        const q = this.value.toLowerCase();
        document.querySelectorAll('.kategori-card').forEach(function (card) {
            const nama = card.querySelector('.kategori-nama').textContent.toLowerCase();
            card.style.display = nama.includes(q) ? '' : 'none';
        });
    });
</script>
@endsection
