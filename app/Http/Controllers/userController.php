<?php

namespace App\Http\Controllers;

use App\Models\users;
use Illuminate\Http\Request;

class userController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = users::where('username', $request->username)
            ->where('password', bcrypt($request->password))
            ->first();

        if (!$user) {
            return back()->withErrors(['username' => 'Invalid credentials'])->withInput();
        }
        return redirect('/dashboard')->with('success', 'Login successful');

    }

    public function register(Request $request)
    {
        $request->validate([
            'jabatan' => 'required|string|max:255',
            'kode_dep' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'nama_leng' => 'required|string|max:255',
            'nip' => 'required|string|max:255|unique:users',
        ]);

        users::create([
            'kode_dep' => $request->kode_dep,
            'jabatan' => $request->jabatan,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'nama_leng' => $request->nama_leng,
            'nip' => $request->nip,
        ]);

        return redirect('/login')->with('status', 'berhasil registrasi!');

    }

    public function logout(Request $request)
    {
        return redirect('/login')->with('success', 'Logged out successfully');
    }
}
