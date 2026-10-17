
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Peminjaman - SiPena</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --forest: #173F35;
            --sage: #52796F;
            --cream: #F4E8CD;
            --background: #FAF9F4;
            --text: #203F38;
            --muted: #687B76;
            --border: #ECEDE8;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--background);
            color: var(--text);
            min-height: 100vh;
        }

        .navbar {
            min-height: 70px;
            padding: 12px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            background: var(--background);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--forest);
            font-size: 23px;
            font-weight: 700;
            text-decoration: none;
        }

        .brand-icon {
            width: 38px;
            height: 42px;
            display: grid;
            place-items: center;
            background: var(--forest);
            color: var(--cream);
            border-radius: 12px;
            font-size: 23px;
        }

        .nav-menu {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .nav-menu a {
            padding: 10px 24px;
            border-radius: 30px;
            color: var(--sage);
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
        }

        .nav-menu a.active {
            background: var(--forest);
            color: var(--cream);
            outline: 2px solid #172F29;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .member-info {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--text);
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
        }

        .avatar {
            width: 38px;
            height: 38px;
            display: grid;
            place-items: center;
            border-radius: 50%;
            background: var(--sage);
            color: white;
        }

        .logout-button {
            border: 1px solid var(--sage);
            background: transparent;
            color: var(--forest);
            border-radius: 9px;
            padding: 9px 13px;
            font-family: inherit;
            font-size: 12px;
            cursor: pointer;
        }

        .logout-button:hover {
            background: var(--forest);
            color: white;
        }

        .container {
            max-width: 990px;
            width: calc(100% - 40px);
            margin: 10px auto 50px;
        }

        .page-heading {
            margin-bottom: 28px;
        }

        .page-heading h1 {
            font-size: 28px;
            line-height: 1.5;
            color: var(--forest);
            font-weight: 700;
        }

        .page-heading p {
            font-size: 14px;
            color: var(--sage);
        }

        .summary {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 15px;
            margin-bottom: 29px;
        }

        .summary-card {
            background: white;
            border: 1px solid #F0F0EB;
            border-radius: 16px;
            padding: 18px 19px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            box-shadow: 0 2px 2px rgba(23, 63, 53, 0.03);
        }

        .summary-card span {
            font-size: 13px;
            font-weight: 600;
        }

        .summary-card strong {
            font-size: 23px;
            color: var(--forest);
        }

        .summary-card .on-time {
            color: var(--sage);
        }

        .summary-card .late {
            color: #E84B50;
        }

        .summary-card.late-card {
            border-color: #F4DEDA;
        }

        .filters {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 22px;
        }

        .filter-button {
            border: 1px solid #E2E5E1;
            background: white;
            color: var(--text);
            padding: 9px 19px;
            border-radius: 25px;
            font-family: inherit;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: 0.2s;
        }

        .filter-button:hover,
        .filter-button.active {
            background: var(--forest);
            color: white;
            border-color: var(--forest);
        }

        .borrowing-list {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .borrowing-card {
            background: white;
            border: 1px solid #F0F0EB;
            border-radius: 16px;
            padding: 15px;
            display: grid;
            grid-template-columns: minmax(220px, 1fr) minmax(160px, 0.8fr) auto;
            align-items: center;
            gap: 20px;
            box-shadow: 0 2px 2px rgba(23, 63, 53, 0.03);
        }

        .book-info {
            display: flex;
            align-items: center;
            gap: 18px;
            min-width: 0;
        }

        .book-icon {
            width: 53px;
            height: 60px;
            flex-shrink: 0;
            display: grid;
            place-items: center;
            border-radius: 12px;
            background: var(--forest);
            color: var(--cream);
            font-size: 27px;
        }

        .borrowing-card:nth-child(even) .book-icon {
            background: var(--sage);
        }

        .book-details {
            min-width: 0;
        }

        .book-details h3 {
            color: var(--forest);
            font-size: 15px;
            font-weight: 600;
            overflow-wrap: anywhere;
        }

        .book-details p {
            color: var(--sage);
            font-size: 12px;
            margin-top: 2px;
        }

        .borrowing-date {
            color: #68716F;
            font-size: 12px;
            line-height: 1.8;
        }

        .status {
            display: inline-block;
            white-space: nowrap;
            text-align: center;
            border-radius: 30px;
            padding: 6px 13px;
            font-size: 10px;
            font-weight: 600;
            border: 1px solid transparent;
        }

        .status-dipinjam {
            background: #EDF2EF;
            border-color: #CFDAD5;
            color: var(--sage);
        }

        .status-dikembalikan {
            background: #F2F3F5;
            border-color: #E4E6EA;
            color: #69737C;
        }

        .status-terlambat {
            background: #FFF1F1;
            border-color: #F6CACA;
            color: #D9363E;
        }

        .status-jatuh-tempo {
            background: var(--cream);
            border-color: #E8D9B8;
            color: var(--forest);
        }

        .empty-state {
            padding: 55px 20px;
            background: white;
            border: 1px solid var(--border);
            border-radius: 16px;
            text-align: center;
        }

        .empty-state .empty-icon {
            font-size: 42px;
            margin-bottom: 12px;
        }

        .empty-state h3 {
            color: var(--forest);
            font-size: 17px;
            margin-bottom: 6px;
        }

        .empty-state p {
            color: var(--muted);
            font-size: 13px;
        }

        @media (max-width: 720px) {
            .navbar {
                padding: 12px 16px;
                flex-wrap: wrap;
            }

            .brand {
                font-size: 20px;
            }

            .nav-menu {
                order: 3;
                width: 100%;
                gap: 0;
            }

            .nav-menu a {
                padding: 9px 15px;
            }

            .nav-right {
                gap: 8px;
            }

            .member-name {
                display: none;
            }

            .container {
                width: calc(100% - 28px);
                margin-top: 20px;
            }

            .page-heading h1 {
                font-size: 23px;
            }

            .summary {
                grid-template-columns: 1fr;
                gap: 10px;
                margin-bottom: 22px;
            }

            .summary-card {
                padding: 14px 16px;
            }

            .summary-card strong {
                font-size: 20px;
            }

            .borrowing-card {
                grid-template-columns: minmax(0, 1fr) auto;
                gap: 12px;
                padding: 13px;
            }

            .book-info {
                gap: 12px;
            }

            .book-icon {
                width: 45px;
                height: 52px;
                font-size: 23px;
            }

            .book-details h3 {
                font-size: 13px;
            }

            .borrowing-date {
                grid-column: 1;
                padding-left: 57px;
                font-size: 11px;
            }

            .status {
                grid-column: 2;
                grid-row: 1 / span 2;
                white-space: normal;
                max-width: 100px;
            }
        }
    </style>
</head>

<body>
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

    <header class="navbar">
        <a href="{{ route('member.dashboard') }}" class="brand">
            <span class="brand-icon">📖</span>
            <span>SiPena</span>
        </a>

        <nav class="nav-menu">
            <a href="{{ route('member.dashboard') }}">Beranda</a>
            <a href="{{ url('/member/riwayat') }}" class="active">Riwayat</a>
            <a href="{{ url('/member/profil') }}">Profil</a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-button">Keluar</button>
            </form>
        </div>
        </nav>

        <div class="nav-right">
            <a href="{{ url('/member/profil') }}" class="member-info">
                <span class="avatar">
                    {{ strtoupper(substr($member->nama ?? 'M', 0, 2)) }}
                </span>
                <span class="member-name">{{ $member->nama ?? 'Member' }}</span>
            </a>
    </header>

    <main class="container">
        <div class="page-heading">
            <h1>Riwayat Peminjaman</h1>
            <p>Semua buku yang pernah kamu pinjam</p>
        </div>

        <section class="summary">
            <div class="summary-card">
                <span>Total pinjaman</span>
                <strong>{{ $totalPinjaman }}</strong>
            </div>

            <div class="summary-card">
                <span>Tepat waktu</span>
                <strong class="on-time">{{ $totalTepatWaktu }}</strong>
            </div>

            <div class="summary-card late-card">
                <span>Terlambat</span>
                <strong class="late">{{ $totalTerlambat }}</strong>
            </div>
        </section>

        <div class="filters">
            <a href="{{ url('/member/riwayat') }}"
               class="filter-button {{ $filterAktif === 'semua' ? 'active' : '' }}">
                Semua
            </a>

            <a href="{{ url('/member/riwayat') }}?status=dipinjam"
               class="filter-button {{ $filterAktif === 'dipinjam' ? 'active' : '' }}">
                Dipinjam
            </a>

            <a href="{{ url('/member/riwayat') }}?status=dikembalikan"
               class="filter-button {{ $filterAktif === 'dikembalikan' ? 'active' : '' }}">
                Dikembalikan
            </a>

            <a href="{{ url('/member/riwayat') }}?status=terlambat"
               class="filter-button {{ $filterAktif === 'terlambat' ? 'active' : '' }}">
                Terlambat
            </a>
        </div>

        <section class="borrowing-list">
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

                <article class="borrowing-card">
                    <div class="book-info">
                        <div class="book-icon">📖</div>

                        <div class="book-details">
                            <h3>{{ $item->book->judul ?? 'Buku tidak ditemukan' }}</h3>
                            <p>{{ $item->book->penulis ?? 'Penulis tidak diketahui' }}</p>
                        </div>
                    </div>

                    <div class="borrowing-date">
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

                    <span class="status {{ $classStatus }}">
                        {{ $labelStatus }}
                    </span>
                </article>
            @empty
                <div class="empty-state">
                    <div class="empty-icon">📚</div>
                    <h3>Belum ada riwayat peminjaman</h3>
                    <p>Buku yang kamu pinjam akan muncul di halaman ini.</p>
                </div>
            @endforelse
        </section>
    </main>
</body>
</html>
