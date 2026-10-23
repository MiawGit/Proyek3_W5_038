
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
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

    @forelse ($items as $item)
        <hr>
        <h3>{{ $item['product']->nama_barang }}</h3>
        <p>Harga satuan:
            Rp {{ number_format($item['product']->harga, 0, ',', '.') }}
        </p>
        <p>Subtotal:
            Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
        </p>

        <form method="POST"
              action="{{ route('keranjang.update', $item['product']->id_barang) }}">
            @csrf
            @method('PATCH')
            <label>Jumlah</label>
            <input type="number" name="jumlah"
                   min="1" max="{{ $item['product']->stok }}"
                   value="{{ $item['quantity'] }}" required>
            <button type="submit">Perbarui</button>
        </form>

        <form method="POST"
              action="{{ route('keranjang.hapus', $item['product']->id_barang) }}">
            @csrf
            @method('DELETE')
            <button type="submit">Hapus</button>
        </form>
    @empty
        <p>Keranjang masih kosong.</p>
    @endforelse

    <h2>Total: Rp {{ number_format($total, 0, ',', '.') }}</h2>

    @if (count($items) > 0)
        <a href="{{ route('checkout') }}">Lanjut Checkout</a>
    @endif

    <p><a href="{{ route('produk.index') }}">Kembali ke katalog</a></p>
</body>
</html>
