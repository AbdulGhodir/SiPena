<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin | SiPena</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #F7F7F2;
            color: #26352F;
        }

        .layout {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 245px;
            background: #173F35;
            color: white;
            padding: 28px 18px;
            flex-shrink: 0;
        }

        .brand {
            font-size: 27px;
            font-weight: bold;
            margin: 0 12px 8px;
        }

        .subtitle {
            color: #D4E2D7;
            font-size: 12px;
            margin: 0 12px 38px;
        }

        .menu-title {
            font-size: 11px;
            color: #B8CFC3;
            margin: 24px 12px 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .menu a {
            display: block;
            color: #E9F0EB;
            text-decoration: none;
            padding: 13px 12px;
            margin-bottom: 6px;
            border-radius: 8px;
            font-size: 14px;
        }

        .menu a.active,
        .menu a:hover {
            background: #52796F;
            color: white;
        }

        .logout {
            margin-top: 35px;
        }

        .logout button {
            width: 100%;
            padding: 12px;
            border: 1px solid #A7C0B4;
            border-radius: 8px;
            background: transparent;
            color: white;
            cursor: pointer;
            font-size: 14px;
        }

        .main {
            flex: 1;
            min-width: 0;
            padding: 32px;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            margin-bottom: 30px;
        }

        .topbar h1 {
            font-size: 27px;
            color: #173F35;
            margin-bottom: 8px;
        }

        .topbar p {
            color: #78837C;
            font-size: 14px;
        }

        .admin-label {
            background: #E4EDE5;
            color: #173F35;
            padding: 10px 15px;
            border-radius: 25px;
            font-size: 13px;
            white-space: nowrap;
        }

        .welcome {
            background: #173F35;
            color: white;
            padding: 27px;
            border-radius: 14px;
            margin-bottom: 25px;
        }

        .welcome h2 {
            font-size: 21px;
            margin-bottom: 10px;
        }

        .welcome p {
            color: #E0E9E2;
            font-size: 14px;
            line-height: 1.6;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 18px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border: 1px solid #E7EAE3;
            padding: 22px;
            border-radius: 12px;
        }

        .stat-card .label {
            font-size: 13px;
            color: #78837C;
            margin-bottom: 15px;
        }

        .stat-card .number {
            color: #173F35;
            font-size: 29px;
            font-weight: bold;
        }

        .table-card {
            background: white;
            padding: 24px;
            border-radius: 12px;
            border: 1px solid #E7EAE3;
            overflow-x: auto;
        }

        .table-heading {
            font-size: 18px;
            color: #173F35;
            margin-bottom: 22px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 550px;
        }

        th, td {
            padding: 15px 12px;
            text-align: left;
            border-bottom: 1px solid #EDF0EA;
            font-size: 13px;
        }

        th {
            color: #68756D;
            background: #F7F8F4;
        }

        td {
            color: #435148;
        }

        .status {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 20px;
            background: #E4EDE5;
            color: #173F35;
            font-size: 12px;
        }

        .empty {
            text-align: center;
            color: #78837C;
            padding: 28px;
        }

        @media (max-width: 1050px) {
            .stats {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 650px) {
            .layout {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
            }

            .main {
                padding: 20px 14px;
            }

            .topbar {
                align-items: flex-start;
                flex-direction: column;
            }

            .stats {
                grid-template-columns: 1fr 1fr;
                gap: 10px;
            }

            .stat-card {
                padding: 15px;
            }

            .stat-card .number {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
<div class="layout">

    <aside class="sidebar">
        <div class="brand">SiPena.</div>
        <div class="subtitle">Sistem Informasi Perpustakaan</div>

        <div class="menu">
            <div class="menu-title">Menu Utama</div>
            <a href="{{ route('admin.dashboard') }}" class="active">
                Dashboard
            </a>
            <a href="#">Kelola Buku</a>
            <a href="#">Kategori Buku</a>
            <a href="#">Data Anggota</a>
            <a href="#">Peminjaman & Pengembalian</a>

            <div class="menu-title">Akun</div>
            <a href="#">Profil Admin</a>
        </div>

        <form action="{{ route('logout') }}" method="POST" class="logout">
            @csrf
            <button type="submit">Keluar dari Akun</button>
        </form>
    </aside>

    <main class="main">
        <div class="topbar">
            <div>
                <h1>Dashboard Admin</h1>
                <p>Kelola informasi dan aktivitas perpustakaan.</p>
            </div>
            <div class="admin-label">
                Administrator
            </div>
        </div>

        <section class="welcome">
            <h2>Selamat datang, {{ auth()->user()->nama }}!</h2>
            <p>
                Pantau data koleksi buku, anggota, dan aktivitas
                peminjaman perpustakaan melalui halaman ini.
            </p>
        </section>

        <section class="stats">
            <div class="stat-card">
                <div class="label">Total Buku</div>
                <div class="number">{{ $totalBuku }}</div>
            </div>

            <div class="stat-card">
                <div class="label">Kategori Buku</div>
                <div class="number">{{ $totalKategori }}</div>
            </div>

            <div class="stat-card">
                <div class="label">Total Anggota</div>
                <div class="number">{{ $totalAnggota }}</div>
            </div>

            <div class="stat-card">
                <div class="label">Total Peminjaman</div>
                <div class="number">{{ $totalPeminjaman }}</div>
            </div>
        </section>

        <section class="table-card">
            <h2 class="table-heading">Peminjaman Terbaru</h2>

            <table>
                <thead>
                    <tr>
                        <th>Anggota</th>
                        <th>Judul Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($peminjamanTerbaru as $peminjaman)
                        <tr>
                            <td>
                                {{ $peminjaman->user->nama ?? 'Pengguna tidak ditemukan' }}
                            </td>
                            <td>
                                {{ $peminjaman->book->judul ?? 'Buku tidak ditemukan' }}
                            </td>
                            <td>
                                {{ $peminjaman->tanggal_pinjam
                                    ? \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d/m/Y')
                                    : '-' }}
                            </td>
                            <td>
                                <span class="status">
                                    {{ ucfirst($peminjaman->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="empty">
                                Belum ada data peminjaman.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </section>
    </main>
</div>
</body>
</html>
