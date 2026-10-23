<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    public function checkoutForm(Request $request)
    {
        $cart = $request->session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('keranjang.index')
                ->withErrors(['cart' => 'Keranjang masih kosong.']);
        }

        return view('pesanan.checkout');
    }

    public function checkout(Request $request)
    {
        $data = $request->validate([
            'alamat_pengiriman' => ['required', 'string', 'max:5000'],
        ]);

        $cart = $request->session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('keranjang.index')
                ->withErrors(['cart' => 'Keranjang masih kosong.']);
        }

        $order = DB::transaction(function () use ($cart, $data) {
            $products = Product::whereIn('id_barang', array_keys($cart))
                ->orderBy('id_barang')
                ->lockForUpdate()
                ->get()
                ->keyBy('id_barang');

            $total = 0;

            foreach ($cart as $id => $quantity) {
                if (
                    !is_numeric($quantity) ||
                    (int) $quantity < 1 ||
                    !$products->has($id)
                ) {
                    throw ValidationException::withMessages([
                        'cart' => 'Isi keranjang tidak valid. Silakan periksa kembali.',
                    ]);
                }

                $product = $products[$id];

                if ($product->stok < (int) $quantity) {
                    throw ValidationException::withMessages([
                        'cart' => "Stok {$product->nama_barang} tidak mencukupi.",
                    ]);
                }

                $total += $product->harga * (int) $quantity;
            }

            $order = Order::create([
                'id_order' => 'ORD' . Str::upper(Str::random(12)),
                'user_id' => Auth::id(),
                'tanggal_order' => now(),
                'total_harga' => $total,
                'alamat_pengiriman' => $data['alamat_pengiriman'],
            ]);

            foreach ($cart as $id => $quantity) {
                $product = $products[$id];
                $quantity = (int) $quantity;

                OrderDetail::create([
                    'id_order' => $order->id_order,
                    'id_barang' => $product->id_barang,
                    'harga_satuan' => $product->harga,
                    'jumlah_beli' => $quantity,
                ]);

                $product->stok -= $quantity;
                $product->save();
            }

            return $order;
        });

        $request->session()->forget('cart');

        return redirect()->route('pesanan.index')
            ->with('success', 'Checkout berhasil. Nomor pesanan: ' . $order->id_order);
    }

    public function index()
    {
        $orders = Order::with('details.product')
            ->where('user_id', Auth::id())
            ->latest('tanggal_order')
            ->get();

        return view('pesanan.index', compact('orders'));
    }
}
