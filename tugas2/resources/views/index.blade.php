<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Alat Tulis</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: "Segoe UI", Arial, sans-serif; background: #f3f4f6; padding: 24px; }
        .wrap { max-width: 640px; margin: 0 auto; }
        .card { background: #fff; border-radius: 12px; box-shadow: 0 8px 20px rgba(0,0,0,.08); overflow: hidden; }
        .card-header {
            display: flex; align-items: center; justify-content: space-between;
            padding: 18px 24px; border-bottom: 1px solid #e5e7eb;
        }
        h1 { font-size: 20px; color: #111827; }
        .badge-link {
            text-decoration: none; background: #4f46e5; color: #fff;
            padding: 8px 14px; border-radius: 999px; font-size: 14px; font-weight: 600;
        }
        .card-body { padding: 24px; }
        h2 { font-size: 16px; color: #374151; margin-bottom: 16px; }
        .row {
            display: flex; align-items: center; gap: 12px;
            padding: 12px 0; border-bottom: 1px dashed #e5e7eb;
        }
        .row:last-child { border-bottom: none; }
        .img {
            width: 48px; height: 48px; border-radius: 8px; background: #eef2ff;
            display: flex; align-items: center; justify-content: center; font-size: 22px;
            overflow: hidden; flex-shrink: 0;
        }
        .img img { width: 100%; height: 100%; object-fit: cover; }
        .nama { flex: 1; font-weight: 600; color: #111827; }
        .stok { font-size: 12px; color: #6b7280; font-weight: 400; }
        .harga { width: 90px; text-align: right; color: #374151; font-size: 14px; }
        form { display: inline; }
        button {
            padding: 8px 12px; font-size: 13px; font-weight: 600; color: #fff;
            background: #4f46e5; border: none; border-radius: 8px; cursor: pointer;
        }
        button:hover { background: #4338ca; }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="card">
            <div class="card-header">
                <h1>Toko Alat Tulis</h1>
                <a class="badge-link" href="{{ url('/keranjang') }}">Keranjang ({{ array_sum(session('cart', [])) }})</a>
            </div>
            <div class="card-body">
                <h2>Daftar barang</h2>
                @php
                    $gambar = [
                        'buku-tulis' => 'buku-tulis.png',
                        'pulpen' => 'pulpen.png',
                        'penggaris' => 'penggaris.png',
                        'pensil-2b' => 'pensil-2b.png',
                        'penghapus' => 'penghapus.png',
                    ];
                @endphp
                @foreach ($barangs as $barang)
                    <div class="row">
                        <div class="img">
                            @if (isset($gambar[Str::slug($barang->nama)]))
                                <img src="{{ asset('images/' . $gambar[Str::slug($barang->nama)]) }}" alt="{{ $barang->nama }}">
                            @else
                                📦
                            @endif
                        </div>
                        <div class="nama">
                            {{ $barang->nama }}
                            <div class="stok">Stok: {{ $barang->stok }}</div>
                        </div>
                        <div class="harga">Rp {{ number_format($barang->harga, 0, ',', '.') }}</div>
                        <form method="POST" action="{{ url('/keranjang/tambah/' . $barang->id) }}">
                            @csrf
                            <button type="submit">Masukkan ke keranjang</button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</body>
</html>
