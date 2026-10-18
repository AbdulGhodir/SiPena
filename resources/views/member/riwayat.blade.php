<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Peminjaman - SiPena</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = { theme: { extend: {
        colors: { forest:'#173F35', sage:'#52796F', cream:'#F4E8CD',
          background:'#FAF9F4', text:'#193F37', muted:'#81908B',
          line:'#EDEDE7', danger:'#D94B4B', success:'#4B9E73' },
        fontFamily: { sans:['Poppins','sans-serif'] }
      }}};
    </script>
</head>

<body class="min-h-screen bg-background font-sans text-text flex flex-col justify-between">
    @php
        $member = auth()->user();
        $filterAktif = request('status', 'semua');
        $sekarang = now();

        $totalPinjaman = $peminjaman->count();

        $totalTerlambat = $peminjaman->filter(function ($item) use ($sekarang) {
            return $item->status === 'terlambat' || ($item->status === 'dipinjam'
                && $item->jatuh_tempo
                && \Carbon\Carbon::parse($item->jatuh_tempo)->lt($sekarang->startOfDay()));
        })->count();

        $totalTepatWaktu = $peminjaman->filter(function ($item) use ($sekarang) {
            return $item->status === 'dikembalikan'
                && $item->tanggal_kembali
                && $item->jatuh_tempo
                && \Carbon\Carbon::parse($item->tanggal_kembali)
                    ->lte(\Carbon\Carbon::parse($item->jatuh_tempo));
        })->count();
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
            <a href="{{ route('member.riwayat') }}" class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all bg-forest text-cream shadow-xs">
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

    <main class="max-w-5xl w-full mx-auto px-4 sm:px-6 py-8 flex-1">
        <div class="mb-6">
            <h1 class="text-2xl sm:text-3xl font-bold text-forest">Riwayat Peminjaman</h1>
            <p class="text-xs sm:text-sm text-sage mt-1">Daftar semua sirkulasi buku yang pernah kamu pinjam</p>
        </div>

        <section class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
            <div class="bg-white border border-gray-200/70 rounded-2xl p-5 flex items-center justify-between shadow-2xs">
                <div>
                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider block">Total Pinjaman</span>
                    <strong class="text-2xl font-bold text-forest mt-1 block">{{ $totalPinjaman }}</strong>
                </div>
                <div class="w-10 h-10 rounded-xl bg-[#FCFAF5] border border-gray-200/60 flex items-center justify-center text-lg">📚</div>
            </div>

            <div class="bg-white border border-gray-200/70 rounded-2xl p-5 flex items-center justify-between shadow-2xs">
                <div>
                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider block">Tepat Waktu</span>
                    <strong class="text-2xl font-bold text-emerald-700 mt-1 block">{{ $totalTepatWaktu }}</strong>
                </div>
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center text-lg">✓</div>
            </div>

            <div class="bg-white border border-gray-200/70 rounded-2xl p-5 flex items-center justify-between shadow-2xs border-b-2 border-b-red-500">
                <div>
                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider block">Terlambat</span>
                    <strong class="text-2xl font-bold text-red-600 mt-1 block">{{ $totalTerlambat }}</strong>
                </div>
                <div class="w-10 h-10 rounded-xl bg-red-50 text-red-600 flex items-center justify-center text-lg">!</div>
            </div>
        </section>

        <div class="flex flex-wrap gap-2 mb-6">
            <a href="{{ url('/member/riwayat') }}"
               class="px-4 py-2 rounded-xl text-xs font-semibold transition-all border {{ $filterAktif === 'semua' ? 'bg-forest text-white border-forest shadow-xs' : 'bg-white border-gray-200/70 text-gray-600 hover:bg-cream/40' }}">
                Semua
            </a>

            <a href="{{ url('/member/riwayat') }}?status=dipinjam"
               class="px-4 py-2 rounded-xl text-xs font-semibold transition-all border {{ $filterAktif === 'dipinjam' ? 'bg-forest text-white border-forest shadow-xs' : 'bg-white border-gray-200/70 text-gray-600 hover:bg-cream/40' }}">
                Sedang Dipinjam
            </a>

            <a href="{{ url('/member/riwayat') }}?status=dikembalikan"
               class="px-4 py-2 rounded-xl text-xs font-semibold transition-all border {{ $filterAktif === 'dikembalikan' ? 'bg-forest text-white border-forest shadow-xs' : 'bg-white border-gray-200/70 text-gray-600 hover:bg-cream/40' }}">
                Dikembalikan
            </a>

            <a href="{{ url('/member/riwayat') }}?status=terlambat"
               class="px-4 py-2 rounded-xl text-xs font-semibold transition-all border {{ $filterAktif === 'terlambat' ? 'bg-forest text-white border-forest shadow-xs' : 'bg-white border-gray-200/70 text-gray-600 hover:bg-cream/40' }}">
                Terlambat
            </a>
        </div>

        <section class="space-y-3">
            @forelse ($peminjaman as $item)
                @php
                    $statusAsli = strtolower($item->status ?? '');

                    $terlambat = $statusAsli === 'terlambat' || ($statusAsli === 'dipinjam'
                        && $item->jatuh_tempo
                        && \Carbon\Carbon::parse($item->jatuh_tempo)->lt(now()->startOfDay()));

                    if ($terlambat) {
                        $labelStatus = 'Terlambat';
                        $classBadge = 'bg-red-50 text-red-600 border border-red-100';
                    } elseif ($statusAsli === 'dikembalikan') {
                        $labelStatus = 'Dikembalikan';
                        $classBadge = 'bg-emerald-50 text-emerald-700 border border-emerald-100';
                    } elseif ($statusAsli === 'dipinjam' && $item->jatuh_tempo
                        && \Carbon\Carbon::parse($item->jatuh_tempo)->isToday()) {
                        $labelStatus = 'Jatuh Tempo Hari Ini';
                        $classBadge = 'bg-amber-50 text-amber-700 border border-amber-200';
                    } else {
                        $labelStatus = 'Sedang Dipinjam';
                        $classBadge = 'bg-[#EDF2F0] text-sage border border-sage/20';
                    }
                @endphp

                <article class="bg-white border border-gray-200/70 rounded-2xl p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-2xs hover:border-forest/30 transition-all">
                    <div class="flex items-center gap-3.5 min-w-0">
                        <div class="w-12 h-14 shrink-0 rounded-xl bg-forest text-cream flex items-center justify-center text-xl shadow-xs overflow-hidden">
                            @if ($item->book && $item->book->gambar)
                                <img src="{{ asset('storage/' . $item->book->gambar) }}" alt="{{ $item->book->judul }}" class="w-full h-full object-cover">
                            @else
                                <span>📖</span>
                            @endif
                        </div>

                        <div class="min-w-0">
                            <h3 class="text-sm sm:text-base font-bold text-forest truncate">{{ $item->book->judul ?? 'Buku tidak ditemukan' }}</h3>
                            <p class="text-xs text-sage mt-0.5 truncate">{{ $item->book->penulis ?? 'Penulis tidak diketahui' }}</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-between sm:justify-end gap-4 text-xs shrink-0 pt-2 sm:pt-0 border-t sm:border-t-0 border-gray-100">
                        <div class="text-gray-500 text-left sm:text-right">
                            <span class="block text-gray-700 font-medium">
                                Pinjam: {{ $item->tanggal_pinjam ? \Carbon\Carbon::parse($item->tanggal_pinjam)->translatedFormat('d M Y') : '-' }}
                            </span>
                            @if ($statusAsli === 'dikembalikan' && $item->tanggal_kembali)
                                <span class="text-emerald-700 font-semibold block mt-0.5">
                                    Kembali: {{ \Carbon\Carbon::parse($item->tanggal_kembali)->translatedFormat('d M Y') }}
                                </span>
                            @elseif ($item->jatuh_tempo)
                                <span class="text-sage block mt-0.5">
                                    Tenggat: {{ \Carbon\Carbon::parse($item->jatuh_tempo)->translatedFormat('d M Y') }}
                                </span>
                            @endif
                        </div>

                        <span class="px-3 py-1 rounded-full text-xs font-semibold whitespace-nowrap {{ $classBadge }}">
                            {{ $labelStatus }}
                        </span>
                    </div>
                </article>
            @empty
                <div class="p-12 bg-white border border-gray-200/70 rounded-2xl text-center shadow-xs">
                    <div class="text-4xl mb-3">📚</div>
                    <h3 class="text-base font-bold text-forest">Belum ada riwayat peminjaman</h3>
                    <p class="text-xs text-muted mt-1">Buku yang kamu pinjam akan tercatat otomatis di halaman ini.</p>
                </div>
            @endforelse
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
