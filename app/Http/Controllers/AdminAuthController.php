<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function login(Request $request)
    {
        $validated = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $username = (string) $validated['username'];
        $password = (string) $validated['password'];

        // Hardcoded admin credentials (as requested).
        $ok = in_array($username, ['giftos', 'Giftos'], true) && hash_equals('100200300', $password);

        if (! $ok) {
            return response()->json([
                'ok' => false,
                'message' => 'Invalid admin credentials.',
            ], 401);
        }

        $request->session()->regenerate();
        $request->session()->put('giftos_admin', true);

        return response()->json([
            'ok' => true,
            'message' => 'Logged in as admin.',
        ]);
    }

    public function logout(Request $request)
    {
        $request->session()->forget('giftos_admin');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'ok' => true,
            'message' => 'Logged out.',
        ]);
    }
}
