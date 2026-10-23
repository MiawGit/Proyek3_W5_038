<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring Stok - Toko Online</title>
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

                @auth
                    @can('use-cart')
                        <a href="{{ route('keranjang.index') }}">Keranjang</a>
                        <a href="{{ route('pesanan.index') }}">Pesanan Saya</a>
                    @endcan

                    <a href="{{ route('staff.stok.index') }}">Monitoring Stok</a>

                    @can('manage-products')
                        <a href="{{ route('admin.products.index') }}">Kelola Produk</a>
                    @endcan

                    @can('manage-roles')
                        <a href="{{ route('admin.users.index') }}">Kelola Role</a>
                    @endcan

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-logout">Logout</button>
                    </form>
                @endauth
            </div>
        </div>
    </nav>

    <header class="hero">
        <div class="container">
            <h1>Monitoring Stok</h1>
            <p>Halaman khusus staff &mdash; melihat stok seluruh produk.</p>
        </div>
    </header>

    <main class="container main">

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
                            <th>Stok</th>
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
