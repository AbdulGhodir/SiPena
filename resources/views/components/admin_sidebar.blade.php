<aside class="w-64 min-h-screen bg-[#173F35] p-6 flex flex-col justify-between shrink-0">
    <div>
        <div class="flex items-center gap-3 mb-10">
            <x-logo size="w-6 h-6" />
            <h1 class="text-2xl font-bold text-[#F4E8CD]">SiPena</h1>
        </div>

        <nav class="flex flex-col gap-2 font-medium">
            <a href="{{ route('admin.dashboard') }}" class="px-4 py-3 rounded-xl {{ request()->routeIs('admin.dashboard') ? 'bg-[#52796F] text-[#F4E8CD]' : 'text-white/80 hover:bg-[#52796F]/40 hover:text-white' }} transition-colors">
                Dashboard
            </a>

            <a href="{{ route('admin.buku') }}" class="px-4 py-3 rounded-xl {{ request()->routeIs('admin.buku') ? 'bg-[#52796F] text-[#F4E8CD]' : 'text-white/80 hover:bg-[#52796F]/40 hover:text-white' }} transition-colors">
                Data Buku
            </a>

            <a href="{{ route('admin.kategori') }}" class="px-4 py-3 rounded-xl {{ request()->routeIs('admin.kategori') ? 'bg-[#52796F] text-[#F4E8CD]' : 'text-white/80 hover:bg-[#52796F]/40 hover:text-white' }} transition-colors">
                Kategori
            </a>

            <a href="{{ route('admin.anggota') }}" class="px-4 py-3 rounded-xl {{ request()->routeIs('admin.anggota') ? 'bg-[#52796F] text-[#F4E8CD]' : 'text-white/80 hover:bg-[#52796F]/40 hover:text-white' }} transition-colors">
                Anggota
            </a>

            <a href="{{ route('admin.peminjaman') }}" class="px-4 py-3 rounded-xl {{ request()->routeIs('admin.peminjaman') ? 'bg-[#52796F] text-[#F4E8CD]' : 'text-white/80 hover:bg-[#52796F]/40 hover:text-white' }} transition-colors">
                Peminjaman
            </a>

            <a href="{{ route('admin.pengguna') }}" class="px-4 py-3 rounded-xl {{ request()->routeIs('admin.pengguna') ? 'bg-[#52796F] text-[#F4E8CD]' : 'text-white/80 hover:bg-[#52796F]/40 hover:text-white' }} transition-colors">
                Pengguna
            </a>
        </nav>
    </div>
</aside>