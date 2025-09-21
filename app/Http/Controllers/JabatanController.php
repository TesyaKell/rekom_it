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
        if (!session()->has('loginId')) {
            return redirect('/login');
        }

        $user = DB::table('users')->where('id_user', session('loginId'))->first();

        try {
            $request->validate([
                'nama_jab' => 'required|string|max:255',
            ]);

            Jabatan::create([
                'nama_jab' => $request->nama_jab,
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
        $jabatan->update($request->only(['nama_jab']));

        return redirect()->route('jabatan.index')->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $jabatan = Jabatan::find($id);

        if ($jabatan) {
            $deletedBy = session('loginId');

            DB::table('log_jabatan')->insert([
                'id_jab'     => $jabatan->id_jab,
                'nama_jab'   => $jabatan->nama_jab,
                'deleted_by' => $deletedBy,
                'deleted_at' => now(),
            ]);

            Log::info("Jabatan {$jabatan->nama_jab} (ID: {$jabatan->id_jab}) dihapus oleh user ID: {$deletedBy}");
            $jabatan->delete();
        }

        return redirect()->route('jabatan.index');
    }

    public function search(Request $req)
    {
        $query = $req->input('query');

        $results = Jabatan::where('nama_jab', 'LIKE', '%' . $query . '%')->get();

        return view('search_jabatan', compact('results', 'query'));
    }
}
