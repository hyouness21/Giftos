<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class TrackOrderController extends Controller
{
    public function show(Request $request)
    {
        $orders = null;
        $phone  = '';

        $local = trim($request->query('phone', ''));
        if ($local !== '') {
            $code  = $request->query('phone_code', '+961');
            $phone = $code . preg_replace('/[\s\-\.]/', '', $local);
            $orders = Order::where('phone', $phone)->latest()->get();
        }

        return view('track', ['orders' => $orders, 'phone' => $phone]);
    }
}
