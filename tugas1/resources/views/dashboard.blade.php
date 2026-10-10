<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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
            max-width: 480px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }
        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 24px;
            border-bottom: 1px solid #e5e7eb;
        }
        h1 { font-size: 20px; color: #111827; }
        .card-body { padding: 24px; }
        .welcome { font-size: 18px; font-weight: 600; color: #111827; margin-bottom: 8px; }
        .note { color: #6b7280; font-size: 14px; margin-bottom: 12px; }
        .username { font-size: 14px; color: #374151; }
        .username strong { color: #111827; }
        form { display: inline; }
        button {
            padding: 8px 16px;
            font-size: 14px;
            font-weight: 600;
            color: #ffffff;
            background: #dc2626;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }
        button:hover { background: #b91c1c; }
    </style>
</head>
<body>
    <div class="card">
        <div class="card-header">
            <h1>Dashboard</h1>
            <form method="POST" action="{{ url('/logout') }}">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </div>
        <div class="card-body">
            <p class="welcome">Selamat datang, {{ $user->nama_lengkap }}!</p>
            <p class="note">Halaman ini hanya bisa dibuka setelah login.</p>
            <p class="username">Username: <strong>{{ $user->username }}</strong></p>
        </div>
    </div>
</body>
</html>