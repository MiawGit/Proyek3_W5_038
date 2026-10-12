<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    private function products()
    {
        return [
            1 => ['id' => 1, 'name' => 'Buku Tulis', 'price' => 5000],
            2 => ['id' => 2, 'name' => 'Pulpen', 'price' => 3000],
            3 => ['id' => 3, 'name' => 'Penggaris', 'price' => 4000],
        ];
    }

    public function index()
    {
        return view('shop');
    }

    public function add(Request $request)
    {
        $productId = (int) $request->input('product_id');

        if (!isset($this->products()[$productId])) {
            return response()->json(['message' => 'Produk tidak ditemukan.'], 404);
        }

        $cart = $request->input('cart', []);
        $cart[$productId] = ($cart[$productId] ?? 0) + 1;

        return response()->json($this->summary($cart));
    }

    public function update(Request $request)
    {
        return response()->json($this->summary($request->input('cart', [])));
    }

    private function summary(array $cart)
    {
        $items = [];
        $total = 0;

        foreach ($cart as $id => $quantity) {
            $id = (int) $id;
            $quantity = (int) $quantity;

            if (!isset($this->products()[$id]) || $quantity <= 0) {
                continue;
            }

            $product = $this->products()[$id];
            $subtotal = $product['price'] * $quantity;

            $items[] = [
                'id' => $id,
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => $quantity,
                'subtotal' => $subtotal,
            ];
            $total += $subtotal;
        }

        return ['items' => $items, 'total' => $total];
    }
}
