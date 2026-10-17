
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SiPena</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            min-height: 100vh;
            background: #F4E8CD;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .login-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            max-width: 900px;
            width: 100%;
            min-height: 520px;
            background: #FFFFFF;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 15px 40px rgba(23, 63, 53, 0.12);
        }

        .login-info {
            background: #173F35;
            color: #FFFFFF;
            padding: 48px 38px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .logo {
            font-size: 30px;
            font-weight: bold;
            margin-bottom: 24px;
        }

        .logo span {
            color: #D9C69A;
        }

        .login-info h1 {
            font-size: 32px;
            line-height: 1.3;
            margin-bottom: 16px;
        }

        .login-info p {
            color: #E0E8E2;
            line-height: 1.8;
        }

        .login-form {
            padding: 55px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-form h2 {
            color: #173F35;
            font-size: 28px;
            margin-bottom: 10px;
        }

        .subtitle {
            color: #777;
            margin-bottom: 30px;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            color: #173F35;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 9px;
        }

        input {
            width: 100%;
            padding: 14px;
            border: 1px solid #D8DED8;
            border-radius: 10px;
            outline: none;
            font-size: 14px;
        }

        input:focus {
            border-color: #52796F;
            box-shadow: 0 0 0 3px rgba(82, 121, 111, 0.12);
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 24px;
            font-size: 13px;
            color: #555;
        }

        .remember input {
            width: auto;
        }

        .login-button {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 10px;
            background: #173F35;
            color: white;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
        }

        .login-button:hover {
            background: #52796F;
        }

        .error {
            color: #B42318;
            font-size: 13px;
            margin-top: 6px;
        }

        .footer {
            margin-top: 25px;
            text-align: center;
            font-size: 12px;
            color: #888;
        }
        .register-link {
            margin-top: 18px;
            text-align: center;
            font-size: 13px;
            color: #777;
        }

        .register-link a {
            color: #173F35;
            font-weight: bold;
            text-decoration: none;
        }

        .register-link a:hover {
            color: #52796F;
            text-decoration: underline;
        }

        @media (max-width: 650px) {
            .login-container {
                grid-template-columns: 1fr;
            }

            .login-info {
                padding: 30px;
            }

            .login-info h1 {
                font-size: 25px;
            }

            .login-form {
                padding: 35px 25px;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">

        <section class="login-info">
            <div class="logo">📚 Si<span>Pena</span></div>

            <h1>Selamat Datang di SiPena</h1>

            <p>
                Sistem Informasi Perpustakaan yang membantu
                pengelolaan buku dan peminjaman dengan lebih
                mudah, teratur, dan efisien.
            </p>
        </section>

        <section class="login-form">
            <h2>Masuk</h2>
            <p class="subtitle">Silakan masuk ke akun SiPena kamu.</p>

            @if ($errors->any())
                <div class="error" style="margin-bottom: 15px;">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}">
                @csrf

                <div class="form-group">
                    <label for="email">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Masukkan email"
                        required
                        autofocus
                    >
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Masukkan password"
                        required
                    >
                </div>

                <label class="remember">
                    <input type="checkbox" name="remember" value="1">
                    Ingat saya
                </label>

                <button type="submit" class="login-button">
                    Masuk ke SiPena
                </button>
            </form>

            <div class="register-link">
                Belum punya akun?
                <a href="{{ route('register') }}">Daftar sekarang</a>
            </div>

            <div class="footer">
                &copy; {{ date('Y') }} SiPena · Sistem Informasi Perpustakaan
            </div>
        </section>

    </div>
</body>
</html>
