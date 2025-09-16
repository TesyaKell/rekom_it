<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\rekomendasi;
use Illuminate\Support\Facades\DB;

class rekomendasiController extends Controller
{
    public function create(Request $req)
    {
        if (!session()->has('loginId')) {
            return redirect('/login');
        }

        $user = DB::table('users')->where('id_user', session('loginId'))->first();
        $departments = \DB::table('department')->get();

        try {

            $req->validate([
                'no_spb' => 'required|numeric',
                'nama_rek' => 'required|string|max:255',
                'jenis_unit' => 'required|string|max:255',
                'ket_unit' => 'required|string|max:255',
                'tgl_masuk' => 'required|date|max:255',
                'estimasi_harga' => 'required|numeric',
                'jabatan_receiver' => 'required|string|max:255',

            ]);

            rekomendasi::create([
                'id_user' => $user->id_user,
                'nama_rek' => $req->nama_rek,
                'jenis_unit' => $req->jenis_unit,
                'no_spb' => $req->no_spb,
                'ket_unit' => $req->ket_unit,
                'tgl_masuk' => $req->tgl_masuk,
                'stastus' => 'diproses',
                'jabatan_receiver' => $req->jabatan_receiver,
                'estimasi_harga' => $req->estimasi_harga,

            ]);

            return view('add_rekomendasi', compact('departments'));
        } catch (\Exception $e) {
            \Log::error("Gagal simpan data : {$e->getMessage()}");
            return view('add_rekomendasi', compact('departments'))->with('error', 'Gagal simpan data!');
        }
    }

    public function tampilData()
    {
        if (!session()->has('loginId')) {
            return redirect('/login');
        }

        $data = rekomendasi::all();
        return view('daftar_rekomendasi', compact('data'));
    }

    // public function update(Request $req, $id)
    // {
    //     $rekomendasi = rekomendasi::find($id);

    //     $req->validate([
    //         'id_user' => 'required|string|max:255',
    //         'id_sign' => 'required|string|max:255',
    //         'jenis_unit' => 'required|string|max:255',
    //         'nama_rek' => 'required|string|max:255',
    //         'ket_unit' => 'required|string|max:255',
    //         'alasan_rek	' => 'required|string|max:255',
    //         'tgl_masuk' => 'required|date|max:255',
    //         'nama_receiver' => 'required|string|max:255',
    //         //'tgl_verif' => 'required|date|max:255',
    //         'masukan' => 'required|string|max:255',
    //         'stastus' => 'required|string|max:255',
    //         'estimasi_harga' => 'required|numeric|max:255',
    //         'jabatan_receiver' => 'required|string|max:255',

    //     ]);

    //     $rekomendasi->update([
    //         'id_user' => $req->id_user,
    //         'id_sign' => $req->id_sign,
    //         'jenis_unit' => $req->jenis_unit,
    //         'nama_rek' => $req->nama_rek,
    //         'ket_unit' => $req->ket_unit,
    //         'alasan_rek' => $req->alasan_rek,
    //         'tgl_masuk' => $req->tgl_masuk,
    //         'nama_receiver' => $req->nama_receiver,
    //         //'tgl_verif' => $req->tgl_verif,
    //         'masukan' => $req->masukan,
    //         'stastus' => $req->stastus,
    //         'estimasi_harga' => $req->estimasi_harga,
    //         'jabatan_receiver' => $req->jabatan_receiver,
    //     ]);

    //     return view('edit_rekomendasi', compact('rekomendasi'));
    // }

    // // public function copy_request(Request $req, $id)
    // // {
    // //     $copy = rekomendasi::find($id);
    // //     $baru = $copy->replicate();
    // //     $baru->save();

    // //     return view('copy_rekomendasi', compact('baru'));
    // // }

    // public function delete($id)
    // {
    //     $rekomendasi = rekomendasi::find($id);

    //     // Simpan data ke tabel deleted
    //     \DB::insert('INSERT INTO deleted SELECT * FROM rekomendasi WHERE id_rek = ?', [$id]);

    //     rekomendasi::find($id)->delete();

    //     return redirect()->route('rekomendasi.index');
    // }


    // public function search(Request $req)
    // {
    //     $query = $req->input('query');

    //     $results = rekomendasi::where('nama_rek', 'LIKE', '%' . $query . '%')
    //         ->orWhere('jenis_unit', 'LIKE', '%' . $query . '%')
    //         ->orWhere('stastus', 'LIKE', '%' . $query . '%')
    //         ->orWhere('nama_receiver', 'LIKE', '%' . $query . '%')
    //         ->orWhere('nama_dep', 'LIKE', '%' . $query . '%')
    //         ->orWhere('id_rek', 'LIKE', '%' . $query . '%')
    //         ->get();

    //     return view('search_results', compact('results', 'query'));
    // }

    // public function laporan(Request $req)
    // {
    //     $data = rekomendasi::query();

    //     if ($req->filled('no_awal') && $req->filled('no_akhir')) {
    //         if ($req->no_awal > $req->no_akhir) {
    //             return redirect('laporan_rekomendasi')->with('error', 'No SPB Awal tidak boleh lebih besar dari No SPB Akhir');
    //         }
    //         $data->whereBetween('no_spb', [$req->no_awal, $req->no_akhir]);
    //     }

    //     if ($req->filled('tgl_awal') && $req->filled('tgl_akhir')) {
    //         if ($req->tgl_awal > $req->tgl_akhir) {
    //             return redirect('laporan_rekomendasi')->with('error', 'Tanggal Awal tidak boleh lebih besar dari Tanggal Akhir');
    //         }
    //         $data->whereBetween('tgl_masuk', [$req->tgl_awal, $req->tgl_akhir]);
    //     }

    //     if ($req->filled('status')) {
    //         $data->where('stastus', $req->status);
    //     }

    //     if ($req->filled('jenis')) {
    //         $data->where('jenis_unit', $req->jenis);
    //     }

    //     if ($req->filled('dep')) {
    //         if ($req->dep == 'All') {
    //             // do nothing, get all
    //         } else {
    //             $data->where('nama_dep', $req->dep);
    //         }
    //     }

    //     if ($req->filled('departemen')) {
    //         $data->where('nama_dep', $req->departemen);
    //     }

    //     $results = $data->get();

    //     return view('laporan_rekomendasi', compact('results'));
    // }

    // public function view()
    // {
    //     return view('view_rekomendasi');
    // }
}
