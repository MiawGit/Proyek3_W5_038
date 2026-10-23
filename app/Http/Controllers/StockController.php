<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;

class StockController extends Controller
{
    public function index(): View
    {
        $products = Product::orderBy('id_barang')->get();

        return view('staff.stok.index', compact('products'));
    }
}
