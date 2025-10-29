<?php

namespace App\Http\Controllers;

use App\Models\department;
use App\Models\Jabatan;
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
        if (stripos($jabatan, 'Network') !== false) {
            $role = 'Network';
        } elseif (stripos($jabatan, 'Helpdesk') !== false) {
            $role = 'Helpdesk';
        } elseif (stripos($jabatan, 'Server') !== false) {
            $role = 'Server';
        } elseif (stripos($user->department->nama_dep, 'IT') !== false) {
            $role = 'IT';
        }
        session([
            'loginId' => $user->id_user,
            'loginRole' => $role,
            'login_type' => 'users'
        ]);
        Log::info("User {$user->id_user} logged in as {$role}");

        return redirect('/home')->with('success', 'Berhasil Login!');
    }

    public function index(Request $request)
    {
        if (session('loginRole') !== 'IT' && session('loginRole') !== 'GSK') {
            return redirect('/home')->withErrors(['access' => 'Anda tidak punya akses']);
        }

        $perPage = (int) $request->get('per_page', 5);
        $currentPage = (int) $request->get('page', 1);

        $users = User::paginate($perPage, ['*'], 'page', $currentPage);
        $lastId = User::max('id_user');
        $positions = Jabatan::all();
        $departments = department::all();

        $users->appends(['per_page' => $perPage]);

        Log::info('Jumlah user: ' . $users->total());

        return view('add_user', compact('users', 'lastId', 'positions', 'departments', 'perPage'));
    }



    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('user_edit', compact('user'));
    }


    public function create(Request $req)
    {
        if (session('loginRole') !== 'IT' && session('loginRole') !== 'GSK') {
            return redirect('/home')->withErrors(['access' => 'Anda tidak punya akses']);
        }

        try {
            $req->validate([
                'username' => 'required|string|max:255',
                'password' => 'required|string',
                'nama_leng' => 'required|string|max:255',
                'id_jab' => 'required',
                'kode_dep' => 'required',
            ]);

            $user = User::create([
                'username' => $req->input('username'),
                'password' => $req->input('password'),
                'nama_leng' => $req->input('nama_leng'),
                'id_jab' => $req->input('id_jab'),
                'kode_dep' => $req->input('kode_dep'),
            ]);

            Log::info("User created with ID: {$user->id_user}");
            return redirect()->back()->with('success', 'User created successfully.');
        } catch (\Exception $e) {
            Log::error("Error creating user: " . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to create user.');
        }
    }


    public function update(Request $req, $id)
    {
        if (session('loginRole') !== 'IT' && session('loginRole') !== 'GSK') {
            return redirect('/home')->withErrors(['access' => 'Anda tidak punya akses']);
        }

        try {
            $req->validate([
                'username' => 'required|string|max:255',
                'password' => 'nullable|string',
            ]);

            $user = User::findOrFail($id);
            $user->username = $req->input('username');
            $user->password = $req->input('password');
            $user->save();

            Log::info("User updated with ID: {$user->id_user}");
            return redirect()->back()->with('success', 'User updated successfully.');
        } catch (\Exception $e) {
            Log::error("Error updating user: " . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update user.');
        }
    }

    public function destroy($id)
    {
        if (session('loginRole') !== 'IT' && session('loginRole') !== 'GSK') {
            return redirect('/home')->withErrors(['access' => 'Anda tidak punya akses']);
        }

        try {
            $user = User::findOrFail($id);
            $user->delete();

            Log::info("User deleted with ID: {$user->id_user}");
            return redirect()->back()->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            Log::error("Error deleting user: " . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to delete user.');
        }
    }
}
