<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Buku - SiPena</title>
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

<body class="min-h-screen bg-background font-sans text-text">

    @php
        $member = auth()->user();
    @endphp

    <!-- NAVBAR -->
    <header class="navbar flex h-[72px] items-center justify-between gap-5 bg-background px-[30px]">
        <a href="{{ url('/member/dashboard') }}" class="no-underline text-inherit brand flex items-center gap-[11px] text-[23px] font-extrabold text-forest">
            <span class="brand-icon grid h-10 w-[38px] place-items-center rounded-[11px] bg-forest text-[23px] text-cream">📖</span>
            <span>SiPena</span>
        </a>

        <nav class="nav-links flex items-center gap-3">
            <a href="{{ url('/member/dashboard') }}" class="px-4 py-2 rounded-lg hover:bg-cream transition-colors">Beranda</a>
            <a href="{{ url('/member/riwayat') }}" class="px-4 py-2 rounded-lg hover:bg-cream transition-colors">Riwayat</a>
            <a href="{{ url('/member/profil') }}" class="px-4 py-2 rounded-lg hover:bg-cream transition-colors">Profil</a>
            
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="rounded-[10px] border border-forest px-[15px] py-[10px] text-xs font-bold text-forest hover:bg-forest hover:text-white transition-all">
                    Keluar
                </button>
            </form>
        </nav>

        <a href="{{ url('/member/profil') }}" class="member-info flex items-center gap-[10px] text-[13px] font-semibold">
            <span class="avatar grid h-[38px] w-[38px] place-items-center rounded-full bg-sage text-xs text-white">
                {{ strtoupper(substr($member->nama ?? 'M', 0, 1)) }}
            </span>
            <span class="member-name">{{ $member->nama ?? 'Member' }}</span>
        </a>
    </header>

    <main class="max-w-[1000px] mx-auto px-6 py-10">
        <!-- Back Button -->
        <a href="{{ route('member.dashboard') }}" class="flex items-center gap-2 text-muted hover:text-forest transition-colors mb-8 text-sm font-medium">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
            </svg>
            Kembali
        </a>

        <div class="bg-white rounded-[32px] p-8 md:p-12 shadow-[0_4px_24px_rgba(0,0,0,0.04)]">
            <div class="flex flex-col md:flex-row gap-10 md:gap-16">
                <!-- Book Cover -->
                <div class="w-full md:w-[300px] flex-shrink-0">
                    <div class="aspect-[3/4] rounded-2xl bg-forest overflow-hidden shadow-xl">
                        @if ($book->gambar)
                            <img src="{{ asset('storage/' . $book->gambar) }}" alt="{{ $book->judul }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-cream text-6xl">📖</div>
                        @endif
                    </div>
                </div>

                <!-- Book Info -->
                <div class="flex-1">
                    <h1 class="text-4xl font-bold text-forest mb-8">{{ $book->judul }}</h1>
                    
                    <div class="space-y-4 mb-10">
                        <div class="flex items-start">
                            <span class="w-32 text-muted text-sm uppercase tracking-wider font-semibold">Penulis</span>
                            <span class="text-forest font-medium">: {{ $book->penulis }}</span>
                        </div>
                        <div class="flex items-start">
                            <span class="w-32 text-muted text-sm uppercase tracking-wider font-semibold">Kategori</span>
                            <span class="text-forest font-medium">: {{ $book->category->nama_kategori ?? '-' }}</span>
                        </div>
                        <div class="flex items-start">
                            <span class="w-32 text-muted text-sm uppercase tracking-wider font-semibold">Tahun Terbit</span>
                            <span class="text-forest font-medium">: {{ $book->tahun_terbit }}</span>
                        </div>
                        <div class="flex items-start">
                            <span class="w-32 text-muted text-sm uppercase tracking-wider font-semibold">Stok</span>
                            <span class="text-forest font-medium">: {{ $book->stok }}</span>
                        </div>
                    </div>

                    <div class="mt-12">
                        <h2 class="text-xl font-bold text-forest mb-4">Deskripsi</h2>
                        <div class="bg-background rounded-2xl p-6 text-muted leading-relaxed">
                            {{ $book->deskripsi ?: 'Tidak ada deskripsi untuk buku ini.' }}
                        </div>
                    </div>

                    <div class="mt-10">
                        @if($book->stok > 0)
                            <button class="w-full bg-forest text-cream py-4 rounded-xl font-bold flex items-center justify-center gap-3 hover:bg-sage transition-colors shadow-lg shadow-forest/20">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M11 2a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1V2zM5 2a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V2zm-4 0a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2z"/>
                                </svg>
                                Pinjam Buku
                            </button>
                        @else
                            <button disabled class="w-full bg-line text-muted py-4 rounded-xl font-bold cursor-not-allowed">
                                Stok Habis
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="p-8 text-center text-xs text-muted">
        &copy; {{ date('Y') }} SiPena · Sistem Informasi Perpustakaan
    </footer>
</body>
</html>
