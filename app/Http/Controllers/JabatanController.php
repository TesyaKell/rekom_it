<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Log;

class JabatanController extends Controller
{
    public function index()
    {

        if (session('loginRole') !== 'IT') {
            return redirect('/home')->withErrors(['access' => 'Anda tidak punya akses']);
        }

        $jabatans = Jabatan::all();
        $lastId = Jabatan::max('id_jab');
        return view('jabatan', compact('jabatans', 'lastId'));
    }


    public function create(Request $request)
    {
        if (session('loginRole') !== 'IT') {
            return redirect('/home')->withErrors(['access' => 'Anda tidak punya akses']);
        }
        try {
            $user = DB::table('users')->where('id_user', session('loginId'))->first();

            $request->validate([
                'nama_jab' => 'required|string|max:255',
            ]);

            Jabatan::create([
                'nama_jab' => $request->nama_jab,
                'created_by' => $user ? $user->nama_leng : 'Unknown',
            ]);

            Log::info("Data jabatan: ", $request->all());
            return redirect()->route('jabatan.index');
        } catch (\Exception $e) {
            Log::error("Gagal simpan data : {$e->getMessage()}");
            return redirect()->route('jabatan.index');
        }
    }

    public function edit($id)
    {
        $jabatan = Jabatan::findOrFail($id);
        return view('jabatan_edit', compact('jabatan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_jab' => 'required|string|max:255',
        ]);

        $jabatan = Jabatan::findOrFail($id);
        $user = DB::table('users')->where('id_user', session('loginId'))->first();

        $jabatan->update([
            'nama_jab'   => $request->nama_jab,
            'updated_by' => $user ? $user->nama_leng : 'Unknown',
        ]);
        \Log::info("Jabatan ID: {$jabatan->id_jab} diperbarui oleh user ID: " . session('loginId'));
        return redirect()->route('jabatan.index')->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $jabatan = Jabatan::findOrFail($id);

        $user = DB::table('users')->where('id_user', session('loginId'))->first();
        $deletedBy = $user ? $user->nama_leng : 'Unknown';

        $jabatan->deleted_by = $deletedBy;
        $jabatan->save();
        $jabatan->delete();
        \Log::info("Jabatan {$jabatan->nama_jab} (ID: {$jabatan->id_jab}) dihapus oleh user ID: " . session('loginId'));
        return redirect()->route('jabatan.index')->with('success', 'Jabatan berhasil dihapus.');
    }

}
