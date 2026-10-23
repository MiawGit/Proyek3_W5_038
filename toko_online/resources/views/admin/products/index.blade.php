<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Produk - Toko Online</title>
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
            <h1>Kelola Produk</h1>
            <p>Halaman khusus admin &mdash; memperbarui stok produk.</p>
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

        @if ($products->isEmpty())
            <p class="empty-message">Belum ada produk tersedia.</p>
        @else
            <div class="card">
                <table>
                    <thead>
                        <tr>
                            <th>ID Barang</th>
                            <th>Nama Barang</th>
                            <th>Harga</th>
                            <th>Stok Saat Ini</th>
                            <th>Ubah Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>{{ $product->id_barang }}</td>
                                <td>{{ $product->nama_barang }}</td>
                                <td>Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                                <td class="{{ $product->stok > 0 ? 'stock-ok' : 'stock-empty' }}">
                                    {{ $product->stok }}
                                </td>
                                <td>
                                    <form
                                        action="{{ route('admin.products.stok.update', $product) }}"
                                        method="POST"
                                        class="role-form"
                                    >
                                        @csrf
                                        @method('PATCH')

                                        <input
                                            type="number"
                                            name="stok"
                                            class="role-select"
                                            style="width: 80px;"
                                            value="{{ $product->stok }}"
                                            min="0"
                                            required
                                        >

                                        <button type="submit" class="btn-save">Simpan</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

    </main>

    <footer class="footer">
        <p>&copy; {{ date('Y') }} Toko Online. Semua hak dilindungi.</p>
    </footer>

</body>
</html>
