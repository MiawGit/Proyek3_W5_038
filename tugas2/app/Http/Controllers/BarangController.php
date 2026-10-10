<?php

namespace App\Http\Controllers;

use App\Models\Barang;

class BarangController extends Controller
{
    public function index()
    {
        return view('index', ['barangs' => Barang::orderBy('id')->get()]);
    }
}
