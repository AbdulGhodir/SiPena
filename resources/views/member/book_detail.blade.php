<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Buku - SiPena</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = { theme: { extend: {
        colors: { forest:'#173F35', sage:'#52796F', cream:'#F4E8CD',
          background:'#FAF9F4', text:'#193F37', muted:'#81908B',
          line:'#EDEDE7', danger:'#D94B4B' },
        fontFamily: { sans:['Poppins','sans-serif'] }
      }}};
    </script>
</head>

<body class="min-h-screen bg-background font-sans text-text flex flex-col justify-between">

    @php
        $member = auth()->user();
    @endphp

    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-gray-200/70 px-6 sm:px-10 py-4 flex items-center justify-between gap-4 transition-all shadow-2xs">
        <a href="{{ route('member.dashboard') }}" class="flex items-center gap-3 text-2xl font-bold text-forest tracking-tight no-underline shrink-0">
            <x-logo size="w-5 h-5" />
            <span>SiPena</span>
        </a>

        <nav class="flex items-center gap-2">
            <a href="{{ route('member.dashboard') }}" class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all text-gray-600 hover:text-forest hover:bg-cream/50">
                Beranda
            </a>
            <a href="{{ route('member.riwayat') }}" class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all text-gray-600 hover:text-forest hover:bg-cream/50">
                Riwayat
            </a>
        </nav>

        <div class="relative group">
            <button type="button" class="flex items-center gap-2.5 cursor-pointer py-1 focus:outline-none">
                <div class="w-9 h-9 rounded-full bg-forest text-cream font-bold flex items-center justify-center text-xs shadow-xs ring-2 ring-sage/20">
                    {{ strtoupper(substr($member->nama ?? 'M', 0, 2)) }}
                </div>
                <div class="hidden sm:flex flex-col text-left">
                    <span class="text-xs font-semibold text-forest leading-tight">{{ $member->nama ?? 'Member' }}</span>
                    <span class="text-[10px] text-sage font-medium">Anggota</span>
                </div>
                <i data-lucide="chevron-down" class="w-3.5 h-3.5 text-gray-400 group-hover:text-forest transition-colors"></i>
            </button>

            <div class="absolute right-0 top-full pt-2 w-44 hidden group-hover:block z-50">
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 py-1.5 overflow-hidden">
                    <a href="{{ route('member.profile.index') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs font-semibold text-gray-700 hover:bg-cream/40 hover:text-forest transition-colors">
                        <i data-lucide="user" class="w-4 h-4 text-sage"></i>
                        <span>Profil Saya</span>
                    </a>
                    <div class="my-1 border-t border-gray-100"></div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-2.5 px-4 py-2 text-xs font-semibold text-red-600 hover:bg-red-50 transition-colors cursor-pointer text-left">
                            <i data-lucide="log-out" class="w-4 h-4 text-red-500"></i>
                            <span>Keluar</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-4xl w-full mx-auto px-4 sm:px-6 py-8 flex-1">
        <a href="{{ route('member.dashboard') }}" class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-semibold text-sage hover:text-forest transition-colors mb-6">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Kembali ke Beranda</span>
        </a>

        <div class="bg-white rounded-2xl border border-gray-200/70 p-6 sm:p-10 shadow-xs">
            <div class="flex flex-col md:flex-row gap-8 md:gap-12 items-start">
                <div class="w-full md:w-64 shrink-0">
                    <div class="w-full aspect-[3/4] rounded-2xl bg-[#173F35] overflow-hidden shadow-sm flex items-center justify-center border border-gray-100">
                        @if ($book->gambar)
                            <img src="{{ asset('storage/' . $book->gambar) }}" alt="{{ $book->judul }}" class="w-full h-full object-cover">
                        @else
                            <div class="text-cream text-5xl">📖</div>
                        @endif
                    </div>
                </div>

                <div class="flex-1 space-y-6">
                    <div>
                        <div class="flex flex-wrap items-center gap-2 mb-2">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-[#F4E8CD] text-forest">
                                {{ $book->category->nama_kategori ?? 'Umum' }}
                            </span>
                            @if($book->stok > 0)
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                    Tersedia ({{ $book->stok }} Buku)
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-600 border border-red-100">
                                    Stok Habis
                                </span>
                            @endif
                        </div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-forest leading-snug">{{ $book->judul }}</h1>
                        <p class="text-sm text-sage mt-1">Ditulis oleh <strong class="text-gray-800">{{ $book->penulis }}</strong></p>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 py-4 border-y border-gray-100 text-xs">
                        <div>
                            <span class="text-gray-400 block font-medium">ISBN</span>
                            <span class="font-bold text-gray-800 text-sm mt-0.5 block">{{ $book->isbn ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="text-gray-400 block font-medium">Penerbit</span>
                            <span class="font-bold text-gray-800 text-sm mt-0.5 block">{{ $book->penerbit ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="text-gray-400 block font-medium">Tahun Terbit</span>
                            <span class="font-bold text-gray-800 text-sm mt-0.5 block">{{ $book->tahun_terbit ?? '-' }}</span>
                        </div>
                    </div>

                    <div>
                        <h2 class="text-xs font-bold text-forest uppercase tracking-wider mb-2">Sinopsis / Deskripsi</h2>
                        <div class="bg-[#FCFAF5] rounded-xl p-4 text-xs sm:text-sm text-gray-600 leading-relaxed border border-gray-100">
                            {{ $book->deskripsi ?: 'Tidak ada sinopsis untuk koleksi buku ini.' }}
                        </div>
                    </div>

                    <div class="pt-2">
                        @if(!empty($alreadyBorrowed))
                            <button type="button" disabled class="w-full sm:w-auto px-8 py-3 bg-[#FCFAF5] text-sage border border-gray-200 font-bold text-xs sm:text-sm rounded-xl cursor-not-allowed flex items-center justify-center gap-2">
                                <i data-lucide="bookmark-check" class="w-4 h-4 text-sage"></i>
                                <span>Sedang Kamu Pinjam</span>
                            </button>
                        @elseif($book->stok > 0)
                            <button type="button" onclick="openConfirmModal()" class="w-full sm:w-auto px-8 py-3 bg-forest text-cream font-bold text-xs sm:text-sm rounded-xl hover:bg-sage transition-all shadow-sm flex items-center justify-center gap-2 cursor-pointer">
                                <i data-lucide="book-plus" class="w-4 h-4"></i>
                                <span>Pinjam Buku</span>
                            </button>
                        @else
                            <button type="button" disabled class="w-full sm:w-auto px-8 py-3 bg-gray-100 text-gray-400 font-bold text-xs sm:text-sm rounded-xl cursor-not-allowed">
                                Stok Buku Sedang Habis
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div id="modalConfirmBackdrop" class="fixed inset-0 bg-black/40 z-50 hidden" onclick="closeConfirmModal()"></div>

    <div id="modalConfirmPinjam" class="fixed z-50 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-sm bg-white rounded-2xl shadow-2xl hidden p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-base font-bold text-forest">Konfirmasi Peminjaman</h3>
            <button type="button" onclick="closeConfirmModal()" class="text-gray-400 hover:text-gray-700 p-1 rounded-lg cursor-pointer">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        <form method="POST" action="{{ route('member.buku.borrow', $book->id) }}">
            @csrf
            <p class="text-xs text-gray-600 leading-relaxed mb-6">
                Apakah kamu ingin meminjam buku <strong class="text-forest font-bold">{{ $book->judul }}</strong>? Batas waktu peminjaman adalah 7 hari dari sekarang.
            </p>
            <div class="flex gap-3">
                <button type="button" onclick="closeConfirmModal()" class="flex-1 py-2.5 border border-gray-200 text-gray-700 hover:bg-gray-50 rounded-xl text-xs font-semibold transition cursor-pointer">
                    Batal
                </button>
                <button type="submit" class="flex-1 py-2.5 bg-forest text-cream hover:bg-sage rounded-xl text-xs font-semibold transition cursor-pointer">
                    Ya, Pinjam
                </button>
            </div>
        </form>
    </div>

    <div class="fixed bottom-8 right-8 z-50 flex flex-col gap-3 max-w-sm w-full pointer-events-none">
        @if (session('success'))
            <div id="toastNotification" class="pointer-events-auto flex items-center justify-between gap-3 p-4 bg-emerald-600 text-white rounded-2xl shadow-xl transform translate-x-full transition-transform duration-300 ease-out">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-white/20 flex items-center justify-center shrink-0">
                        <i data-lucide="check-circle" class="w-5 h-5 text-white"></i>
                    </div>
                    <span class="text-xs font-semibold leading-relaxed">{{ session('success') }}</span>
                </div>
                <button type="button" onclick="closeToast()" class="text-white/80 hover:text-white cursor-pointer p-1">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>
        @elseif (session('error') || $errors->any())
            <div id="toastNotification" class="pointer-events-auto flex items-center justify-between gap-3 p-4 bg-red-600 text-white rounded-2xl shadow-xl transform translate-x-full transition-transform duration-300 ease-out">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-white/20 flex items-center justify-center shrink-0">
                        <i data-lucide="alert-circle" class="w-5 h-5 text-white"></i>
                    </div>
                    <span class="text-xs font-semibold leading-relaxed">{{ session('error') ?? $errors->first() }}</span>
                </div>
                <button type="button" onclick="closeToast()" class="text-white/80 hover:text-white cursor-pointer p-1">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>
        @endif
    </div>

    <footer class="p-6 text-center text-xs text-muted border-t border-gray-200/50">
        &copy; {{ date('Y') }} SiPena · Sistem Informasi Perpustakaan
    </footer>

    <script>
        function openConfirmModal() {
            document.getElementById('modalConfirmBackdrop').classList.remove('hidden');
            document.getElementById('modalConfirmPinjam').classList.remove('hidden');
        }

        function closeConfirmModal() {
            document.getElementById('modalConfirmBackdrop').classList.add('hidden');
            document.getElementById('modalConfirmPinjam').classList.add('hidden');
        }

        function closeToast() {
            const toast = document.getElementById('toastNotification');
            if (toast) {
                toast.classList.add('translate-x-full');
                setTimeout(() => toast.remove(), 300);
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const toast = document.getElementById('toastNotification');
            if (toast) {
                setTimeout(() => {
                    toast.classList.remove('translate-x-full');
                }, 100);

                setTimeout(() => {
                    closeToast();
                }, 4000);
            }
        });
    </script>

    <x-lucide />
</body>
</html>
