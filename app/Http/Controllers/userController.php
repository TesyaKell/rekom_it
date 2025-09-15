<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class userController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where('username', $request->username)->first();


        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors(['username' => 'Invalid credentials'])->withInput();
        }
        // Login sukses, bisa set session atau redirect ke dashboard
        return redirect('/dashboard')->with('success', 'Login successful');
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
    // public function view()
    // {
    //     return view('dashboard');
    // }

    // public function edit(Request $req, $id)
    // {
    //     $edit = User::where('id_user', $id)->firstOrFail();

    //     $req->validate(
    //         [
    //             'jabatan' => 'required|string|max:255',
    //         'kode_dep' => 'required|string|max:255',
    //         'username' => 'required|string|max:255|unique:users',
    //         'password' => 'required|string|min:8|confirmed',
    //         'nama_leng' => 'required|string|max:255',
    //         'nip' => 'required|string|max:255|unique:users',
    //         ]
    //     );

    //     $edit->update([
    //          'jabatan' => 'required|string|max:255',
    //         'kode_dep' => 'required|string|max:255',
    //         'username' => 'required|string|max:255|unique:users',
    //         'password' => 'required|string|min:8|confirmed',
    //         'nama_leng' => 'required|string|max:255',
    //         'nip' => 'required|string|max:255|unique:users',
    //     ]);
    //     return view('edit_user', compact('edit'));

    // }
    // public function search(Request $request)
    // {
    //     $query = $request->input('query');

    //     $results = User::where('jabatan', 'LIKE', '%' . $query . '%')
    //         ->orWhere('username', 'LIKE', '%' . $query . '%')
    //         ->orWhere('stastus', 'LIKE', '%' . $query . '%')
    //         ->orWhere('nama_receiver', 'LIKE', '%' . $query . '%')
    //         ->orWhere('nip', 'LIKE', '%' . $query . '%')
    //        ->get();

    //     return view('search_results', compact('results', 'query'));
    // }


    // public function delete($id)
    // {
    //     $user = User::where('id_user', $id)->firstOrFail();
    //     $user->delete();
    //     return redirect()->back()->with('status', 'Hapus akun');
    // }

    // public function logout(Request $request)
    // {
    //     return redirect('/login')->with('success', 'Logged out successfully');
    // }
}
