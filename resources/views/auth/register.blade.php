
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Member - SiPena</title>

    <style>
        :root {
            --forest: #173F35;
            --sage: #52796F;
            --cream: #F4E8CD;
            --white: #FFFFFF;
            --background: #FAF9F4;
            --text: #193F37;
            --muted: #7B8984;
            --border: #E1E6E1;
            --danger: #D64545;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            min-height: 100vh;
            padding: 24px;
            background: var(--background);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .register-container {
            width: 100%;
            max-width: 940px;
            min-height: 590px;
            display: grid;
            grid-template-columns: 0.9fr 1.1fr;
            background: var(--white);
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 15px 45px rgba(23, 63, 53, 0.10);
        }

        .register-info {
            background: var(--forest);
            color: var(--white);
            padding: 45px 38px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 27px;
            font-weight: 800;
            margin-bottom: 45px;
        }

        .brand-icon {
            width: 48px;
            height: 48px;
            border-radius: 13px;
            background: var(--cream);
            color: var(--forest);
            display: grid;
            place-items: center;
            font-size: 26px;
        }

        .register-info h1 {
            font-size: 34px;
            line-height: 1.2;
            margin-bottom: 18px;
        }

        .register-info p {
            color: #D1DFD8;
            font-size: 14px;
            line-height: 1.9;
        }

        .quote {
            margin-top: 32px;
            padding: 17px;
            background: rgba(255,255,255,.08);
            border-left: 3px solid var(--cream);
            border-radius: 5px;
            color: var(--cream);
            font-size: 13px;
            line-height: 1.7;
        }

        .register-form {
            padding: 40px 45px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .register-form h2 {
            color: var(--forest);
            font-size: 28px;
            margin-bottom: 8px;
        }

        .subtitle {
            color: var(--muted);
            font-size: 14px;
            margin-bottom: 27px;
            line-height: 1.6;
        }

        .form-group {
            margin-bottom: 17px;
        }

        label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 13px 14px;
            border: 1px solid var(--border);
            border-radius: 10px;
            outline: none;
            font-size: 14px;
            color: var(--text);
            background: #FFFFFF;
            transition: .2s;
        }

        input:focus {
            border-color: var(--sage);
            box-shadow: 0 0 0 3px rgba(82, 121, 111, .12);
        }

        input::placeholder {
            color: #A4ACA8;
        }

        .error {
            color: var(--danger);
            font-size: 12px;
            margin-top: 6px;
        }

        .alert-error {
            padding: 12px;
            margin-bottom: 17px;
            background: #FFF1F1;
            border: 1px solid #F3D0D0;
            border-radius: 9px;
            color: var(--danger);
            font-size: 13px;
        }

        .register-button {
            width: 100%;
            border: none;
            border-radius: 10px;
            background: var(--forest);
            color: var(--cream);
            font-size: 14px;
            font-weight: 700;
            padding: 15px;
            cursor: pointer;
            margin-top: 5px;
            transition: .2s;
        }

        .register-button:hover {
            background: var(--sage);
        }

        .login-link {
            margin-top: 23px;
            text-align: center;
            color: var(--muted);
            font-size: 13px;
        }

        .login-link a {
            color: var(--forest);
            font-weight: 700;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .footer {
            text-align: center;
            margin-top: 24px;
            color: var(--muted);
            font-size: 11px;
        }

        @media (max-width: 700px) {
            body {
                padding: 12px;
            }

            .register-container {
                grid-template-columns: 1fr;
            }

            .register-info {
                padding: 27px;
            }

            .brand {
                margin-bottom: 22px;
            }

            .register-info h1 {
                font-size: 27px;
            }

            .quote {
                margin-top: 20px;
            }

            .register-form {
                padding: 30px 24px;
            }
        }
    </style>
</head>

<body>

    <main class="register-container">

        <section class="register-info">
            <div class="brand">
                <span class="brand-icon">📖</span>
                <span>SiPena</span>
            </div>

            <h1>Mulai Perjalanan Literasimu!</h1>

            <p>
                Buat akun SiPena dan temukan berbagai buku
                menarik untuk menemani perjalanan belajarmu.
            </p>

            <div class="quote">
                "Jelajahi Ilmu, Bangun Masa Depan."
            </div>
        </section>

        <section class="register-form">
            <h2>Buat Akun</h2>

            <p class="subtitle">
                Lengkapi data berikut untuk menjadi member SiPena.
            </p>

            @if ($errors->any())
                <div class="alert-error">
                    Periksa kembali data yang kamu masukkan.
                </div>
            @endif

            <form action="{{ route('register.post') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="nama">Nama lengkap</label>
                    <input
                        type="text"
                        id="nama"
                        name="nama"
                        value="{{ old('nama') }}"
                        placeholder="Masukkan nama lengkap"
                        autocomplete="name"
                        required
                    >

                    @error('nama')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="nama@email.com"
                        autocomplete="email"
                        required
                    >

                    @error('email')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="no_tlp">Nomor telepon</label>
                    <input
                        type="tel"
                        id="no_tlp"
                        name="no_tlp"
                        value="{{ old('no_tlp') }}"
                        placeholder="Contoh: 081234567890"
                        autocomplete="tel"
                        required
                    >

                    @error('no_tlp')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Minimal 8 karakter"
                        autocomplete="new-password"
                        minlength="8"
                        required
                    >

                    @error('password')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">
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
                    >
                </div>

                <button type="submit" class="register-button">
                    Daftar Sekarang
                </button>
            </form>

            <p class="login-link">
                Sudah punya akun?
                <a href="{{ route('login') }}">Masuk di sini</a>
            </p>

            <p class="footer">
                &copy; {{ date('Y') }} SiPena
            </p>
        </section>

    </main>

</body>
</html>
