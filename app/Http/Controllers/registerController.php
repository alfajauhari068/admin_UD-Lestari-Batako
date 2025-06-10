<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class registerController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        // Validasi data yang diterima
        $request->validate([
            'name' => 'required|string|max:255|',
            'email' => 'required|string|email:dns|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Simpan data pengguna baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        

        return redirect()->route('dashboard')->with('success', 'Registration successful!');
    }
}
