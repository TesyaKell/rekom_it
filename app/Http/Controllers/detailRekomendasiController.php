<?php

namespace App\Http\Controllers;
use App\Models\DetailRekomendasi;

use Illuminate\Http\Request;

class detailRekomendasiController extends Controller
{
    public function create(Request $req)
    {
        if (!session()->has('loginId')) {
            return redirect('/login');
        }

        $user = \DB::table('users')->where('id_user', session('loginId'))->first();
        $departments = \DB::table('department')->get();
        $lastId = DetailRekomendasi::max('id_detail_rekomendasi');

        try {
            $req->validate([
                'jenis_unit' => 'required|string|max:255',
                'ket_unit' => 'required|string|max:255',
                'masukan' => 'nullable|string|max:255',
                'estimasi_harga' => 'required|numeric',
                'harga_akhir' => 'nullable|numeric',
            ]);

            $selectedDep = $departments->where('kode_dep', $req->kode_dep)->first();
            $nama_dep = $selectedDep ? $selectedDep->nama_dep : '';

            DetailRekomendasi::create([
                'id_user' => $user->id_user,
                'jenis_unit' => $req->jenis_unit,
                'ket_unit' => $req->ket_unit,
                'estimasi_harga' => $req->estimasi_harga,
                'masukan' => $req->masukan,
                'harga_akhir' => $req->harga_akhir,
            ]);

            \Log::info("Sukses tambah rekomendasi oleh user {$user->id_user}");
            return redirect()->route('detail_rekomendasi.daftar')->with('success', 'Data berhasil ditambahkan!');
        } catch (\Exception $e) {
            \Log::error("Gagal simpan data : {$e->getMessage()}");
            return view('add_rekomendasi', compact('departments', 'lastId'))
                ->with('error', 'Gagal simpan data!');
        }
    }


    public function tampilDetail($id_rek)
    {
        try {
            $departments = \DB::table('department')->get();
            $data = \DB::table('rekomendasi')->where('id_rek', $id_rek)->get();
            $details = \DB::table('detail_rekomendasi')->where('id_rek', $id_rek)->get();
            return view('detailRekomendasi', compact('data', 'departments', 'details'));
        } catch (\Exception $e) {
            \Log::error("Gagal menampilkan data : {$e->getMessage()}");
            return redirect()->route('rekomendasi.daftar')->with('error', 'Gagal menampilkan data!');
        }
    }

}
