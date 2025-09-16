<?php

namespace App\Http\Controllers;

use App\Models\signature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Log;

class signatureController extends Controller
{
    public function index()
    {
        if (!session()->has('loginId')) {
            return redirect('/login');
        }

        $user = DB::table('users')->where('id_user', session('loginId'))->first();

        $signatures = Signature::where('id_user', $user->id_user)->get();

        $lastId = Signature::max('id_sign'); // cari id terbesar
        return view('signature', compact('signatures', 'lastId'));

    }



    public function create(Request $request)
    {
        if (!session()->has('loginId')) {
            return redirect('/login');
        }

        $user = DB::table('users')->where('id_user', session('loginId'))->first();

        try {
            $request->validate([
                'nama_approval' => 'required|string|max:255',
                'jabatan' => 'required|string|max:255',
            ]);

            Signature::create([
                'id_user' => $user->id_user,
                'nama_approval' => $request->nama_approval,
                'jabatan' => $request->jabatan,
            ]);

            Log::info("Berhasil simpan data");
            Log::info("Data signature: ", $request->all());
            return redirect()->route('signature.index');

        } catch (\Exception $e) {
            Log::error("Gagal simpan data : {$e->getMessage()}");
            return redirect()->route('signature.index');
        }
    }


    public function edit($id)
    {
        $signature = Signature::findOrFail($id);
        return view('signature_edit', compact('signature'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_approval' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
        ]);

        $signature = Signature::findOrFail($id);
        $signature->update($request->only(['nama_approval', 'jabatan']));

        return redirect()->route('signature.index')->with('success', 'Data berhasil diperbarui!');
    }




    public function destroy($id)
    {
        $signature = signature::find($id);
        $signature->delete();

        return redirect()->route('signature.index');
    }

    public function search(Request $req)
    {
        $query = $req->input('query');

        $results = signature::where('nama_approval', 'LIKE', '%' . $query . '%')
            ->orWhere('keterangan', 'LIKE', '%' . $query . '%')
            ->get();

        return view('search_signature', compact('results', 'query'));
    }
}
