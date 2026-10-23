<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('css/riwayat.css') }}">
    <title>Riwayat Pesanan</title>
</head>
<body>
    <h1>Riwayat Pesanan Saya</h1>

    @if (session('success'))
        <p class="alert">{{ session('success') }}</p>
    @endif

    @forelse ($orders as $order)
        <section class="order-card">
            <h3 class="order-header">Pesanan: {{ $order->id_order }}</h3>

            <div class="order-meta">
                <span class="tanggal">Tanggal: {{ $order->tanggal_order->format('d-m-Y H:i') }}</span>
                <span class="alamat">Alamat: {{ $order->alamat_pengiriman }}</span>
            </div>

            <h4 class="detail-title">Detail barang</h4>
            <ul class="items">
                @foreach ($order->details as $detail)
                    <li class="item">
                        {{ $detail->product->nama_barang ?? 'Produk dihapus' }}
                        — {{ $detail->jumlah_beli }} unit
                        × Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}
                    </li>
                @endforeach
            </ul>

            <strong class="total">
                Total: Rp {{ number_format($order->total_harga, 0, ',', '.') }}
            </strong>
        </section>
    @empty
        <p class="empty">Belum ada pesanan.</p>
    @endforelse

    <p class="back"><a href="{{ route('produk.index') }}">Kembali ke katalog</a></p>
</body>
</html>
