<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = array_values(session('favorites', []));
        return view('favorites.index', compact('favorites'));
    }

    public function toggle(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:200',
            'price'       => 'required|numeric|min:0',
            'img'         => 'nullable|string|max:500',
            'description' => 'nullable|string|max:1000',
            'in_stock'    => 'nullable|boolean',
        ]);

        $favorites = session('favorites', []);
        $key = md5($request->name);

        if (isset($favorites[$key])) {
            unset($favorites[$key]);
            $favorited = false;
        } else {
            $favorites[$key] = [
                'name'        => $request->name,
                'price'       => (float) $request->price,
                'img'         => $request->img ?? '',
                'description' => $request->description ?? '',
                'in_stock'    => filter_var($request->in_stock, FILTER_VALIDATE_BOOLEAN),
            ];
            $favorited = true;
        }

        session(['favorites' => $favorites]);

        return response()->json([
            'favorited'      => $favorited,
            'favorite_count' => count($favorites),
        ]);
    }
}
