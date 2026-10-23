<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/keranjang.css') }}">
    <title>Keranjang Belanja</title>
</head>
<body>
    <h1>Keranjang Belanja</h1>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    @endif

    @if (count($items) === 0)
        <p>Keranjang masih kosong.</p>
        <a href="{{ route('produk.index') }}">Kembali ke katalog</a>
    @else
        @foreach ($items as $item)
            <div style="border: 1px solid #ccc; padding: 15px; margin-bottom: 15px;">
                <h3>{{ $item['product']->nama_barang }}</h3>

                <p>Harga: Rp{{ number_format($item['product']->harga, 0, ',', '.') }}</p>
                <p>Stok: {{ $item['product']->stok }}</p>
                <p>Subtotal: Rp{{ number_format($item['subtotal'], 0, ',', '.') }}</p>

                <form action="{{ route('keranjang.update', $item['product']->id_barang) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <label>Jumlah:</label>
                    <input type="number"
                           name="jumlah"
                           min="1"
                           max="{{ $item['product']->stok }}"
                           value="{{ $item['quantity'] }}"
                           required>

                    <button type="submit">Perbarui</button>
                </form>

                <form action="{{ route('keranjang.hapus', $item['product']->id_barang) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Hapus</button>
                </form>
            </div>
        @endforeach

        <h2>Total: Rp{{ number_format($total, 0, ',', '.') }}</h2>

        <a href="{{ route('checkout') }}">Lanjut Checkout</a>
    @endif
</body>
</html>