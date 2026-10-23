<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cart = $request->session()->get('cart', []);
        $products = Product::whereIn('id_barang', array_keys($cart))
            ->get()
            ->keyBy('id_barang');

        $items = [];
        $total = 0;

        foreach ($cart as $id => $quantity) {
            if (!$products->has($id)) {
                continue;
            }

            $product = $products[$id];
            $subtotal = $product->harga * $quantity;
            $total += $subtotal;

            $items[] = [
                'product' => $product,
                'quantity' => $quantity,
                'subtotal' => $subtotal,
            ];
        }

        return view('keranjang.index', compact('items', 'total'));
    }

    public function tambah(Request $request, string $id)
    {
        $data = $request->validate([
            'jumlah' => ['required', 'integer', 'min:1'],
        ]);

        $product = Product::findOrFail($id);

        if ($product->stok < 1) {
            return back()->withErrors(['cart' => 'Stok produk habis.']);
        }

        $cart = $request->session()->get('cart', []);
        $jumlahBaru = ($cart[$id] ?? 0) + $data['jumlah'];

        if ($jumlahBaru > $product->stok) {
            return back()->withErrors([
                'cart' => 'Jumlah pembelian melebihi stok yang tersedia.',
            ]);
        }

        $cart[$id] = $jumlahBaru;
        $request->session()->put('cart', $cart);

        return redirect()->route('keranjang.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'jumlah' => ['required', 'integer', 'min:1'],
        ]);

        $product = Product::findOrFail($id);

        if ($data['jumlah'] > $product->stok) {
            return back()->withErrors([
                'cart' => 'Jumlah pembelian melebihi stok yang tersedia.',
            ]);
        }

        $cart = $request->session()->get('cart', []);
        abort_unless(array_key_exists($id, $cart), 404);

        $cart[$id] = $data['jumlah'];
        $request->session()->put('cart', $cart);

        return redirect()->route('keranjang.index');
    }

    public function hapus(Request $request, string $id)
    {
        $cart = $request->session()->get('cart', []);
        unset($cart[$id]);

        $request->session()->put('cart', $cart);

        return redirect()->route('keranjang.index')
            ->with('success', 'Produk dihapus dari keranjang.');
    }
}
