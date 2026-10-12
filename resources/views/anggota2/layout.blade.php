<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Seblak Nashwa')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand navbar-dark bg-danger mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('katalog.index') }}">Seblak Nashwa</a>
            <div class="navbar-nav">
                <a class="nav-link" href="{{ route('katalog.index') }}">Katalog</a>
                <a class="nav-link" href="{{ route('kategori.index') }}">Kategori</a>
                <a class="nav-link" href="{{ route('menu.index') }}">Menu</a>
            </div>
        </div>
    </nav>
 
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
 
        @yield('content')
    </div>
</body>
</html>