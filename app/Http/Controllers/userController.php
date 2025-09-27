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
        $credentials = $request->only('username', 'password');
        $user = User::where('username', $credentials['username'])->first();

        if (!$user || $credentials['password'] !== $user->password) {
            return redirect()->back()->with('error', 'Username atau password salah!');
        }

        $user->load('jabatan', 'department');
        if (!$user->jabatan || !$user->department) {
            return redirect()->back()->with('error', 'Data user tidak lengkap');
        }

        $role = 'USER';

        $jabatan = trim($user->jabatan->nama_jab);
        if (stripos($jabatan, 'Kepala Bagian') !== false) {
            $role = 'Kabag';
        } elseif (stripos($user->department->nama_dep, 'IT') !== false) {
            $role = 'IT';
        }


        session([
            'loginId' => $user->id_user,
            'loginRole' => $role,
            'login_type' => 'users'
        ]);
        Log::info("User {$user->id_user} logged in as {$role}");

        return redirect('/daftar_rekomendasi')->with('success', 'Login successful');
    }
}
