
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SiPena</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        forest: '#173F35',
                        sage: '#52796F',
                        cream: '#F4E8CD',
                        sand: '#D9C69A',
                    },
                    fontFamily: {
                        sans: ['Arial', 'sans-serif'],
                    },
                },
            },
        };
    </script>
</head>

<body class="box-border flex min-h-screen items-center justify-center bg-cream p-6 font-sans">

    <div class="grid min-h-[520px] w-full max-w-[900px] grid-cols-1 overflow-hidden rounded-[24px] bg-white shadow-[0_15px_40px_rgba(23,63,53,0.12)] min-[651px]:grid-cols-2">

        <!-- Informasi SiPena -->
        <section class="flex flex-col justify-center bg-forest px-[30px] py-[30px] text-white min-[651px]:px-[38px] min-[651px]:py-12">

            <div class="mb-6 text-[30px] font-bold min-[651px]:mb-6">
                📚 Si<span class="text-sand">Pena</span>
            </div>

            <h1 class="mb-4 text-[25px] font-bold leading-[1.3] min-[651px]:text-[32px]">
                Selamat Datang di SiPena
            </h1>

            <p class="leading-[1.8] text-[#E0E8E2]">
                Sistem Informasi Perpustakaan yang membantu
                pengelolaan buku dan peminjaman dengan lebih
                mudah, teratur, dan efisien.
            </p>

        </section>

        <!-- Form Login -->
        <section class="flex flex-col justify-center px-[25px] py-[35px] min-[651px]:px-[40px] min-[651px]:py-[55px]">

            <h2 class="mb-[10px] text-[28px] font-bold text-forest">
                Masuk
            </h2>

            <p class="mb-[30px] text-sm text-[#777]">
                Silakan masuk ke akun SiPena kamu.
            </p>

            @if ($errors->any())
                <div class="mb-[15px] text-[13px] text-[#B42318]" role="alert">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ url('/login') }}">
                @csrf

                <!-- Email -->
                <div class="mb-5">
                    <label
                        for="email"
                        class="mb-[9px] block text-sm font-bold text-forest"
                    >
                        Email
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Masukkan email"
                        autocomplete="username"
                        required
                        autofocus
                        class="box-border w-full rounded-[10px] border border-[#D8DED8] bg-white p-[14px] text-sm outline-none focus:border-sage focus:ring-[3px] focus:ring-sage/10"
                    >
                </div>

                <!-- Password -->
                <div class="mb-5">
                    <label
                        for="password"
                        class="mb-[9px] block text-sm font-bold text-forest"
                    >
                        Password
                    </label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Masukkan password"
                        autocomplete="current-password"
                        required
                        class="box-border w-full rounded-[10px] border border-[#D8DED8] bg-white p-[14px] text-sm outline-none focus:border-sage focus:ring-[3px] focus:ring-sage/10"
                    >
                </div>

                <!-- Ingat Saya -->
                <label class="mb-6 flex items-center gap-2 text-[13px] text-[#555]">
                    <input
                        type="checkbox"
                        name="remember"
                        value="1"
                        class="w-auto accent-forest"
                    >
                    Ingat saya
                </label>

                <!-- Tombol Login -->
                <button
                    type="submit"
                    class="w-full cursor-pointer rounded-[10px] border-0 bg-forest p-[14px] text-[15px] font-bold text-white transition-colors hover:bg-sage"
                >
                    Masuk ke SiPena
                </button>
            </form>

            <!-- Link Register -->
            <div class="mt-[18px] text-center text-[13px] text-[#777]">
                Belum punya akun?
                <a
                    href="{{ route('register') }}"
                    class="font-bold text-forest no-underline hover:text-sage hover:underline"
                >
                    Daftar sekarang
                </a>
            </div>

            <!-- Footer -->
            <div class="mt-[25px] text-center text-xs text-[#888]">
                &copy; {{ date('Y') }} SiPena · Sistem Informasi Perpustakaan
            </div>

        </section>

    </div>

</body>
</html>
