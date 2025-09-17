<?php

namespace App\Http\Controllers;

use App\Models\department;
use Auth;
use Illuminate\Http\Request;
use App\Models\rekomendasi;
use Illuminate\Support\Facades\DB;

class rekomendasiController extends Controller
{
    public function index()
    {
        if (!session()->has('loginId')) {
            return redirect('/login');
        }

        $user = DB::table('users')->where('id_user', session('loginId'))->first();

        $rekomendasi = rekomendasi::where('id_user', $user->id_user)->get();
        $departments = \DB::table('department')->get();
        $lastId = $rekomendasi->max('id_rek');
        $data = $rekomendasi;

        return view('add_rekomendasi', compact('user', 'departments', 'lastId', 'data'));
    }
    public function create(Request $req)
    {
        if (!session()->has('loginId')) {
            return redirect('/login');
        }

        $user = DB::table('users')->where('id_user', session('loginId'))->first();
        $departments = \DB::table('department')->get();
        $lastId = rekomendasi::max('id_rek'); // ambil id terakhir langsung dari tabel

        try {
            $req->validate([
                'no_spb' => 'nullable|numeric',
                'nama_rek' => 'required|string|max:255',
                'jenis_unit' => 'required|string|max:255',
                'ket_unit' => 'required|string|max:255',
                'tgl_masuk' => 'required|date',
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
                'status' => 'menunggu verifikasi Kabag',
                'jabatan_receiver' => $req->jabatan_receiver,
                'estimasi_harga' => $req->estimasi_harga,
            ]);

            return redirect()->route('rekomendasi.index');

        } catch (\Exception $e) {
            \Log::error("Gagal simpan data : {$e->getMessage()}");

            return view('add_rekomendasi', compact('departments', 'lastId'))
                ->with('error', 'Gagal simpan data!');
        }
    }

    public function tampilData()
    {
        if (!session()->has('loginId')) {
            return redirect('/login');
        }

        $data = rekomendasi::all();
        $departments = department::all();
        return view('daftar_rekomendasi', compact('data', 'departments'));
    }
    public function edit($id)
    {
        $rekomendasi = rekomendasi::findOrFail($id);
        return view('rekomendasi_edit', compact('rekomendasi'));
    }

    public function update(Request $req, $id_rek)
    {
        $req->validate([
            'no_spb' => 'nullable|numeric',
            'nama_rek' => 'required|string|max:255',
            'jenis_unit' => 'required|string|max:255',
            'ket_unit' => 'required|string|max:255',
            'tgl_masuk' => 'required|date',
            'estimasi_harga' => 'required|numeric',
            'jabatan_receiver' => 'required|string|max:255',
        ]);

        $rekomendasi = rekomendasi::find($id_rek);
        if ($rekomendasi) {
            $rekomendasi->update($req->all());
        }

        return redirect()->route('rekomendasi.index');
    }

    public function tampilData2(Request $request)
    {
        if (!session()->has('loginId')) {
            return redirect('/login');
        }

        $query = rekomendasi::query();

        // Filter tanggal masuk
        if ($request->filled('tgl_awal') && $request->filled('tgl_akhir')) {
            $query->whereBetween('tgl_masuk', [$request->tgl_awal, $request->tgl_akhir]);
        }

        // Filter jabatan
        if ($request->filled('jabatan_receiver')) {
            $query->where('jabatan_receiver', $request->jabatan_receiver);
        }

        $data = $query->get();

        // Ambil daftar jabatan unik dari tabel rekomendasi
        $jabatanList = rekomendasi::select('jabatan_receiver')->distinct()->pluck('jabatan_receiver');

        return view('report', compact('data', 'jabatanList'));
    }

    public function print($id)
    {
        if (!session()->has('loginId')) {
            return redirect('/login');
        }

        $data = rekomendasi::findOrFail($id);
        // Pastikan variabel yang dikirim ke view adalah 'item'
        return view('print', compact('data'));
    }


    public function destroy($id_rek)
    {
        $rekomendasi = rekomendasi::where('id_rek', $id_rek)->first();
        if ($rekomendasi) {
            $data = $rekomendasi->toArray();
            DB::table('deleted')->insert($data);
            $rekomendasi->delete();
        }
        return redirect()->route('rekomendasi.index');
    }





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
