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
                'kode_dep' => 'required|string|max:255',
                'alasan_rek' => 'nullable|string|max:255',
            ]);

            $selectedDep = $departments->where('kode_dep', $req->kode_dep)->first();
            $nama_dep = $selectedDep ? $selectedDep->nama_dep : '';
            if (is_array($nama_dep)) {
                $nama_dep = implode(', ', $nama_dep);
            }

            rekomendasi::create([
                'id_user' => $user->id_user,
                'alasan_rek' => $req->alasan_rek ,
                'nama_rek' => $req->nama_rek,
                'jenis_unit' => $req->jenis_unit,
                'no_spb' => $req->no_spb,
                'ket_unit' => $req->ket_unit,
                'tgl_masuk' => $req->tgl_masuk,
                'status' => 'menunggu verifikasi Kabag',
                'nama_dep' => $nama_dep,
                'estimasi_harga' => $req->estimasi_harga,
            ]);
            \Log::info("sukses : {$req->all()}");
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
            'alasan_rek' => 'nullable|string|max:255',
            'no_spb' => 'nullable|numeric',
            'nama_rek' => 'required|string|max:255',
            'jenis_unit' => 'required|string|max:255',
            'ket_unit' => 'required|string|max:255',
            'tgl_masuk' => 'required|date',
            'estimasi_harga' => 'required|numeric',
            'nama_dep' => 'required|string|max:255',
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
            $user = DB::table('users')->where('id_user', session('loginId'))->first();

            $dep = DB::table('department')->where('kode_dep', $user->kode_dep)->first();
            $nama_dep = $dep ? $dep->nama_dep : '';
            $results = rekomendasi::query()
                ->when($req->filled('noRek') && $req->filled('noRek2'), fn ($q) =>
                    $q->whereBetween('id_rek', [$req->noRek, $req->noRek2]))
                ->when($req->filled('tgl_awal') && $req->filled('tgl_akhir'), fn ($q) =>
                    $q->whereBetween('tgl_masuk', [$req->tgl_awal, $req->tgl_akhir]))
                ->where('nama_dep', $nama_dep)
                ->get();

            $departmentList = rekomendasi::select('nama_dep')->distinct()->pluck('nama_dep');
            \Log::info("sukses menampilkan data : {$results}");
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
