<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Member - SiPena</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = { theme: { extend: {
        colors: { forest:'#173F35', sage:'#52796F', cream:'#F4E8CD',
          background:'#FAF9F4', text:'#193F37', muted:'#81908B',
          line:'#EDEDE7', danger:'#D94B4B' },
        fontFamily: { sans:['Arial','Helvetica','sans-serif'] }
      }}};
    </script>
</head>
</head>

<body class="min-h-screen bg-background font-sans text-text ">

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
    <header class="navbar flex h-[72px] items-center justify-between gap-5 bg-background px-[30px] max-[700px]:h-auto max-[700px]:flex-wrap max-[700px]:px-[15px] max-[700px]:py-3">

        <a href="{{ url('/member/dashboard') }}" class="no-underline text-inherit brand flex items-center gap-[11px] text-[23px] font-extrabold text-forest max-[700px]:text-xl">
            <span class="brand-icon grid h-10 w-[38px] place-items-center rounded-[11px] bg-forest text-[23px] text-cream">📖</span>
            <span>SiPena</span>
        </a>

        <nav class="nav-links flex items-center gap-3 max-[700px]:order-3 max-[700px]:w-full max-[700px]:justify-center">
            <a href="{{ url('/member/dashboard') }}" class="active bg-forest text-cream shadow-[0_2px_4px_#00000015]">
                Beranda
            </a>

            <a href="{{ url('/member/riwayat') }}">
                Riwayat
            </a>

            <a href="{{ url('/member/profil') }}">
                Profil
            </a>
            <form action="{{ route('logout') }}" method="POST" class="logout-form inline">
                @csrf
                <button type="submit" class="logout-button cursor-pointer rounded-[10px] border border-forest bg-transparent px-[15px] py-[10px] text-xs font-bold text-forest transition-colors duration-200 hover:bg-forest hover:text-white">
                    Keluar
                </button>
            </form>

        </nav>

        <a href="{{ url('/member/profil') }}" class="member-info flex items-center gap-[10px] text-[13px] font-semibold max-[700px]:text-xs">
            <span class="avatar grid h-[38px] w-[38px] place-items-center rounded-full bg-sage text-xs text-white">
                {{ strtoupper(substr($member->nama ?? 'M', 0, 1)) }}
            </span>

            <span class="member-name max-[370px]:hidden ">
                {{ $member->nama ?? 'Member' }}
            </span>
        </a>

    </header>

    <!-- HERO -->
    <section class="hero relative mx-[15px] mt-4 h-[240px] overflow-hidden rounded-[30px] bg-forest p-11 text-cream max-[700px]:mx-[10px] max-[700px]:mt-[10px] max-[700px]:h-[225px] max-[700px]:px-6 max-[700px]:py-[30px]">

        <div class="hero-content relative z-[2] max-w-[540px] max-[700px]:max-w-full">
            <p class="greeting mb-[13px] text-sm">
                Halo, {{ $member->nama ?? 'Member' }}
            </p>

            <h1 class="mb-[14px] text-[clamp(27px,3.3vw,43px)] leading-[1.08] tracking-[-1.5px] text-white">Jelajahi Ilmu, Bangun Masa Depan.</h1>

            <p class="text-[13px] text-[#A8BEB5]">
                Sedang dipinjam
                <strong class="text-cream">{{ $activeBorrowings->count() }} buku</strong>

                @if ($nearestDue)
                    <span> · Tenggat terdekat </span>
                    <strong class="text-cream">
                        {{ \Illuminate\Support\Carbon::parse($nearestDue->jatuh_tempo)->translatedFormat('d M') }}
                    </strong>
                @endif
            </p>
        </div>

        <div class="hero-decoration absolute bottom-0 right-[35px] flex h-[175px] items-end gap-3 opacity-[0.85] max-[700px]:right-[10px] max-[700px]:opacity-[0.35]" aria-hidden="true">
            <span class="h-[75px] w-[30px] rounded-t-[6px] bg-sage"></span>
            <span class="h-[120px] w-[30px] rounded-t-[6px] bg-cream"></span>
            <span class="h-[90px] w-[30px] rounded-t-[6px] bg-sage"></span>
            <span class="h-[150px] w-[30px] rounded-t-[6px] bg-sage"></span>
            <span class="h-[105px] w-[30px] rounded-t-[6px] bg-cream"></span>
        </div>

    </section>

    <!-- SEARCH DAN FILTER -->
    <form action="{{ url('/member/dashboard') }}"
          method="GET"
          class="search-panel relative z-[3] mx-[4.5%] -mt-[30px] flex min-h-[66px] items-center gap-3 rounded-[17px] bg-white py-[10px] pl-[25px] pr-[11px] shadow-[0_8px_22px_#203b3017] max-[700px]:mx-[18px] max-[700px]:-mt-5 max-[700px]:flex-wrap max-[700px]:p-[15px]">

        <input
            class="search-input min-w-[100px] flex-1 border-0 bg-transparent text-sm text-text outline-none placeholder:text-[#9A9CA7] max-[700px]:basis-full max-[700px]:py-2"
            type="search"
            name="q"
            value="{{ request('q') }}"
            placeholder="Cari judul atau penulis..."
            aria-label="Cari judul atau penulis buku"
        >

        <select class="filter-select max-w-[170px] border-0 border-l border-line bg-white px-3 py-[10px] text-[13px] text-text outline-none max-[700px]:min-w-0 max-[700px]:max-w-none max-[700px]:flex-1 max-[700px]:rounded-lg max-[700px]:border"
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

        <select class="filter-select max-w-[170px] border-0 border-l border-line bg-white px-3 py-[10px] text-[13px] text-text outline-none max-[700px]:min-w-0 max-[700px]:max-w-none max-[700px]:flex-1 max-[700px]:rounded-lg max-[700px]:border"
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

        <button type="submit" class="search-button cursor-pointer rounded-xl border-0 bg-forest px-[25px] py-[14px] font-bold text-cream transition-colors duration-200 hover:bg-sage max-[700px]:flex-1 max-[700px]:py-3">
            Cari Buku
        </button>

    </form>

    <main class="content px-[15px] pb-[30px] pt-[45px] max-[700px]:px-3 max-[700px]:pb-5 max-[700px]:pt-[35px]">

        <!-- SEDANG DIPINJAM -->
        <section>
            <h2 class="section-title mb-[17px] flex items-center gap-[9px] text-[19px]">
                <span class="symbol text-[22px] text-sage">◴</span>
                Sedang Kamu Pinjam
            </h2>

            <div class="borrow-grid mb-[26px] grid grid-cols-2 gap-[15px] max-[700px]:grid-cols-1">

                @forelse ($activeBorrowings as $borrowing)
                    @php
                        $isOverdue = $borrowing->jatuh_tempo
                            && \Illuminate\Support\Carbon::parse($borrowing->jatuh_tempo)->isPast()
                            && !\Illuminate\Support\Carbon::parse($borrowing->jatuh_tempo)->isToday();
                    @endphp

                    <article class="borrow-card flex min-h-[84px] items-center justify-between gap-3 rounded-[17px] border border-line bg-white p-[18px] shadow-[0_2px_3px_#00000006]">

                        <div>
                            <h3 class="mb-[6px] text-[15px]">
                                {{ $borrowing->book->judul ?? 'Buku tidak tersedia' }}
                            </h3>

                            <p class="text-[11px] text-muted">
                                Tenggat:
                                @if ($borrowing->jatuh_tempo)
                                    {{ \Illuminate\Support\Carbon::parse($borrowing->jatuh_tempo)->translatedFormat('d M Y') }}
                                @else
                                    Belum ditentukan
                                @endif
                            </p>
                        </div>

                        <span class="status {{ $isOverdue ? 'danger' : '' }} whitespace-nowrap rounded-[9px] bg-[#EDF2F0] px-[13px] py-[9px] text-[11px] font-bold text-sage">
                            {{ $isOverdue ? 'Terlambat' : 'Dipinjam' }}
                        </span>

                    </article>

                @empty
                    <div class="empty-state col-span-full rounded-[18px] border border-line bg-white px-5 py-10 text-center leading-[1.8] text-muted">
                        <p>Kamu belum memiliki buku yang sedang dipinjam.</p>
                    </div>
                @endforelse

            </div>
        </section>

        <!-- DAFTAR BUKU DAN KATEGORI -->
        <section class="book-layout grid grid-cols-[minmax(0,1fr)_265px] items-start gap-[30px] max-[1050px]:grid-cols-1">

            <div class="book-section ">

                <h2 class="section-title mb-[17px] flex items-center gap-[9px] text-[19px]">Eksplorasi Buku</h2>

                <div class="book-grid grid grid-cols-4 gap-4 max-[1050px]:grid-cols-3 max-[700px]:grid-cols-2 max-[700px]:gap-[10px] max-[370px]:grid-cols-1">

                    @forelse ($books as $book)

                        <article class="book-card flex min-w-0 flex-col rounded-[22px] border border-[#F0F0EA] bg-white p-[15px] shadow-[0_2px_3px_#00000004] max-[700px]:rounded-[17px] max-[700px]:p-[10px]">

                            <div class="book-cover mb-5 grid h-[122px] place-items-center overflow-hidden rounded-2xl bg-forest text-cream max-[700px]:mb-[13px] max-[700px]:h-[115px]">

                                @if ($book->gambar)
                                    <img class="h-full w-full object-cover"
                                        src="{{ asset('storage/' . $book->gambar) }}"
                                        alt="Sampul {{ $book->judul }}"
                                        loading="lazy"
                                    >
                                @else
                                    <span class="book-symbol text-[40px]">📖</span>
                                @endif

                            </div>

                            <h3 class="mb-[5px] text-[15px] leading-[1.4] [overflow-wrap:anywhere] max-[700px]:text-sm">{{ $book->judul }}</h3>

                            <p class="author mb-[13px] text-xs leading-[1.5] text-sage">
                                {{ $book->penulis }}
                            </p>

                            <div class="book-tags mb-[15px] flex flex-wrap gap-[6px]">

                                <span class="tag rounded-md bg-cream px-[9px] py-[6px] text-[9px] font-bold">
                                    {{ $book->category->nama_kategori ?? 'Tanpa kategori' }}
                                </span>

                                @if (($book->stok ?? 0) > 0)
                                    <span class="tag stock rounded-md bg-cream px-[9px] py-[6px] text-[9px] font-bold bg-[#EDF2F0] text-sage">
                                        Stok {{ $book->stok }}
                                    </span>
                                @else
                                    <span class="tag empty rounded-md bg-cream px-[9px] py-[6px] text-[9px] font-bold bg-[#FFF0F0] text-danger">
                                        Stok habis
                                    </span>
                                @endif

                            </div>

                            <a
                                href="{{ url('/member/buku/' . $book->id) }}"
                                class="detail-button mt-auto block rounded-[11px] bg-cream px-2 py-3 text-center text-xs font-bold transition-colors duration-200 hover:bg-forest hover:text-white"
                            >
                                Selengkapnya
                            </a>

                        </article>

                    @empty

                        <div class="empty-state col-span-full rounded-[18px] border border-line bg-white px-5 py-10 text-center leading-[1.8] text-muted">
                            <p>
                                Belum ada buku yang tersedia atau tidak ada
                                buku yang cocok dengan pencarianmu.
                            </p>
                        </div>

                    @endforelse

                </div>

                @if (method_exists($books, 'links'))
                    <div class="mt-[22px]">
                        {{ $books->links() }}
                    </div>
                @endif

            </div>

            <!-- SIDEBAR KATEGORI -->
            <aside class="category-panel rounded-[24px] border border-[#F0F0EA] bg-white px-[22px] py-[25px] max-[700px]:px-[15px] max-[700px]:py-5 max-[1050px]:order-first">

                <h2 class="mb-5 text-[19px]">Kategori</h2>

                <div class="category-list max-[1050px]:flex max-[1050px]:flex-wrap max-[1050px]:gap-2">

                    <a
                        href="{{ url('/member/dashboard') }}"
                        class="category-link {{ !$selectedCategory ? 'active' : '' }} mb-1 flex items-center justify-between gap-[10px] rounded-xl px-[14px] py-[13px] text-[13px] hover:bg-cream max-[1050px]:bg-[#F8F8F3]"
                    >
                        <span>Semua</span>
                    </a>

                    @foreach ($categories as $category)

                        <a
                            href="{{ url('/member/dashboard') . '?' . http_build_query(array_merge(request()->except('kategori', 'page'), ['kategori' => $category->id])) }}"
                            class="category-link {{ (string) $selectedCategory === (string) $category->id ? 'active' : '' }} mb-1 flex items-center justify-between gap-[10px] rounded-xl px-[14px] py-[13px] text-[13px] hover:bg-cream max-[1050px]:bg-[#F8F8F3]"
                        >
                            <span>{{ $category->nama_kategori }}</span>
                        </a>

                    @endforeach

                </div>

            </aside>

        </section>

    </main>

    <footer class="footer p-[15px] text-center text-xs text-muted">
        &copy; {{ date('Y') }} SiPena · Sistem Informasi Perpustakaan
    </footer>

</body>
</html>