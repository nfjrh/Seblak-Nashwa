<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin') | Seblak Nashwa</title>

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body { font-family: Arial, sans-serif; background: #f8f4ef; color: #3e2720; }

        .sidebar {
            width: 250px; height: 100vh; position: fixed; top: 0; left: 0;
            background: #492b20; color: white; padding: 30px 20px; overflow-y: auto;
        }
        .brand { font-size: 21px; margin-bottom: 40px; }
        .brand span { color: #e8b77a; }
        .sidebar p { font-size: 12px; color: #c9b8ad; margin: 20px 12px 10px; text-transform: uppercase; }
        .sidebar a, .sidebar .logout-btn {
            display: block; width: 100%; padding: 13px 14px; color: #f5eae2; text-decoration: none;
            border-radius: 8px; margin-bottom: 7px; background: none; border: none; text-align: left;
            font-size: 16px; font-family: inherit; cursor: pointer;
        }
        .sidebar a:hover, .sidebar a.active, .sidebar .logout-btn:hover { background: #80513b; }
        .sidebar a.soon { opacity: .55; }

        .main { margin-left: 250px; padding: 32px; }
        .topbar { display: flex; justify-content: space-between; align-items: center; gap: 15px; margin-bottom: 30px; }
        .topbar h1 { font-size: 28px; margin-bottom: 8px; }
        .topbar p { color: #88756a; font-size: 14px; }
        .admin-label { background: white; padding: 12px 18px; border-radius: 10px; font-weight: bold; }

        .stats { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 20px; }
        .stat-card { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(60,35,25,.05); border: 1px solid #eee4dc; }
        .stat-card .label { color: #88756a; font-size: 14px; margin-bottom: 15px; }
        .stat-card h2 { font-size: 30px; margin-bottom: 8px; }
        .stat-card small { color: #8b786d; }

        .panel { margin-top: 28px; background: white; padding: 25px; border-radius: 12px; border: 1px solid #eee4dc; }
        .panel:first-child { margin-top: 0; }
        .panel h2 { font-size: 19px; margin-bottom: 20px; }

        table { width: 100%; border-collapse: collapse; }
        th, td { text-align: left; padding: 15px 10px; border-bottom: 1px solid #eee7e1; font-size: 14px; }
        th { color: #806c60; background: #fcfaf8; }
        .empty { text-align: center; color: #88756a; padding: 28px 10px; }

        /* ===== Kelas bantuan untuk halaman CRUD anggota lain ===== */
        .page-actions { display: flex; justify-content: space-between; align-items: center; gap: 12px; margin-bottom: 20px; flex-wrap: wrap; }
        .btn { display: inline-block; padding: 10px 18px; border-radius: 8px; border: 1px solid #e3d5c8; background: #fff; color: #3e2720; font-size: 14px; font-weight: bold; text-decoration: none; cursor: pointer; font-family: inherit; }
        .btn:hover { background: #f8f4ef; }
        .btn-primary { background: #c8402a; border-color: #c8402a; color: #fff; }
        .btn-primary:hover { background: #a83320; }
        .btn-danger { background: #fff; border-color: #e7b5ad; color: #b42318; }
        .btn-danger:hover { background: #fdeae4; }
        .btn-sm { padding: 7px 12px; font-size: 13px; }

        .field { margin-bottom: 18px; }
        .field label { display: block; font-weight: bold; font-size: 14px; margin-bottom: 8px; }
        .field input, .field select, .field textarea {
            width: 100%; padding: 12px 14px; border: 1px solid #e3d5c8; border-radius: 8px;
            font: inherit; font-size: 14px; background: #fffaf3; color: #3e2720;
        }
        .field input:focus, .field select:focus, .field textarea:focus { outline: none; border-color: #c8402a; }
        .field-error { color: #b42318; font-size: 13px; margin-top: 6px; }

        .alert { padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; font-weight: bold; }
        .alert-success { background: #e9f6ec; color: #1d6b34; border: 1px solid #cfe9d6; }
        .alert-error { background: #fdeae4; color: #b42318; border: 1px solid #f3c9c0; }

        .badge { display: inline-block; padding: 4px 12px; border-radius: 999px; font-size: 12px; font-weight: bold; background: #efe7df; color: #5a3b2e; }
        .badge-baru { background: #fff1d6; color: #8a5a00; }
        .badge-diproses { background: #dbeafe; color: #1e40af; }
        .badge-siap { background: #dcfce7; color: #166534; }
        .badge-selesai { background: #e5e7eb; color: #374151; }

        @media (max-width: 800px) {
            .sidebar { position: relative; width: 100%; height: auto; }
            .main { margin-left: 0; padding: 20px; }
            .stats { grid-template-columns: 1fr; }
            .topbar { align-items: flex-start; flex-direction: column; }
            .panel { overflow-x: auto; }
            table { min-width: 450px; }
        }
    </style>
    @stack('styles')
</head>

<body>
@php
    // Setiap menu boleh punya beberapa kemungkinan nama route. Yang pertama ditemukan dipakai.
    // Kalau tidak ada yang ditemukan, tautan tampil redup dan belum bisa diklik.
    $menuAdmin = [
        ['label' => '🍜 Menu Seblak', 'routes' => ['admin.menu.index', 'menu.index'],         'aktif' => ['admin.menu.*', 'menu.*']],
        ['label' => '📂 Kategori',    'routes' => ['admin.kategori.index', 'kategori.index'], 'aktif' => ['admin.kategori.*', 'kategori.*']],
        ['label' => '🌶️ Topping',     'routes' => ['admin.topping.index', 'topping.index'],   'aktif' => ['admin.topping.*', 'topping.*']],
        ['label' => '🔥 Level Pedas', 'routes' => ['admin.level.index', 'level.index'],       'aktif' => ['admin.level.*', 'level.*']],
        ['label' => '🛒 Pesanan',     'routes' => ['admin.pesanan.index', 'pesanan.index'],   'aktif' => ['admin.pesanan.*', 'pesanan.*']],
    ];
@endphp

    <aside class="sidebar">
        <div class="brand">🍲 Seblak <span>Nashwa</span></div>

        <p>Menu Utama</p>
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            🏠 Dashboard
        </a>

        <p>Manajemen</p>
        @foreach ($menuAdmin as $item)
            @php $tujuan = collect($item['routes'])->first(fn ($r) => Route::has($r)); @endphp
            @if ($tujuan)
                <a href="{{ route($tujuan) }}" class="{{ request()->routeIs(...$item['aktif']) ? 'active' : '' }}">{{ $item['label'] }}</a>
            @else
                <a href="#" class="soon" title="Halaman ini belum dibuat">{{ $item['label'] }}</a>
            @endif
        @endforeach

        <p>Lainnya</p>
        <a href="{{ route('home') }}">🌐 Lihat Website</a>

        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">🚪 Keluar</button>
        </form>
    </aside>

    <main class="main">
        <header class="topbar">
            <div>
                <h1>@yield('heading', 'Dashboard Admin')</h1>
                <p>@yield('subheading', 'Panel pengelolaan Seblak Nashwa.')</p>
            </div>

            <div class="admin-label">
                👤 {{ Auth::user()->nama ?? 'Administrator' }}
            </div>
        </header>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>