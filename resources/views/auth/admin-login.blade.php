<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Seblak Nashwa</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f8f1e7;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-card {
            background: white;
            width: 100%;
            max-width: 420px;
            padding: 36px;
            border-radius: 18px;
            box-shadow: 0 10px 35px rgba(76, 42, 24, 0.12);
        }

        .brand {
            text-align: center;
            margin-bottom: 28px;
        }

        .brand h1 {
            color: #7b3827;
            font-size: 28px;
            margin-bottom: 8px;
        }

        .brand p {
            color: #7c7169;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            color: #4d3025;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #dfd3c8;
            border-radius: 9px;
            font-size: 15px;
        }

        input:focus {
            outline: 2px solid #a85b3d;
            border-color: transparent;
        }

        .error {
            color: #b42318;
            background: #fff0ee;
            padding: 11px;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 18px;
        }

        .login-button {
            width: 100%;
            padding: 13px;
            background: #7b3827;
            color: white;
            border: none;
            border-radius: 9px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        .login-button:hover {
            background: #61291d;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 22px;
            color: #7b3827;
            text-decoration: none;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="login-card">
        <div class="brand">
            <h1>Seblak Nashwa</h1>
            <p>Silakan login untuk masuk ke panel admin.</p>
        </div>

        @if ($errors->any())
            <div class="error">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="email">Email Admin</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Masukkan email admin"
                    autocomplete="username"
                    required
                >
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Masukkan password"
                    autocomplete="current-password"
                    required
                >
            </div>

            <button type="submit" class="login-button">
                Login sebagai Admin
            </button>
        </form>

        <a href="{{ route('home') }}" class="back-link">
            &larr; Kembali ke halaman utama
        </a>
    </div>
</body>
</html>
