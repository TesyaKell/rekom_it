<?php

namespace App\Http\Controllers;

use App\Models\DetailRekomendasi;
use Illuminate\Database\Eloquent\Model;
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
        $lastId = \DB::table('detail_rekomendasi')->max('id_detail_rekomendasi');

        try {
            $req->validate([
                'jenis_unit' => 'required|string|max:255',
                'ket_unit' => 'required|string|max:255',
                'masukan_kabag' => 'nullable|string|max:255',
                'masukan_it' => 'nullable|string|max:255',
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
                'masukan_kabag' => $req->masukan_kabag,
                'masukan_it' => $req->masukan_it,
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


    public function masukan(Request $req, $id_detail_rekomendasi)
    {
        if (!session()->has('loginId')) {
            return redirect('/login');
        }

        $user = \DB::table('users')->where('id_user', session('loginId'))->first();

        try {

            if (session('loginRole') === 'IT') {
                $req->validate([
                    'masukan_it' => 'required|string|max:255',
                ]);
                \DB::table('detail_rekomendasi')
                    ->where('id_detail_rekomendasi', $id_detail_rekomendasi)
                    ->update(['masukan_it' => $req->masukan_it]);
            } elseif (session('loginRole') === 'Kabag') {
                $req->validate([
                    'masukan_kabag' => 'required|string|max:255',
                ]);
                \DB::table('detail_rekomendasi')
                    ->where('id_detail_rekomendasi', $id_detail_rekomendasi)
                    ->update(['masukan_kabag' => $req->masukan_kabag]);
            }

            \Log::info("Sukses update masukan oleh user {$user->id_user}");
            return back()->with('success', 'Masukan berhasil disimpan!');
        } catch (\Exception $e) {
            \Log::info("Gagal simpan masukan : " . $e->getMessage());
            return back()->with('error', 'Gagal simpan masukan!');
        }
    }

    public function update(Request $req, $id_detail_rekomendasi)
    {
        if (!session()->has('loginId')) {
            return redirect('/login');
        }

        $req->validate([
            'jenis_unit' => 'required|string|max:255',
            'ket_unit' => 'required|string|max:255',
            'estimasi_harga' => 'required|numeric',
            'masukan_kabag' => 'nullable|string|max:255',
            'masukan_it' => 'nullable|string|max:255',
        ]);

        $updateData = [
           'jenis_unit' => $req->jenis_unit,
           'ket_unit' => $req->ket_unit,
           'estimasi_harga' => $req->estimasi_harga,
        ];

        if ($req->has('masukan_kabag')) {
            $updateData['masukan_kabag'] = $req->masukan_kabag;
        }
        if ($req->has('masukan_it')) {
            $updateData['masukan_it'] = $req->masukan_it;
        }


        \DB::table('detail_rekomendasi')
            ->where('id_detail_rekomendasi', $id_detail_rekomendasi)
            ->update($updateData);

        return back()->with('success', 'Detail rekomendasi berhasil diperbarui!');
    }
}
