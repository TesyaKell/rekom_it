<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Log;
use DB;

class userController extends Controller
{
    public function login(Request $request)
    {
        // Cek tabel login
        $login = DB::table('login')
            ->where('username', $request->username)
            ->where('password', $request->password)
            ->first();

        if ($login) {
            session([
                'username' => $login->username,
                'login_type' => 'login'
            ]);
            return redirect('/home')->with('success', 'Login signature successful');
        }

        // Cek tabel user
        $user = User::where('username', $request->username)->first();
        if ($user && \Hash::check($request->password, $user->password)) {
            session([
                'loginId' => $user->id_user,
                'login_type' => 'users'
            ]);
            return redirect('/home')->with('success', 'Login successful');
        }

        return back()->withErrors('Tidak terdaftar')->withInput();
    }


    // public function register(Request $request)
    // {
    //     $request->validate([
    //         'jabatan' => 'required|string|max:255',
    //         'kode_dep' => 'required|string|max:255',
    //         'username' => 'required|string|max:255|unique:users',
    //         'password' => 'required|string|min:8|confirmed',
    //         'nama_leng' => 'required|string|max:255',
    //         'nip' => 'required|string|max:255|unique:users',
    //     ]);

    //     User::create([
    //         'kode_dep' => $request->kode_dep,
    //         'jabatan' => $request->jabatan,
    //         'username' => $request->username,
    //         'password' => bcrypt($request->password),
    //         'nama_leng' => $request->nama_leng,
    //         'nip' => $request->nip,
    //     ]);

    //     return redirect('/login')->with('status', 'berhasil registrasi!');

    // }
}
