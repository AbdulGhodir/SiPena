
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Member - SiPena</title>

    <style>
        :root {
            --forest: #173F35;
            --sage: #52796F;
            --cream: #F4E8CD;
            --white: #FFFFFF;
            --background: #FAF9F4;
            --text: #193F37;
            --muted: #81908B;
            --border: #EDEDE7;
            --danger: #D94B4B;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: var(--background);
            color: var(--text);
            min-height: 100vh;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        button, input, select {
            font: inherit;
        }

        /* NAVBAR */
        .navbar {
            height: 72px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            background: var(--background);
            gap: 20px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 11px;
            font-size: 23px;
            font-weight: 800;
            color: var(--forest);
        }

        .brand-icon {
            width: 38px;
            height: 40px;
            border-radius: 11px;
            background: var(--forest);
            color: var(--cream);
            display: grid;
            place-items: center;
            font-size: 23px;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .nav-links a {
            padding: 12px 23px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 600;
            color: var(--sage);
        }

        .nav-links a.active {
            background: var(--forest);
            color: var(--cream);
            box-shadow: 0 2px 4px #00000015;
        }

        .member-info {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            font-weight: 600;
        }

        .logout-button {
            border: 1px solid #173F35;
            background: transparent;
            color: #173F35;
            padding: 10px 15px;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: .2s;
        }

        .logout-button:hover {
            background: #173F35;
            color: #FFFFFF;
        }

        .logout-form {
            display: inline;
        }

        .avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: var(--sage);
            color: white;
            display: grid;
            place-items: center;
            font-size: 12px;
        }

        /* HERO */
        .hero {
            margin: 16px 15px 0;
            height: 240px;
            padding: 44px;
            border-radius: 30px;
            background: var(--forest);
            color: var(--cream);
            position: relative;
            overflow: hidden;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 540px;
        }

        .greeting {
            font-size: 14px;
            margin-bottom: 13px;
        }

        .hero h1 {
            font-size: clamp(27px, 3.3vw, 43px);
            line-height: 1.08;
            letter-spacing: -1.5px;
            margin-bottom: 14px;
            color: var(--white);
        }

        .hero p {
            color: #A8BEB5;
            font-size: 13px;
        }

        .hero p strong {
            color: var(--cream);
        }

        .hero-decoration {
            position: absolute;
            right: 35px;
            bottom: 0;
            height: 175px;
            display: flex;
            align-items: flex-end;
            gap: 12px;
            opacity: .85;
        }

        .hero-decoration span {
            width: 30px;
            border-radius: 6px 6px 0 0;
            background: var(--sage);
        }

        .hero-decoration span:nth-child(1) { height: 75px; }
        .hero-decoration span:nth-child(2) { height: 120px; background: var(--cream); }
        .hero-decoration span:nth-child(3) { height: 90px; }
        .hero-decoration span:nth-child(4) { height: 150px; }
        .hero-decoration span:nth-child(5) { height: 105px; background: var(--cream); }

        /* SEARCH */
        .search-panel {
            position: relative;
            z-index: 3;
            margin: -30px 4.5% 0;
            min-height: 66px;
            background: var(--white);
            border-radius: 17px;
            box-shadow: 0 8px 22px #203b3017;
            display: flex;
            align-items: center;
            padding: 10px 11px 10px 25px;
            gap: 12px;
        }

        .search-input {
            flex: 1;
            min-width: 100px;
            border: none;
            outline: none;
            color: var(--text);
            background: transparent;
            font-size: 14px;
        }

        .search-input::placeholder {
            color: #9A9CA7;
        }

        .filter-select {
            border: none;
            border-left: 1px solid var(--border);
            background: white;
            padding: 10px 12px;
            color: var(--text);
            font-size: 13px;
            outline: none;
            max-width: 170px;
        }

        .search-button {
            border: none;
            border-radius: 12px;
            background: var(--forest);
            color: var(--cream);
            padding: 14px 25px;
            font-weight: 700;
            cursor: pointer;
            transition: .2s;
        }

        .search-button:hover {
            background: var(--sage);
        }

        /* CONTENT */
        .content {
            padding: 45px 15px 30px;
        }

        .section-title {
            font-size: 19px;
            margin-bottom: 17px;
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .section-title .symbol {
            color: var(--sage);
            font-size: 22px;
        }

        .borrow-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 15px;
            margin-bottom: 26px;
        }

        .borrow-card {
            min-height: 84px;
            padding: 18px;
            background: white;
            border: 1px solid var(--border);
            border-radius: 17px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            box-shadow: 0 2px 3px #00000006;
        }

        .borrow-card h3 {
            font-size: 15px;
            margin-bottom: 6px;
        }

        .borrow-card p {
            font-size: 11px;
            color: var(--muted);
        }

        .status {
            white-space: nowrap;
            padding: 9px 13px;
            border-radius: 9px;
            background: #EDF2F0;
            color: var(--sage);
            font-size: 11px;
            font-weight: 700;
        }

        .status.danger {
            color: var(--danger);
            background: #FFF1F1;
            border: 1px solid #F5D1D1;
        }

        .book-layout {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 265px;
            gap: 30px;
            align-items: start;
        }

        .book-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
        }

        .book-card {
            background: white;
            border: 1px solid #F0F0EA;
            border-radius: 22px;
            padding: 15px;
            min-width: 0;
            display: flex;
            flex-direction: column;
            box-shadow: 0 2px 3px #00000004;
        }

        .book-cover {
            height: 122px;
            background: var(--forest);
            color: var(--cream);
            border-radius: 16px;
            display: grid;
            place-items: center;
            margin-bottom: 20px;
            overflow: hidden;
        }

        .book-card:nth-child(even) .book-cover {
            background: var(--sage);
        }

        .book-cover img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .book-symbol {
            font-size: 40px;
        }

        .book-card h3 {
            font-size: 15px;
            line-height: 1.4;
            margin-bottom: 5px;
            overflow-wrap: anywhere;
        }

        .author {
            font-size: 12px;
            color: var(--sage);
            line-height: 1.5;
            margin-bottom: 13px;
        }

        .book-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-bottom: 15px;
        }

        .tag {
            padding: 6px 9px;
            background: var(--cream);
            border-radius: 6px;
            font-size: 9px;
            font-weight: 700;
        }

        .tag.stock {
            background: #EDF2F0;
            color: var(--sage);
        }

        .tag.empty {
            background: #FFF0F0;
            color: var(--danger);
        }

        .detail-button {
            margin-top: auto;
            text-align: center;
            display: block;
            background: var(--cream);
            border-radius: 11px;
            padding: 12px 8px;
            font-size: 12px;
            font-weight: 700;
            transition: .2s;
        }

        .detail-button:hover {
            background: var(--forest);
            color: white;
        }

        /* CATEGORY */
        .category-panel {
            background: white;
            border: 1px solid #F0F0EA;
            border-radius: 24px;
            padding: 25px 22px;
        }

        .category-panel h2 {
            font-size: 19px;
            margin-bottom: 20px;
        }

        .category-link {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 13px 14px;
            border-radius: 12px;
            font-size: 13px;
            margin-bottom: 4px;
            gap: 10px;
        }

        .category-link.active,
        .category-link:hover {
            background: var(--cream);
        }

        .category-count {
            color: #919A9B;
            white-space: nowrap;
        }

        .empty-state {
            grid-column: 1 / -1;
            text-align: center;
            background: white;
            padding: 40px 20px;
            border: 1px solid var(--border);
            border-radius: 18px;
            color: var(--muted);
            line-height: 1.8;
        }

        .footer {
            text-align: center;
            color: var(--muted);
            font-size: 12px;
            padding: 15px;
        }

        @media (max-width: 1050px) {
            .book-layout {
                grid-template-columns: 1fr;
            }

            .category-panel {
                order: -1;
            }

            .category-list {
                display: flex;
                gap: 8px;
                flex-wrap: wrap;
            }

            .category-link {
                background: #F8F8F3;
            }

            .book-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 700px) {
            .navbar {
                padding: 12px 15px;
                height: auto;
                flex-wrap: wrap;
            }

            .brand {
                font-size: 20px;
            }

            .nav-links {
                order: 3;
                width: 100%;
                justify-content: center;
            }

            .nav-links a {
                padding: 10px 16px;
            }

            .member-info {
                font-size: 12px;
            }

            .hero {
                height: 225px;
                padding: 30px 24px;
                margin: 10px 10px 0;
            }

            .hero-decoration {
                right: 10px;
                opacity: .35;
            }

            .hero-content {
                max-width: 100%;
            }

            .search-panel {
                margin: -20px 18px 0;
                padding: 15px;
                flex-wrap: wrap;
            }

            .search-input {
                flex-basis: 100%;
                padding: 8px 0;
            }

            .filter-select {
                flex: 1;
                max-width: none;
                border: 1px solid var(--border);
                border-radius: 8px;
                min-width: 0;
            }

            .search-button {
                flex: 1;
                padding: 12px;
            }

            .content {
                padding: 35px 12px 20px;
            }

            .borrow-grid {
                grid-template-columns: 1fr;
            }

            .book-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 10px;
            }

            .book-card {
                padding: 10px;
                border-radius: 17px;
            }

            .book-cover {
                height: 115px;
                margin-bottom: 13px;
            }

            .book-card h3 {
                font-size: 14px;
            }

            .category-panel {
                padding: 20px 15px;
            }
        }

        @media (max-width: 370px) {
            .book-grid {
                grid-template-columns: 1fr;
            }

            .member-name {
                display: none;
            }
        }
    </style>
