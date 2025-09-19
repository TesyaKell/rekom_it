<?php

namespace App\Http\Controllers;

use App\Models\department;
use App\Models\signature;
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

    public function tampilDataTerhapus()
    {
        if (!session()->has('loginId')) {
            return redirect('/login');
        }

        $data = DB::table('deleted')->get();
        $departments = department::all();
        return view('deleted_rekomendasi', compact('data', 'departments'));
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

        $departments = rekomendasi::find($id_rek);
        $departments->update($req->all());

        return redirect()->route('rekomendasi.index', compact('departments'))->with('success', 'Data berhasil diperbarui!');
    }

    public function laporan(Request $req)
    {
        $results = collect();
        $departmentList = collect();

        try {
            $results = rekomendasi::query()
                ->when($req->filled('noRek') && $req->filled('noRek2'), fn($q) =>
                    $q->whereBetween('id_rek', [$req->noRek, $req->noRek2]))
                ->when($req->filled('tgl_awal') && $req->filled('tgl_akhir'), fn($q) =>
                    $q->whereBetween('tgl_masuk', [$req->tgl_awal, $req->tgl_akhir]))
                ->when($req->filled('department'), fn($q) =>
                    $q->whereRaw('LOWER(jabatan_receiver) = ?', [strtolower($req->department)]))
                ->get();

            $departmentList = rekomendasi::select('jabatan_receiver')->distinct()->pluck('jabatan_receiver');

        } catch (\Exception $e) {
            \Log::error("Gagal menampilkan data : {$e->getMessage()}");
        }
        return view('report', compact('results', 'departmentList'));
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

    public function searchRekomendasi(Request $id_rek)
    {
        $query = $id_rek->input('query');

        $data = rekomendasi::where('nama_rek', 'LIKE', '%' . $query . '%')
            ->orWhere('jenis_unit', 'LIKE', '%' . $query . '%')
            ->orWhere('status', 'LIKE', '%' . $query . '%')
            ->orWhere('nama_receiver', 'LIKE', '%' . $query . '%')
            ->orWhere('jabatan_receiver', 'LIKE', '%' . $query . '%')
            ->orWhere('id_rek', 'LIKE', '%' . $query . '%')
            ->get();

        $departments = department::all();
        return view('daftar_rekomendasi', compact('data', 'departments', 'query'));
    }

    // // public function copy_request(Request $req, $id)
    // // {
    // //     $copy = rekomendasi::find($id);
    // //     $baru = $copy->replicate();
    // //     $baru->save();

    // //     return view('copy_rekomendasi', compact('baru'));
    // // }




    //

    // public function view()
    // {
    //     return view('view_rekomendasi');
    // }


}
