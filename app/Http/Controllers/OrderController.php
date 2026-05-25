<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:200',
            'phone'     => 'required|string|max:30',
            'address'   => 'required|string|max:1000',
            'items'     => 'required|array|min:1',
            'items.*.name'  => 'required|string|max:200',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.qty'   => 'required|integer|min:1',
            'items.*.img'   => 'nullable|string|max:500',
            'total_usd' => 'required|numeric|min:0',
            'total_lbp' => 'required|numeric|min:0',
        ]);

        $order = Order::create($validated);

        return response()->json(['ok' => true, 'id' => $order->id]);
    }

    public function index()
    {
        $orders = Order::latest()->get();
        return view('admin.orders', compact('orders'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate(['status' => 'required|string|in:new,accepted,processing,in_transit,completed']);
        $order->update(['status' => $request->status]);
        return response()->json(['ok' => true]);
    }
}
