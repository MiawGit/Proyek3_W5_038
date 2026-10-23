<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Role - Toko Online</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>

    <nav class="navbar">
        <div class="nav-container">
            <a href="{{ route('produk.index') }}" class="brand">
                Toko Online
            </a>

            <div class="nav-links">
                <a href="{{ route('produk.index') }}">Katalog</a>
                <a href="{{ route('staff.stok.index') }}">Monitoring Stok</a>
                <a href="{{ route('admin.products.index') }}">Kelola Produk</a>
                <a href="{{ route('admin.users.index') }}">Kelola Role</a>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-logout">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <header class="hero">
        <div class="container">
            <h1>Kelola Role Pengguna</h1>
            <p>Halaman khusus admin &mdash; hanya bisa menukar role customer dan staff.</p>
        </div>
    </header>

    <main class="container main">

        @if (session('status'))
            <div class="alert-success">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert-error">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role Saat Ini</th>
                        <th>Ubah Role</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        @php
                            $tidakBisaDiubah = $user->is(auth()->user()) || $user->role === 'admin';
                        @endphp
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge badge-{{ $user->role }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td>
                                @if ($tidakBisaDiubah)
                                    <span class="note">
                                        {{ $user->is(auth()->user()) ? 'Akun sendiri' : 'Akun admin' }} tidak dapat diubah
                                    </span>
                                @else
                                    <form
                                        action="{{ route('admin.users.role.update', $user) }}"
                                        method="POST"
                                        class="role-form"
                                    >
                                        @csrf
                                        @method('PATCH')

                                        <select name="role" class="role-select">
                                            <option value="customer" @selected($user->role === 'customer')>customer</option>
                                            <option value="staff" @selected($user->role === 'staff')>staff</option>
                                        </select>

                                        <button type="submit" class="btn-save">Simpan</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </main>

    <footer class="footer">
        <p>&copy; {{ date('Y') }} Toko Online. Semua hak dilindungi.</p>
    </footer>

</body>
</html>
