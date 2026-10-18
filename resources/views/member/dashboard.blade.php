<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Member - SiPena</title>
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

        $books = $books ?? collect();
        $categories = $categories ?? collect();
        $borrowings = $borrowings ?? collect();

        $activeBorrowings = $borrowings->filter(function ($borrowing) {
            return in_array(strtolower($borrowing->status ?? ''), ['dipinjam', 'terlambat']);
        });

        $nearestDue = $activeBorrowings
            ->filter(fn ($borrowing) => $borrowing->jatuh_tempo)
            ->sortBy('jatuh_tempo')
            ->first();

        $selectedCategory = request('kategori');
        $selectedStock = request('stok', 'semua');
    @endphp

    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-gray-200/70 px-6 sm:px-10 py-4 flex items-center justify-between gap-4 transition-all shadow-2xs">
        <a href="{{ route('member.dashboard') }}" class="flex items-center gap-3 text-2xl font-bold text-forest tracking-tight no-underline shrink-0">
            <x-logo size="w-5 h-5" />
            <span>SiPena</span>
        </a>

        <nav class="flex items-center gap-2">
            <a href="{{ route('member.dashboard') }}" class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all bg-forest text-cream shadow-xs">
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

    <div class="max-w-6xl w-full mx-auto px-4 sm:px-6 pt-6">
        <section class="relative overflow-hidden rounded-2xl bg-forest p-8 sm:p-10 text-cream shadow-sm">
            <div class="relative z-10 max-w-lg">
                <p class="text-xs sm:text-sm font-medium text-[#A8BEB5] mb-2">
                    Halo, {{ $member->nama ?? 'Member' }} 👋
                </p>
                <h1 class="text-2xl sm:text-4xl font-extrabold text-white leading-tight mb-3">
                    Jelajahi Ilmu, Bangun Masa Depan.
                </h1>
                <p class="text-xs sm:text-sm text-[#A8BEB5]">
                    Sedang dipinjam <strong class="text-cream font-bold">{{ $activeBorrowings->count() }} buku</strong>
                    @if ($nearestDue)
                        <span> · Tenggat terdekat </span>
                        <strong class="text-cream font-bold">
                            {{ \Carbon\Carbon::parse($nearestDue->jatuh_tempo)->locale('id')->translatedFormat('d M') }}
                        </strong>
                    @endif
                </p>
            </div>

            <div class="absolute bottom-0 right-6 hidden sm:flex items-end gap-2.5 opacity-60" aria-hidden="true">
                <span class="h-16 w-7 rounded-t-md bg-sage"></span>
                <span class="h-28 w-7 rounded-t-md bg-cream"></span>
                <span class="h-20 w-7 rounded-t-md bg-sage"></span>
                <span class="h-36 w-7 rounded-t-md bg-sage"></span>
                <span class="h-24 w-7 rounded-t-md bg-cream"></span>
            </div>
        </section>

        <form action="{{ route('member.dashboard') }}"
              method="GET"
              class="relative z-20 max-w-4xl mx-auto -mt-6 bg-white p-2.5 rounded-2xl border border-gray-200/80 shadow-md flex flex-col sm:flex-row items-stretch sm:items-center gap-2">

            <input
                class="flex-1 min-w-0 px-4 py-2 text-xs sm:text-sm text-gray-800 bg-transparent outline-none placeholder:text-gray-400"
                type="search"
                name="q"
                value="{{ request('q') }}"
                placeholder="Cari judul buku atau nama penulis..."
                aria-label="Cari judul atau penulis buku"
            >

            <select class="px-3.5 py-2 text-xs sm:text-sm border-t sm:border-t-0 sm:border-l border-gray-200 bg-white text-gray-700 outline-none cursor-pointer rounded-lg"
                    name="kategori"
                    aria-label="Filter kategori">
                <option value="">Semua kategori</option>
                @foreach ($categories as $category)
                    <option
                        value="{{ $category->id }}"
                        @selected((string) $selectedCategory === (string) $category->id)
                    >
                        {{ $category->nama_kategori }}
                    </option>
                @endforeach
            </select>

            <select class="px-3.5 py-2 text-xs sm:text-sm border-t sm:border-t-0 sm:border-l border-gray-200 bg-white text-gray-700 outline-none cursor-pointer rounded-lg"
                    name="stok"
                    aria-label="Filter stok">
                <option value="semua" @selected($selectedStock === 'semua')>Semua stok</option>
                <option value="tersedia" @selected($selectedStock === 'tersedia')>Tersedia</option>
                <option value="habis" @selected($selectedStock === 'habis')>Stok habis</option>
            </select>

            <button type="submit" class="px-6 py-2.5 bg-forest text-cream font-bold text-xs sm:text-sm rounded-xl hover:bg-sage transition-all shrink-0 cursor-pointer">
                Cari Buku
            </button>
        </form>
    </div>

    <main class="max-w-6xl w-full mx-auto px-4 sm:px-6 py-8 flex-1 space-y-8">
        <section>
            <h2 class="text-lg font-bold text-forest mb-4 flex items-center gap-2">
                <span>⏱</span>
                <span>Sedang Kamu Pinjam</span>
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @forelse ($activeBorrowings as $borrowing)
                    @php
                        $statusText = strtolower($borrowing->status ?? '');
                        $isOverdue = $statusText === 'terlambat' || ($borrowing->jatuh_tempo
                            && \Carbon\Carbon::parse($borrowing->jatuh_tempo)->lt(now()->startOfDay()));
                    @endphp

                    <article class="bg-white border border-gray-200/70 rounded-2xl p-4 sm:p-5 flex items-center justify-between gap-3 shadow-2xs hover:border-forest/30 transition-all">
                        <div class="min-w-0">
                            <h3 class="text-sm font-bold text-forest truncate mb-1">
                                {{ $borrowing->book->judul ?? 'Buku tidak tersedia' }}
                            </h3>
                            <p class="text-xs text-muted">
                                Tenggat:
                                @if ($borrowing->jatuh_tempo)
                                    <strong class="text-gray-700 font-semibold">
                                        {{ \Carbon\Carbon::parse($borrowing->jatuh_tempo)->locale('id')->translatedFormat('d M Y') }}
                                    </strong>
                                @else
                                    Belum ditentukan
                                @endif
                            </p>
                        </div>

                        <span class="px-3 py-1 rounded-full text-xs font-semibold whitespace-nowrap {{ $isOverdue ? 'bg-red-50 text-red-600 border border-red-100' : 'bg-emerald-50 text-emerald-700 border border-emerald-100' }}">
                            {{ $isOverdue ? 'Terlambat' : 'Dipinjam' }}
                        </span>
                    </article>
                @empty
                    <div class="col-span-full rounded-2xl border border-gray-200/70 bg-white p-8 text-center text-xs text-muted shadow-2xs">
                        <p>Kamu belum memiliki buku yang sedang dipinjam.</p>
                    </div>
                @endforelse
            </div>
        </section>

        <section class="grid grid-cols-1 lg:grid-cols-4 gap-6 items-start">
            <div class="lg:col-span-3">
                <h2 class="text-lg font-bold text-forest mb-4">Eksplorasi Buku</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
                    @forelse ($books as $book)
                        <article class="bg-white border border-gray-200/70 rounded-2xl p-4 flex flex-col justify-between shadow-2xs hover:border-forest/30 transition-all">
                            <div class="space-y-3">
                                <div class="w-full aspect-[4/3] rounded-xl bg-forest overflow-hidden flex items-center justify-center text-cream">
                                    @if ($book->gambar)
                                        <img class="h-full w-full object-cover"
                                            src="{{ asset('storage/' . $book->gambar) }}"
                                            alt="Sampul {{ $book->judul }}"
                                            loading="lazy"
                                        >
                                    @else
                                        <span class="text-4xl">📖</span>
                                    @endif
                                </div>

                                <div>
                                    <h3 class="text-sm font-bold text-forest leading-snug line-clamp-1">{{ $book->judul }}</h3>
                                    <p class="text-xs text-sage mt-0.5 truncate">{{ $book->penulis }}</p>
                                </div>

                                <div class="flex items-center justify-between text-xs pt-1">
                                    <span class="px-2.5 py-0.5 rounded-md bg-cream text-forest font-semibold text-[11px] truncate max-w-[120px]">
                                        {{ $book->category->nama_kategori ?? 'Umum' }}
                                    </span>

                                    @if (($book->stok ?? 0) > 0)
                                        <span class="text-gray-500 font-medium text-[11px]">
                                            Stok {{ $book->stok }}
                                        </span>
                                    @else
                                        <span class="text-red-600 font-semibold text-[11px]">
                                            Stok habis
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <a
                                href="{{ route('member.buku.show', $book->id) }}"
                                class="mt-4 w-full py-2 border border-forest text-forest hover:bg-forest hover:text-white rounded-xl text-xs font-semibold transition-all text-center block"
                            >
                                Selengkapnya
                            </a>
                        </article>
                    @empty
                        <div class="col-span-full rounded-2xl border border-gray-200/70 bg-white p-12 text-center text-xs text-muted shadow-2xs">
                            <p>Belum ada buku yang tersedia atau tidak ada buku yang cocok dengan pencarianmu.</p>
                        </div>
                    @endforelse
                </div>

                @if (method_exists($books, 'links'))
                    <div class="mt-6">
                        {{ $books->links() }}
                    </div>
                @endif
            </div>

            <aside class="lg:col-span-1 bg-white border border-gray-200/70 rounded-2xl p-5 shadow-2xs">
                <h2 class="text-sm font-bold text-forest uppercase tracking-wider mb-3">Kategori</h2>

                <div class="flex flex-col gap-1">
                    <a
                        href="{{ route('member.dashboard') }}"
                        class="px-3.5 py-2 rounded-xl text-xs font-medium transition-all {{ !$selectedCategory ? 'bg-forest text-cream font-bold shadow-xs' : 'text-gray-600 hover:bg-cream/40' }}"
                    >
                        Semua Kategori
                    </a>

                    @foreach ($categories as $category)
                        <a
                            href="{{ route('member.dashboard', array_merge(request()->except('kategori', 'page'), ['kategori' => $category->id])) }}"
                            class="px-3.5 py-2 rounded-xl text-xs font-medium transition-all {{ (string) $selectedCategory === (string) $category->id ? 'bg-forest text-cream font-bold shadow-xs' : 'text-gray-600 hover:bg-cream/40' }}"
                        >
                            {{ $category->nama_kategori }}
                        </a>
                    @endforeach
                </div>
            </aside>
        </section>
    </main>

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