</head>

<body>

    @php
        $member = auth()->user();

        $books = $books ?? collect();
        $categories = $categories ?? collect();
        $borrowings = $borrowings ?? collect();

        $activeBorrowings = $borrowings->filter(function ($borrowing) {
            return strtolower($borrowing->status ?? '') === 'dipinjam';
        });

        $overdueBorrowings = $activeBorrowings->filter(function ($borrowing) {
            return $borrowing->jatuh_tempo
                && \Illuminate\Support\Carbon::parse($borrowing->jatuh_tempo)->isPast()
                && !\Illuminate\Support\Carbon::parse($borrowing->jatuh_tempo)->isToday();
        });

        $nearestDue = $activeBorrowings
            ->filter(fn ($borrowing) => $borrowing->jatuh_tempo)
            ->sortBy('jatuh_tempo')
            ->first();

        $selectedCategory = request('kategori');
        $selectedStock = request('stok', 'semua');
    @endphp

    <!-- NAVBAR -->
    <header class="navbar">

        <a href="{{ url('/member/dashboard') }}" class="brand">
            <span class="brand-icon">📖</span>
            <span>SiPena</span>
        </a>

        <nav class="nav-links">
            <a href="{{ url('/member/dashboard') }}" class="active">
                Beranda
            </a>

            <a href="{{ url('/member/riwayat') }}">
                Riwayat
            </a>

            <a href="{{ url('/member/profil') }}">
                Profil
            </a>
            <form action="{{ route('logout') }}" method="POST" class="logout-form">
                @csrf
                <button type="submit" class="logout-button">
                    Keluar
                </button>
            </form>

        </nav>

        <a href="{{ url('/member/profil') }}" class="member-info">
            <span class="avatar">
                {{ strtoupper(substr($member->nama ?? 'M', 0, 1)) }}
            </span>

            <span class="member-name">
                {{ $member->nama ?? 'Member' }}
            </span>
        </a>

    </header>

    <!-- HERO -->
    <section class="hero">

        <div class="hero-content">
            <p class="greeting">
                Halo, {{ $member->nama ?? 'Member' }}
            </p>

            <h1>Jelajahi Ilmu, Bangun Masa Depan.</h1>

            <p>
                Sedang dipinjam
                <strong>{{ $activeBorrowings->count() }} buku</strong>

                @if ($nearestDue)
                    <span> · Tenggat terdekat </span>
                    <strong>
                        {{ \Illuminate\Support\Carbon::parse($nearestDue->jatuh_tempo)->translatedFormat('d M') }}
                    </strong>
                @endif
            </p>
        </div>

        <div class="hero-decoration" aria-hidden="true">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </div>

    </section>

    <!-- SEARCH DAN FILTER -->
    <form action="{{ url('/member/dashboard') }}"
          method="GET"
          class="search-panel">

        <input
            class="search-input"
            type="search"
            name="q"
            value="{{ request('q') }}"
            placeholder="Cari judul atau penulis..."
            aria-label="Cari judul atau penulis buku"
        >

        <select class="filter-select"
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

        <select class="filter-select"
                name="stok"
                aria-label="Filter stok">

            <option value="semua" @selected($selectedStock === 'semua')>
                Semua stok
            </option>

            <option value="tersedia" @selected($selectedStock === 'tersedia')>
                Tersedia
            </option>

            <option value="habis" @selected($selectedStock === 'habis')>
                Stok habis
            </option>

        </select>

        <button type="submit" class="search-button">
            Cari Buku
        </button>

    </form>

    <main class="content">

        <!-- SEDANG DIPINJAM -->
        <section>
            <h2 class="section-title">
                <span class="symbol">◴</span>
                Sedang Kamu Pinjam
            </h2>

            <div class="borrow-grid">

                @forelse ($activeBorrowings as $borrowing)
                    @php
                        $isOverdue = $borrowing->jatuh_tempo
                            && \Illuminate\Support\Carbon::parse($borrowing->jatuh_tempo)->isPast()
                            && !\Illuminate\Support\Carbon::parse($borrowing->jatuh_tempo)->isToday();
                    @endphp

                    <article class="borrow-card">

                        <div>
                            <h3>
                                {{ $borrowing->book->judul ?? 'Buku tidak tersedia' }}
                            </h3>

                            <p>
                                Tenggat:
                                @if ($borrowing->jatuh_tempo)
                                    {{ \Illuminate\Support\Carbon::parse($borrowing->jatuh_tempo)->translatedFormat('d M Y') }}
                                @else
                                    Belum ditentukan
                                @endif
                            </p>
                        </div>

                        <span class="status {{ $isOverdue ? 'danger' : '' }}">
                            {{ $isOverdue ? 'Terlambat' : 'Dipinjam' }}
                        </span>

                    </article>

                @empty
                    <div class="empty-state">
                        <p>Kamu belum memiliki buku yang sedang dipinjam.</p>
                    </div>
                @endforelse

            </div>
        </section>

        <!-- DAFTAR BUKU DAN KATEGORI -->
        <section class="book-layout">

            <div class="book-section">

                <h2 class="section-title">Eksplorasi Buku</h2>

                <div class="book-grid">

                    @forelse ($books as $book)

                        <article class="book-card">

                            <div class="book-cover">

                                @if ($book->gambar)
                                    <img
                                        src="{{ asset('storage/' . $book->gambar) }}"
                                        alt="Sampul {{ $book->judul }}"
                                        loading="lazy"
                                    >
                                @else
                                    <span class="book-symbol">📖</span>
                                @endif

                            </div>

                            <h3>{{ $book->judul }}</h3>

                            <p class="author">
                                {{ $book->penulis }}
                            </p>

                            <div class="book-tags">

                                <span class="tag">
                                    {{ $book->category->nama_kategori ?? 'Tanpa kategori' }}
                                </span>

                                @if (($book->stok ?? 0) > 0)
                                    <span class="tag stock">
                                        Stok {{ $book->stok }}
                                    </span>
                                @else
                                    <span class="tag empty">
                                        Stok habis
                                    </span>
                                @endif

                            </div>

                            <a
                                href="{{ url('/member/buku/' . $book->id) }}"
                                class="detail-button"
                            >
                                Selengkapnya
                            </a>

                        </article>

                    @empty

                        <div class="empty-state">
                            <p>
                                Belum ada buku yang tersedia atau tidak ada
                                buku yang cocok dengan pencarianmu.
                            </p>
                        </div>

                    @endforelse

                </div>

                @if (method_exists($books, 'links'))
                    <div style="margin-top: 22px;">
                        {{ $books->links() }}
                    </div>
                @endif

            </div>

            <!-- SIDEBAR KATEGORI -->
            <aside class="category-panel">

                <h2>Kategori</h2>

                <div class="category-list">

                    <a
                        href="{{ url('/member/dashboard') }}"
                        class="category-link {{ !$selectedCategory ? 'active' : '' }}"
                    >
                        <span>Semua</span>
                    </a>

                    @foreach ($categories as $category)

                        <a
                            href="{{ url('/member/dashboard') . '?' . http_build_query(array_merge(request()->except('kategori', 'page'), ['kategori' => $category->id])) }}"
                            class="category-link {{ (string) $selectedCategory === (string) $category->id ? 'active' : '' }}"
                        >
                            <span>{{ $category->nama_kategori }}</span>
                        </a>

                    @endforeach

                </div>

            </aside>

        </section>

    </main>

    <footer class="footer">
        &copy; {{ date('Y') }} SiPena · Sistem Informasi Perpustakaan
    </footer>

</body>
</html>