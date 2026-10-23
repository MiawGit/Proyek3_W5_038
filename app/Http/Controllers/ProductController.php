<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        $products = Product::all();

        return view('produk.index', compact('products'));
    }

    public function manage(): View
    {
        $products = Product::orderBy('id_barang')->get();

        return view('admin.products.index', compact('products'));
    }

    public function updateStok(Request $request, Product $product): RedirectResponse
    {
        $data = $request->validate([
            'stok' => ['required', 'integer', 'min:0'],
        ]);

        $product->stok = $data['stok'];
        $product->save();

        return back()->with('status', "Stok {$product->nama_barang} diperbarui menjadi {$product->stok}.");
    }
}
