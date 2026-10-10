<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>
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
        .tag { font-size: 13px; color: #6b7280; }
        .card-body { padding: 24px; }
        .item { padding: 12px 0; border-bottom: 1px dashed #e5e7eb; }
        .item-nama { font-weight: 600; color: #111827; margin-bottom: 6px; }
        .item-baris { display: flex; align-items: center; justify-content: space-between; gap: 12px; }
        .subtotal { color: #374151; font-size: 14px; }
        .kontrol { display: flex; align-items: center; gap: 8px; }
        .kontrol button {
            width: 28px; height: 28px; padding: 0; font-size: 15px; font-weight: 700;
            color: #fff; background: #4f46e5; border: none; border-radius: 6px; cursor: pointer;
        }
        .kontrol .qty { min-width: 24px; text-align: center; font-weight: 600; color: #111827; }
        .hapus button { background: #dc2626; width: auto; height: auto; padding: 6px 10px; font-size: 12px; border-radius: 6px; }
        .total-baris {
            display: flex; justify-content: space-between; align-items: center;
            padding: 16px 0 4px; font-size: 17px; font-weight: 700; color: #111827;
        }
        .kosong { color: #6b7280; font-size: 14px; margin-bottom: 16px; }
        .aksi-bawah { margin-top: 16px; display: flex; gap: 10px; }
        .kosongkan button { background: #dc2626; padding: 10px 14px; font-size: 14px; border-radius: 8px; }
        .belanja a {
            display: inline-block; padding: 10px 14px; font-size: 14px; font-weight: 600;
            color: #4f46e5; background: #eef2ff; border-radius: 8px; text-decoration: none;
        }
        form { display: inline; }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="card">
            <div class="card-header">
                <h1>Keranjang belanja</h1>
                <span class="tag">Tanpa login</span>
            </div>
            <div class="card-body">
                @if (count($cart) === 0)
                    <p class="kosong">Keranjang masih kosong. Silakan pilih barang di halaman daftar barang.</p>
                @else
                    @php $total = 0; @endphp
                    @foreach ($cart as $id => $qty)
                        @php
                            $barang = $barangs[$id] ?? null;
                            if (!$barang) continue;
                            $subtotal = $barang->harga * $qty;
                            $total += $subtotal;
                        @endphp
                        <div class="item">
                            <div class="item-nama">{{ $barang->nama }}</div>
                            <div class="item-baris">
                                <span class="subtotal">
                                    Rp {{ number_format($barang->harga, 0, ',', '.') }}
                                    x {{ $qty }} =
                                    Rp {{ number_format($subtotal, 0, ',', '.') }}
                                </span>
                                <span class="kontrol">
                                    <form method="POST" action="{{ url('/keranjang/ubah/' . $id) }}">
                                        @csrf
                                        <input type="hidden" name="aksi" value="kurang">
                                        <button type="submit" title="Kurangi">-</button>
                                    </form>
                                    <span class="qty">{{ $qty }}</span>
                                    <form method="POST" action="{{ url('/keranjang/ubah/' . $id) }}">
                                        @csrf
                                        <input type="hidden" name="aksi" value="lebih">
                                        <button type="submit" title="Tambah">+</button>
                                    </form>
                                    <form class="hapus" method="POST" action="{{ url('/keranjang/hapus/' . $id) }}">
                                        @csrf
                                        <button type="submit">hps</button>
                                    </form>
                                </span>
                            </div>
                        </div>
                    @endforeach
                    <div class="total-baris">
                        <span>Total</span>
                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    <div class="aksi-bawah">
                        <form class="kosongkan" method="POST" action="{{ url('/keranjang/kosongkan') }}">
                            @csrf
                            <button type="submit">Kosongkan keranjang</button>
                        </form>
                    </div>
                @endif
                <div class="aksi-bawah belanja">
                    <a href="{{ url('/index') }}">Lanjut belanja</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
