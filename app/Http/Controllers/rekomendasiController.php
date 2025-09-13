<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\rekomendasi;

class rekomendasiController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'id_user' => 'required|string|max:255',
            'id_sign' => 'required|string|max:255',
            'no_spb' => 'required|integer',
            'jenis_unit' => 'required|string|max:255',
            'nama_rek' => 'required|string|max:255',
            'ket_unit' => 'required|string|max:255',
            'alasan_rek' => 'required|string|max:255',
            'tgl_masuk' => 'required|date|max:255',
            'nama_receiver' => 'required|string|max:255',
            //'tgl_verif' => 'required|date|max:255',
            'masukan' => 'required|string|max:255',
            'stastus' => 'required|string|max:255',

        ]);

        rekomendasi::create([
            'id_user' => $request->id_user,
            'id_sign' => $request->id_sign,
            'jenis_unit' => $request->jenis_unit,
            'nama_rek' => $request->nama_rek,
            'ket_unit' => $request->ket_unit,
            'alasan_rek' => $request->alasan_rek,
            'tgl_masuk' => $request->tgl_masuk,
            'nama_receiver' => $request->nama_receiver,
            //'tgl_verif' => $request->tgl_verif,
            'masukan' => $request->masukan,
            'stastus' => $request->stastus,
        ]);

        return view('create_rekomendasi');
    }

    public function edit(Request $request, $id)
    {
        $rekomendasi = rekomendasi::find($id);

        $request->validate([
            'id_user' => 'required|string|max:255',
            'id_sign' => 'required|string|max:255',
            'jenis_unit' => 'required|string|max:255',
            'nama_rek' => 'required|string|max:255',
            'ket_unit' => 'required|string|max:255',
            'alasan_rek	' => 'required|string|max:255',
            'tgl_masuk' => 'required|date|max:255',
            'nama_receiver' => 'required|string|max:255',
            //'tgl_verif' => 'required|date|max:255',
            'masukan' => 'required|string|max:255',
            'stastus' => 'required|string|max:255',

        ]);

        $rekomendasi->update([
            'id_user' => $request->id_user,
            'id_sign' => $request->id_sign,
            'jenis_unit' => $request->jenis_unit,
            'nama_rek' => $request->nama_rek,
            'ket_unit' => $request->ket_unit,
            'alasan_rek' => $request->alasan_rek,
            'tgl_masuk' => $request->tgl_masuk,
            'nama_receiver' => $request->nama_receiver,
            //'tgl_verif' => $request->tgl_verif,
            'masukan' => $request->masukan,
            'stastus' => $request->stastus,
        ]);

        return view('edit_rekomendasi', compact('rekomendasi'));
    }

    // public function copy_request(Request $request, $id)
    // {
    //     $copy = rekomendasi::find($id);
    //     $baru = $copy->replicate();
    //     $baru->save();

    //     return view('copy_rekomendasi', compact('baru'));
    // }

    public function delete($id)
    {
        $rekomendasi = rekomendasi::find($id);
        $rekomendasi->delete();

        return view('delete_rekomendasi');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $results = rekomendasi::where('nama_rek', 'LIKE', '%' . $query . '%')
            ->orWhere('jenis_unit', 'LIKE', '%' . $query . '%')
            ->orWhere('stastus', 'LIKE', '%' . $query . '%')
            ->orWhere('nama_receiver', 'LIKE', '%' . $query . '%')
            ->orWhere('nama_dep', 'LIKE', '%' . $query . '%')
            ->orWhere('id_rek', 'LIKE', '%' . $query . '%')
            ->get();

        return view('search_results', compact('results', 'query'));
    }

    public function view()
    {
        return view('view_rekomendasi');
    }
}
