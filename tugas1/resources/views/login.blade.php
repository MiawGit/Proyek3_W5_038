<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: "Segoe UI", Arial, sans-serif;
            background-color: #f3f4f6;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
        }
        .card {
            background: #ffffff;
            width: 100%;
            max-width: 400px;
            padding: 32px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        }
        h1 { font-size: 24px; margin-bottom: 4px; color: #111827; }
        .subtitle { color: #6b7280; font-size: 14px; margin-bottom: 20px; }
        .alert {
            background: #fee2e2;
            color: #b91c1c;
            border: 1px solid #fca5a5;
            padding: 10px 12px;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 16px;
        }
        label { display: block; font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 6px; }
        input {
            width: 100%;
            padding: 10px 12px;
            font-size: 14px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            margin-bottom: 16px;
        }
        input:focus { outline: 2px solid #6366f1; border-color: transparent; }
        button {
            width: 100%;
            padding: 11px;
            font-size: 15px;
            font-weight: 600;
            color: #ffffff;
            background: #4f46e5;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }
        button:hover { background: #4338ca; }
    </style>
</head>
<body>
    <div class="card">
        <h1>Login</h1>
        <p class="subtitle">Masuk untuk membuka dashboard</p>

        @if ($errors->any())
            <div class="alert">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="{{ old('username') }}" required autofocus>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Masuk</button>
        </form>
    </div>
</body>
</html>