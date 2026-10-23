<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Produk - Toko Online</title>
    <link rel="stylesheet" href="{{ asset('css/katalog.css') }}">
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

                    @can('adjust-stock')
                        <a href="{{ route('staff.stok.index') }}">Monitoring Stok</a>
                    @endcan

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
                @else
                    <a href="{{ route('login') }}">Login</a>
                    <a href="{{ route('register') }}">Daftar</a>
                @endauth
            </div>
        </div>
    </nav>

    <header class="hero">
        <div class="container">
            <h1>Katalog Produk</h1>
            <p>Temukan produk yang sesuai dengan kebutuhanmu.</p>
        </div>
    </header>

    <main class="container katalog">

        @php
            $gambarProdukDefault = [
                'BRG001' => asset('images/buku-tulis.jpg'),
                'BRG002' => asset('images/pulpen.jpg'),
                'BRG003' => asset('images/penggaris.jpg'),
                'BRG004' => asset('images/penghapus.jpg'),
                'BRG005' => asset('images/pensil.jpg'),
                'BRG006' => asset('images/rautan.jpg'),
                'BRG007' => asset('images/gunting.jpg'),
                'BRG008' => asset('images/lem.jpg'),
                'BRG009' => asset('images/buku-catatan.jpg'),
                'BRG010' => asset('images/tempat-pensil.jpg'),
            ];
        @endphp

        @if (session('success'))
            <div class="alert-success">
                {{ session('success') }}
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
            <div class="product-grid">

                @foreach ($products as $product)

                    @php
                        $gambarProduk = $product->gambar
                            ? (str_starts_with($product->gambar, 'http')
                                ? $product->gambar
                                : asset('storage/' . $product->gambar))
                            : ($gambarProdukDefault[$product->id_barang]
                                ?? 'https://placehold.co/600x400/e2eaf3/1e3a5f?text=Produk');
                    @endphp

                    <article class="product-card">

                        <img
                            src="{{ $gambarProduk }}"
                            alt="{{ $product->nama_barang }}"
                            class="product-image"
                            loading="lazy"
                            onerror="this.onerror=null; this.src='https://placehold.co/600x400/e2eaf3/1e3a5f?text=Produk';"
                        >

                        <div class="product-info">

                            <span class="product-id">
                                {{ $product->id_barang }}
                            </span>

                            <h2>{{ $product->nama_barang }}</h2>

                            <p class="product-description">
                                {{ $product->deskripsi }}
                            </p>

                            <p class="product-price">
                                Rp {{ number_format($product->harga, 0, ',', '.') }}
                            </p>

                            @can('adjust-stock')
                                <p class="product-stock{{ $product->stok == 0 ? ' stock-out' : '' }}">
                                    {{ $product->stok > 0 ? 'Stok: ' . $product->stok : 'Stok Habis' }}
                                </p>
                            @endcan

                            @if ($product->stok > 0)

                                @guest
                                    <a href="{{ route('login') }}" class="btn-cart">
                                        Login untuk Membeli
                                    </a>
                                @else
                                    @can('use-cart')
                                        <form
                                            action="{{ route('keranjang.tambah', $product->id_barang) }}"
                                            method="POST"
                                            class="cart-form"
                                        >
                                            @csrf

                                            <div class="quantity-control">

                                                <button
                                                    type="button"
                                                    class="quantity-btn"
                                                    onclick="ubahJumlah(this, -1)"
                                                    aria-label="Kurangi jumlah"
                                                >−</button>

                                                <input
                                                    type="number"
                                                    name="jumlah"
                                                    class="quantity-input"
                                                    value="1"
                                                    min="1"
                                                    max="{{ $product->stok }}"
                                                    required
                                                    aria-label="Jumlah produk"
                                                >

                                                <button
                                                    type="button"
                                                    class="quantity-btn"
                                                    onclick="ubahJumlah(this, 1)"
                                                    aria-label="Tambah jumlah"
                                                >+</button>

                                            </div>

                                            <button type="submit" class="btn-cart">
                                                Tambah ke Keranjang
                                            </button>
                                        </form>
                                    @endcan
                                @endguest

                            @else

                                <button class="btn-cart btn-disabled" disabled>
                                    Stok Habis
                                </button>

                            @endif

                        </div>
                    </article>

                @endforeach

            </div>
        @endif

    </main>

    <footer class="footer">
        <p>&copy; {{ date('Y') }} Toko Online. Semua hak dilindungi.</p>
    </footer>

    <script>
        function ubahJumlah(button, perubahan) {
            const form = button.closest('.cart-form');
            const input = form.querySelector('.quantity-input');

            const minimum = Number(input.min);
            const maksimum = Number(input.max);
            let jumlah = Number(input.value) || minimum;

            jumlah += perubahan;

            if (jumlah < minimum) jumlah = minimum;
            if (jumlah > maksimum) jumlah = maksimum;

            input.value = jumlah;
        }

        document.querySelectorAll('.quantity-input').forEach(function(input) {
            input.addEventListener('change', function() {
                const minimum = Number(this.min);
                const maksimum = Number(this.max);
                let jumlah = Number(this.value) || minimum;

                if (jumlah < minimum) jumlah = minimum;
                if (jumlah > maksimum) jumlah = maksimum;

                this.value = jumlah;
            });
        });
    </script>

</body>
</html>