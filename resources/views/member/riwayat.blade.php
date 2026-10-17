
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Peminjaman - SiPena</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config={theme:{extend:{fontFamily:{poppins:["Poppins","sans-serif"]},colors:{forest:"#173F35",sage:"#52796F",cream:"#F4E8CD",page:"#FAF9F4",ink:"#203F38",muted:"#687B76",line:"#ECEDE8"}}}}</script>
</head>

<body class="min-h-screen bg-page text-ink font-poppins">
    @php
        $member = auth()->user();
        $filterAktif = request('status', 'semua');
        $sekarang = now();

        $totalPinjaman = $peminjaman->count();

        $totalTerlambat = $peminjaman->filter(function ($item) use ($sekarang) {
            return $item->status === 'dipinjam'
                && $item->jatuh_tempo
                && \Carbon\Carbon::parse($item->jatuh_tempo)->lt($sekarang->startOfDay());
        })->count();

        $totalTepatWaktu = $peminjaman->filter(function ($item) use ($sekarang) {
            return $item->status === 'dikembalikan'
                && $item->tanggal_kembali
                && $item->jatuh_tempo
                && \Carbon\Carbon::parse($item->tanggal_kembali)
                    ->lte(\Carbon\Carbon::parse($item->jatuh_tempo));
        })->count();
    @endphp

    <header class="navbar min-h-[70px] px-[30px] py-3 flex items-center justify-between gap-5 bg-page max-[720px]:px-4 flex-wrap">
        <a href="{{ route('member.dashboard') }}" class="brand flex items-center gap-2.5 text-forest text-[23px] font-bold no-underline max-[720px]:text-xl">
            <span class="brand-icon w-[38px] h-[42px] grid place-items-center bg-forest text-cream rounded-xl text-[23px]">📖</span>
            <span>SiPena</span>
        </a>

        <nav class="nav-menu flex items-center justify-center gap-2.5 max-[720px]:order-3 max-[720px]:w-full max-[720px]:gap-0">
            <a href="{{ route('member.dashboard') }}">Beranda</a>
            <a href="{{ url('/member/riwayat') }}" class="active bg-forest text-cream outline outline-2 outline-[#172F29]">Riwayat</a>
            <a href="{{ url('/member/profil') }}">Profil</a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-button border border-sage bg-transparent text-forest rounded-[9px] px-[13px] py-[9px] font-poppins text-xs cursor-pointer hover:bg-forest hover:text-white">Keluar</button>
            </form>
        </div>
        </nav>

        <div class="nav-right flex items-center gap-3 max-[720px]:gap-2">
            <a href="{{ url('/member/profil') }}" class="member-info flex items-center gap-2.5 text-ink text-[13px] font-semibold no-underline">
                <span class="avatar w-[38px] h-[38px] grid place-items-center rounded-full bg-sage text-white shrink-0">
                    {{ strtoupper(substr($member->nama ?? 'M', 0, 2)) }}
                </span>
                <span class="member-name max-[720px]:hidden">{{ $member->nama ?? 'Member' }}</span>
            </a>
    </header>

    <main class="container max-w-[990px] w-[calc(100%-40px)] mx-auto mt-[10px] mb-[50px] max-[720px]:w-[calc(100%-28px)] max-[720px]:mt-5">
        <div class="page-heading mb-7">
            <h1 class="text-[28px] leading-[1.5] text-forest font-bold max-[720px]:text-[23px]">Riwayat Peminjaman</h1>
            <p class="text-sm text-sage">Semua buku yang pernah kamu pinjam</p>
        </div>

        <section class="summary grid grid-cols-3 gap-[15px] mb-[29px] max-[720px]:grid-cols-1 max-[720px]:gap-[10px] max-[720px]:mb-[22px]">
            <div class="summary-card bg-white border border-[#F0F0EB] rounded-2xl px-[19px] py-[18px] flex items-center justify-between gap-[10px] shadow-[0_2px_2px_rgba(23,63,53,0.03)] max-[720px]:px-4 max-[720px]:py-[14px]">
                <span class="text-[13px] font-semibold">Total pinjaman</span>
                <strong class="text-[23px] text-forest max-[720px]:text-xl">{{ $totalPinjaman }}</strong>
            </div>

            <div class="summary-card bg-white border border-[#F0F0EB] rounded-2xl px-[19px] py-[18px] flex items-center justify-between gap-[10px] shadow-[0_2px_2px_rgba(23,63,53,0.03)] max-[720px]:px-4 max-[720px]:py-[14px]">
                <span class="text-[13px] font-semibold">Tepat waktu</span>
                <strong class="text-[23px] text-forest max-[720px]:text-xl on-time text-sage">{{ $totalTepatWaktu }}</strong>
            </div>

            <div class="summary-card late-card bg-white border border-[#F0F0EB] rounded-2xl px-[19px] py-[18px] flex items-center justify-between gap-[10px] shadow-[0_2px_2px_rgba(23,63,53,0.03)] max-[720px]:px-4 max-[720px]:py-[14px] border-[#F4DEDA]">
                <span class="text-[13px] font-semibold">Terlambat</span>
                <strong class="text-[23px] text-forest max-[720px]:text-xl late text-[#E84B50]">{{ $totalTerlambat }}</strong>
            </div>
        </section>

        <div class="filters flex flex-wrap gap-[10px] mb-[22px]">
            <a href="{{ url('/member/riwayat') }}"
               class="filter-button {{ $filterAktif === 'semua' ? 'active bg-forest text-white border-forest' : '' }} border border-[#E2E5E1] bg-white text-ink px-[19px] py-[9px] rounded-[25px] font-poppins text-xs font-semibold no-underline cursor-pointer transition duration-200 hover:bg-forest hover:text-white hover:border-forest">
                Semua
            </a>

            <a href="{{ url('/member/riwayat') }}?status=dipinjam"
               class="filter-button {{ $filterAktif === 'dipinjam' ? 'active bg-forest text-white border-forest' : '' }} border border-[#E2E5E1] bg-white text-ink px-[19px] py-[9px] rounded-[25px] font-poppins text-xs font-semibold no-underline cursor-pointer transition duration-200 hover:bg-forest hover:text-white hover:border-forest">
                Dipinjam
            </a>

            <a href="{{ url('/member/riwayat') }}?status=dikembalikan"
               class="filter-button {{ $filterAktif === 'dikembalikan' ? 'active bg-forest text-white border-forest' : '' }} border border-[#E2E5E1] bg-white text-ink px-[19px] py-[9px] rounded-[25px] font-poppins text-xs font-semibold no-underline cursor-pointer transition duration-200 hover:bg-forest hover:text-white hover:border-forest">
                Dikembalikan
            </a>

            <a href="{{ url('/member/riwayat') }}?status=terlambat"
               class="filter-button {{ $filterAktif === 'terlambat' ? 'active bg-forest text-white border-forest' : '' }} border border-[#E2E5E1] bg-white text-ink px-[19px] py-[9px] rounded-[25px] font-poppins text-xs font-semibold no-underline cursor-pointer transition duration-200 hover:bg-forest hover:text-white hover:border-forest">
                Terlambat
            </a>
        </div>

        <section class="borrowing-list flex flex-col gap-[14px]">
            @forelse ($peminjaman as $item)
                @php
                    $statusAsli = strtolower($item->status ?? '');

                    $terlambat = $statusAsli === 'dipinjam'
                        && $item->jatuh_tempo
                        && \Carbon\Carbon::parse($item->jatuh_tempo)->lt(now()->startOfDay());

                    if ($terlambat) {
                        $labelStatus = 'Terlambat';
                        $classStatus = 'status-terlambat';
                    } elseif ($statusAsli === 'dikembalikan') {
                        $labelStatus = 'Dikembalikan';
                        $classStatus = 'status-dikembalikan';
                    } elseif ($statusAsli === 'dipinjam' && $item->jatuh_tempo
                        && \Carbon\Carbon::parse($item->jatuh_tempo)->isToday()) {
                        $labelStatus = 'Jatuh tempo';
                        $classStatus = 'status-jatuh-tempo';
                    } else {
                        $labelStatus = ucfirst($statusAsli ?: 'Dipinjam');
                        $classStatus = 'status-dipinjam';
                    }
                @endphp

                <article class="borrowing-card bg-white border border-[#F0F0EB] rounded-2xl p-[15px] grid grid-cols-[minmax(220px,1fr)_minmax(160px,0.8fr)_auto] items-center gap-5 shadow-[0_2px_2px_rgba(23,63,53,0.03)] max-[720px]:grid-cols-[minmax(0,1fr)_auto] max-[720px]:gap-3 max-[720px]:p-[13px]">
                    <div class="book-info flex items-center gap-[18px] min-w-0 max-[720px]:gap-3">
                        <div class="book-icon w-[53px] h-[60px] shrink-0 grid place-items-center rounded-xl bg-forest text-cream text-[27px] even:bg-sage max-[720px]:w-[45px] max-[720px]:h-[52px] max-[720px]:text-[23px]">📖</div>

                        <div class="book-details min-w-0">
                            <h3 class="text-forest text-[15px] font-semibold [overflow-wrap:anywhere] max-[720px]:text-[13px]">{{ $item->book->judul ?? 'Buku tidak ditemukan' }}</h3>
                            <p class="text-sage text-xs mt-0.5">{{ $item->book->penulis ?? 'Penulis tidak diketahui' }}</p>
                        </div>
                    </div>

                    <div class="borrowing-date text-[#68716F] text-xs leading-[1.8] max-[720px]:col-start-1 max-[720px]:pl-[57px] max-[720px]:text-[11px]">
                        @if ($item->tanggal_pinjam)
                            {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->translatedFormat('j M') }}
                        @else
                            -
                        @endif

                        @if ($statusAsli === 'dikembalikan' && $item->tanggal_kembali)
                            – kembali
                            {{ \Carbon\Carbon::parse($item->tanggal_kembali)->translatedFormat('j M') }}
                        @elseif ($item->jatuh_tempo)
                            – tenggat
                            {{ \Carbon\Carbon::parse($item->jatuh_tempo)->translatedFormat('j M') }}
                        @endif
                    </div>

                    <span class="status {{ $classStatus }} inline-block whitespace-nowrap text-center rounded-[30px] px-[13px] py-[6px] text-[10px] font-semibold border border-transparent max-[720px]:col-start-2 max-[720px]:row-span-2 max-[720px]:whitespace-normal max-[720px]:max-w-[100px]">
                        {{ $labelStatus }}
                    </span>
                </article>
            @empty
                <div class="empty-state p-[55px_20px] bg-white border border-line rounded-2xl text-center">
                    <div class="empty-icon text-[42px] mb-3">📚</div>
                    <h3 class="text-forest text-[17px] mb-1.5">Belum ada riwayat peminjaman</h3>
                    <p class="text-muted text-[13px]">Buku yang kamu pinjam akan muncul di halaman ini.</p>
                </div>
            @endforelse
        </section>
    </main>
</body>
</html>
