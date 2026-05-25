<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username'  => 'required|string|max:50|unique:users,username|alpha_num',
            'full_name' => 'required|string|max:255',
            'phone'     => 'required|string|max:20|unique:users,phone',
            'address'   => 'required|string|max:500',
            'password'  => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'username'  => $request->username,
            'full_name' => $request->full_name,
            'phone'     => $request->phone,
            'address'   => $request->address,
            'password'  => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect('/products');
    }

    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Admin shortcut
        if ($request->username === 'giftos' && $request->password === '100200300@') {
            $request->session()->regenerate();
            $request->session()->put('giftos_admin', true);
            return redirect('/admin');
        }

        // Regular user
        $user = User::where('username', $request->username)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user, $request->boolean('remember'));
            $request->session()->regenerate();
            return redirect('/products');
        }

        return back()
            ->withErrors(['username' => 'Invalid username or password.'])
            ->withInput($request->only('username'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
