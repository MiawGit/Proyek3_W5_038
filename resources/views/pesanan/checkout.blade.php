
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="{{ asset('css/checkout.css') }}">
    <title>Checkout</title>
</head>
<body>
    <h1>Checkout Pesanan</h1>

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    @endif

    <form method="POST" action="{{ route('checkout.proses') }}">
        @csrf

        <label>Alamat Pengiriman</label><br>
        <textarea name="alamat_pengiriman" rows="5"
                  required>{{ old('alamat_pengiriman') }}</textarea>
        <br><br>

        <button type="submit">Konfirmasi dan Buat Pesanan</button>
    </form>

    <p><a href="{{ route('keranjang.index') }}">Kembali ke keranjang</a></p>
</body>
</html>
