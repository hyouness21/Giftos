<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        return response()->json(array_values(session('cart', [])));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:200',
            'price' => 'required|numeric|min:0',
            'img'   => 'nullable|string|max:500',
            'delta' => 'required|integer|in:-1,1',
        ]);

        $cart = session('cart', []);
        $key  = md5($request->name);
        $qty  = max(0, ($cart[$key]['qty'] ?? 0) + (int) $request->delta);

        if ($qty === 0) {
            unset($cart[$key]);
        } else {
            $cart[$key] = [
                'name'  => $request->name,
                'price' => (float) $request->price,
                'img'   => $request->img,
                'qty'   => $qty,
            ];
        }

        session(['cart' => $cart]);

        $cartCount = array_sum(array_column($cart, 'qty'));

        return response()->json(['qty' => $qty, 'cart_count' => $cartCount]);
    }

    public function clear()
    {
        session()->forget('cart');
        return response()->json(['ok' => true]);
    }

    public function remove(Request $request)
    {
        $request->validate(['name' => 'required|string|max:200']);

        $cart = session('cart', []);
        unset($cart[md5($request->name)]);
        session(['cart' => $cart]);

        $cartCount = array_sum(array_column($cart, 'qty'));

        return response()->json(['ok' => true, 'cart_count' => $cartCount]);
    }
}
