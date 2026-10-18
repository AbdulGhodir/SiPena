<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - SiPena</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = { theme: { extend: {
        colors: { forest:'#173F35', sage:'#52796F', cream:'#F4E8CD',
          background:'#FAF9F4', text:'#193F37', muted:'#81908B',
          line:'#EDEDE7', danger:'#D94B4B', success:'#4B9E73' },
        fontFamily: { sans:['Arial','Helvetica','sans-serif'] }
      }}};
    </script>
</head>

<body class="min-h-screen bg-background font-sans text-text">

    <!-- NAVBAR -->
    <header class="navbar flex h-[72px] items-center justify-between gap-5 bg-background px-[30px]">
        <a href="{{ url('/member/dashboard') }}" class="no-underline text-inherit brand flex items-center gap-[11px] text-[23px] font-extrabold text-forest">
            <span class="brand-icon grid h-10 w-[38px] place-items-center rounded-[11px] bg-forest text-[23px] text-cream">📖</span>
            <span>SiPena</span>
        </a>

        <nav class="nav-links flex items-center gap-3">
            <a href="{{ url('/member/dashboard') }}" class="px-4 py-2 rounded-lg hover:bg-cream transition-colors">Beranda</a>
            <a href="{{ url('/member/riwayat') }}" class="px-4 py-2 rounded-lg hover:bg-cream transition-colors">Riwayat</a>
            <a href="{{ url('/member/profil') }}" class="active bg-forest text-cream px-4 py-2 rounded-lg shadow-sm">Profil</a>
            
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="rounded-[10px] border border-forest px-[15px] py-[10px] text-xs font-bold text-forest hover:bg-forest hover:text-white transition-all">
                    Keluar
                </button>
            </form>
        </nav>

        <div class="member-info flex items-center gap-[10px] text-[13px] font-semibold">
            <span class="avatar grid h-[38px] w-[38px] place-items-center rounded-full bg-sage text-xs text-white">
                {{ strtoupper(substr($user->nama ?? 'M', 0, 1)) }}
            </span>
            <span class="member-name">{{ $user->nama ?? 'Member' }}</span>
        </div>
    </header>

    <main class="max-w-[800px] mx-auto px-6 py-10">
        <h1 class="text-3xl font-bold text-forest mb-8">Pengaturan Profil</h1>

        @if(session('success'))
            <div class="mb-6 p-4 bg-success/10 border border-success/20 text-success rounded-xl text-sm font-medium">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-[32px] p-8 md:p-10 shadow-[0_4px_24px_rgba(0,0,0,0.04)]">
            <form action="{{ route('member.profile.update') }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="nama" class="block text-sm font-bold text-forest">Nama Lengkap</label>
                        <input type="text" name="nama" id="nama" value="{{ old('nama', $user->nama) }}" 
                            class="w-full px-4 py-3 rounded-xl border border-line bg-background focus:outline-none focus:border-sage transition-colors" required>
                        @error('nama') <p class="text-danger text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-bold text-forest">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" 
                            class="w-full px-4 py-3 rounded-xl border border-line bg-background focus:outline-none focus:border-sage transition-colors" required>
                        @error('email') <p class="text-danger text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="no_tlp" class="block text-sm font-bold text-forest">Nomor Telepon</label>
                        <input type="text" name="no_tlp" id="no_tlp" value="{{ old('no_tlp', $user->no_tlp) }}" 
                            class="w-full px-4 py-3 rounded-xl border border-line bg-background focus:outline-none focus:border-sage transition-colors">
                        @error('no_tlp') <p class="text-danger text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <hr class="my-8 border-line">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="password" class="block text-sm font-bold text-forest">Password Baru (Kosongkan jika tidak ingin diubah)</label>
                        <input type="password" name="password" id="password" 
                            class="w-full px-4 py-3 rounded-xl border border-line bg-background focus:outline-none focus:border-sage transition-colors">
                        @error('password') <p class="text-danger text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="password_confirmation" class="block text-sm font-bold text-forest">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" 
                            class="w-full px-4 py-3 rounded-xl border border-line bg-background focus:outline-none focus:border-sage transition-colors">
                    </div>
                </div>

                <div class="pt-6">
                    <button type="submit" class="w-full md:w-auto px-8 py-4 bg-forest text-cream font-bold rounded-xl hover:bg-sage transition-all shadow-lg shadow-forest/10">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </main>

    <footer class="p-8 text-center text-xs text-muted">
        &copy; {{ date('Y') }} SiPena · Sistem Informasi Perpustakaan
    </footer>
</body>
</html>
