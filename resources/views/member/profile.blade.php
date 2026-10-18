<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - SiPena</title>
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
                    <a href="{{ route('member.profile.index') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs font-semibold text-forest bg-cream/40 font-bold transition-colors">
                        <i data-lucide="user" class="w-4 h-4 text-forest"></i>
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

    <main class="max-w-3xl w-full mx-auto px-4 sm:px-6 py-8 flex-1">
        <div class="mb-6">
            <h1 class="text-2xl sm:text-3xl font-bold text-forest">Pengaturan Profil</h1>
            <p class="text-xs sm:text-sm text-sage mt-1">Kelola informasi data diri dan kata sandi akun kamu</p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200/70 p-6 sm:p-8 shadow-xs">
            <form action="{{ route('member.profile.update') }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <h2 class="text-xs font-bold text-forest uppercase tracking-wider mb-4">Informasi Akun</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="space-y-1.5">
                            <label for="nama" class="block text-xs font-semibold text-gray-700">Nama Lengkap</label>
                            <input type="text" name="nama" id="nama" value="{{ old('nama', $user->nama) }}" 
                                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-[#FCFAF5] focus:bg-white focus:outline-none focus:border-forest text-sm text-gray-800 transition-all" required>
                            @error('nama') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-1.5">
                            <label for="email" class="block text-xs font-semibold text-gray-700">Alamat Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" 
                                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-[#FCFAF5] focus:bg-white focus:outline-none focus:border-forest text-sm text-gray-800 transition-all" required>
                            @error('email') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-1.5 md:col-span-2">
                            <label for="no_tlp" class="block text-xs font-semibold text-gray-700">Nomor Telepon / WhatsApp</label>
                            <input type="text" name="no_tlp" id="no_tlp" value="{{ old('no_tlp', $user->no_tlp) }}" 
                                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-[#FCFAF5] focus:bg-white focus:outline-none focus:border-forest text-sm text-gray-800 transition-all" placeholder="Contoh: 081234567890">
                            @error('no_tlp') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <hr class="border-gray-100">

                <div>
                    <h2 class="text-xs font-bold text-forest uppercase tracking-wider mb-4">Ganti Kata Sandi (Opsional)</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="space-y-1.5">
                            <label for="password" class="block text-xs font-semibold text-gray-700">Password Baru</label>
                            <input type="password" name="password" id="password" placeholder="Minimal 8 karakter"
                                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-[#FCFAF5] focus:bg-white focus:outline-none focus:border-forest text-sm text-gray-800 transition-all">
                            @error('password') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-1.5">
                            <label for="password_confirmation" class="block text-xs font-semibold text-gray-700">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Ulangi password baru"
                                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-[#FCFAF5] focus:bg-white focus:outline-none focus:border-forest text-sm text-gray-800 transition-all">
                        </div>
                    </div>
                </div>

                <div class="pt-4 flex justify-end">
                    <button type="submit" class="w-full sm:w-auto px-6 py-2.5 bg-forest text-cream font-bold text-xs sm:text-sm rounded-xl hover:bg-sage transition-all shadow-sm cursor-pointer">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
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
