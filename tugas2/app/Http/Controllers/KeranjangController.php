<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class KeranjangController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        $barangs = Barang::whereIn('id', array_keys($cart))->get()->keyBy('id');

        return view('keranjang', ['cart' => $cart, 'barangs' => $barangs]);
    }

    public function tambah(Request $request, int $id)
    {
        $this->ubahJumlah($request, $id, 1);

        return redirect('/index');
    }

    public function ubah(Request $request, int $id)
    {
        $delta = $request->input('aksi') === 'kurang' ? -1 : 1;
        $this->ubahJumlah($request, $id, $delta);

        return redirect('/keranjang');
    }

    public function hapus(Request $request, int $id)
    {
        $cart = session('cart', []);
        unset($cart[$id]);
        $request->session()->put('cart', $cart);

        return redirect('/keranjang');
    }

    public function kosongkan(Request $request)
    {
        $request->session()->put('cart', []);

        return redirect('/keranjang');
    }

    private function ubahJumlah(Request $request, int $id, int $delta): void
    {
        $barang = Barang::findOrFail($id);
        $cart = session('cart', []);
        $qty = ($cart[$id] ?? 0) + $delta;

        if ($qty <= 0) {
            unset($cart[$id]);
        } else {
            $cart[$id] = min($qty, $barang->stok);
        }

        $request->session()->put('cart', $cart);
    }
}
