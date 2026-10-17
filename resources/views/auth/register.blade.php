
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Member - SiPena</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        forest: '#173F35',
                        sage: '#52796F',
                        cream: '#F4E8CD',
                        white: '#FFFFFF',
                        background: '#FAF9F4',
                        text: '#193F37',
                        muted: '#7B8984',
                        border: '#E1E6E1',
                        danger: '#D64545',
                    },
                    fontFamily: {
                        sans: ['Arial', 'Helvetica', 'sans-serif'],
                    },
                },
            },
        };
    </script>
</head>

<body class="box-border flex min-h-screen items-center justify-center bg-background p-6 font-sans max-[700px]:p-3">

    <main class="grid min-h-[590px] w-full max-w-[940px] grid-cols-[0.9fr_1.1fr] overflow-hidden rounded-[24px] bg-white shadow-[0_15px_45px_rgba(23,63,53,0.10)] max-[700px]:grid-cols-1">

        <section class="flex flex-col justify-center bg-forest px-[38px] py-[45px] text-white max-[700px]:p-[27px]">

            <div class="mb-[45px] flex items-center gap-3 text-[27px] font-extrabold max-[700px]:mb-[22px]">
                <span class="grid h-12 w-12 shrink-0 place-items-center rounded-[13px] bg-cream text-[26px] text-forest">
                    📖
                </span>
                <span>SiPena</span>
            </div>

            <h1 class="mb-[18px] text-[34px] font-bold leading-[1.2] max-[700px]:text-[27px]">
                Mulai Perjalanan Literasimu!
            </h1>

            <p class="text-sm leading-[1.9] text-[#D1DFD8]">
                Buat akun SiPena dan temukan berbagai buku
                menarik untuk menemani perjalanan belajarmu.
            </p>

            <div class="mt-8 rounded-[5px] border-l-[3px] border-cream bg-[rgba(255,255,255,0.08)] p-[17px] text-[13px] leading-[1.7] text-cream max-[700px]:mt-5">
                "Jelajahi Ilmu, Bangun Masa Depan."
            </div>

        </section>

        <section class="flex flex-col justify-center px-[45px] py-10 max-[700px]:px-6 max-[700px]:py-[30px]">

            <h2 class="mb-2 text-[28px] font-bold text-forest">
                Buat Akun
            </h2>

            <p class="mb-[27px] text-sm leading-[1.6] text-muted">
                Lengkapi data berikut untuk menjadi member SiPena.
            </p>

            @if ($errors->any())
                <div
                    class="mb-[17px] rounded-[9px] border border-[#F3D0D0] bg-[#FFF1F1] p-3 text-[13px] text-danger"
                    role="alert"
                >
                    Periksa kembali data yang kamu masukkan.
                </div>
            @endif

            <form action="{{ route('register.post') }}" method="POST">
                @csrf

                <div class="mb-[17px]">
                    <label for="nama" class="mb-2 block text-[13px] font-bold text-text">
                        Nama lengkap
                    </label>

                    <input
                        type="text"
                        id="nama"
                        name="nama"
                        value="{{ old('nama') }}"
                        placeholder="Masukkan nama lengkap"
                        autocomplete="name"
                        required
                        class="box-border w-full rounded-[10px] border border-border bg-white p-[13px_14px] text-sm text-text outline-none transition-[border-color,box-shadow] duration-200 placeholder:text-[#A4ACA8] focus:border-sage focus:shadow-[0_0_0_3px_rgba(82,121,111,0.12)]"
                    >

                    @error('nama')
                        <p class="mt-[6px] text-xs text-danger">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="mb-[17px]">
                    <label for="email" class="mb-2 block text-[13px] font-bold text-text">
                        Email
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="nama@email.com"
                        autocomplete="email"
                        required
                        class="box-border w-full rounded-[10px] border border-border bg-white p-[13px_14px] text-sm text-text outline-none transition-[border-color,box-shadow] duration-200 placeholder:text-[#A4ACA8] focus:border-sage focus:shadow-[0_0_0_3px_rgba(82,121,111,0.12)]"
                    >

                    @error('email')
                        <p class="mt-[6px] text-xs text-danger">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="mb-[17px]">
                    <label for="no_tlp" class="mb-2 block text-[13px] font-bold text-text">
                        Nomor telepon
                    </label>

                    <input
                        type="tel"
                        id="no_tlp"
                        name="no_tlp"
                        value="{{ old('no_tlp') }}"
                        placeholder="Contoh: 081234567890"
                        autocomplete="tel"
                        required
                        class="box-border w-full rounded-[10px] border border-border bg-white p-[13px_14px] text-sm text-text outline-none transition-[border-color,box-shadow] duration-200 placeholder:text-[#A4ACA8] focus:border-sage focus:shadow-[0_0_0_3px_rgba(82,121,111,0.12)]"
                    >

                    @error('no_tlp')
                        <p class="mt-[6px] text-xs text-danger">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="mb-[17px]">
                    <label for="password" class="mb-2 block text-[13px] font-bold text-text">
                        Password
                    </label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Minimal 8 karakter"
                        autocomplete="new-password"
                        minlength="8"
                        required
                        class="box-border w-full rounded-[10px] border border-border bg-white p-[13px_14px] text-sm text-text outline-none transition-[border-color,box-shadow] duration-200 placeholder:text-[#A4ACA8] focus:border-sage focus:shadow-[0_0_0_3px_rgba(82,121,111,0.12)]"
                    >

                    @error('password')
                        <p class="mt-[6px] text-xs text-danger">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="mb-[17px]">
                    <label for="password_confirmation" class="mb-2 block text-[13px] font-bold text-text">
                        Konfirmasi password
                    </label>

                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="Ulangi password"
                        autocomplete="new-password"
                        minlength="8"
                        required
                        class="box-border w-full rounded-[10px] border border-border bg-white p-[13px_14px] text-sm text-text outline-none transition-[border-color,box-shadow] duration-200 placeholder:text-[#A4ACA8] focus:border-sage focus:shadow-[0_0_0_3px_rgba(82,121,111,0.12)]"
                    >
                </div>

                <button
                    type="submit"
                    class="mt-[5px] w-full cursor-pointer rounded-[10px] border-0 bg-forest p-[15px] text-sm font-bold text-cream transition-colors duration-200 hover:bg-sage"
                >
                    Daftar Sekarang
                </button>
            </form>

            <p class="mt-[23px] text-center text-[13px] text-muted">
                Sudah punya akun?
                <a
                    href="{{ route('login') }}"
                    class="font-bold text-forest no-underline hover:underline"
                >
                    Masuk di sini
                </a>
            </p>

            <p class="mt-6 text-center text-[11px] text-muted">
                &copy; {{ date('Y') }} SiPena
            </p>

        </section>

    </main>

</body>
</html>
