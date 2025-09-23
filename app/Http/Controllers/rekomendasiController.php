<?php

namespace App\Http\Controllers;

use App\Models\department;
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

        $user = \DB::table('users')->where('id_user', session('loginId'))->first();

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

        $user = \DB::table('users')->where('id_user', session('loginId'))->first();
        $departments = \DB::table('department')->get();
        $lastId = rekomendasi::max('id_rek');

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

            \Log::info("Sukses tambah rekomendasi oleh user {$user->id_user}");
            return redirect()->route('rekomendasi.daftar')->with('success', 'Data berhasil ditambahkan!');
        } catch (\Exception $e) {
            \Log::error("Gagal simpan data : {$e->getMessage()}");
            return view('add_rekomendasi', compact('departments', 'lastId'))
                ->with('error', 'Gagal simpan data!');
        }
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

        $rekomendasi = rekomendasi::findOrFail($id_rek);
        $rekomendasi->update($req->all());

        return redirect()->route('rekomendasi.daftar')->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($id_rek)
    {
        $rekomendasi = rekomendasi::where('id_rek', $id_rek)->first();
        if ($rekomendasi) {
            $data = $rekomendasi->toArray();
            DB::table('deleted')->insert($data);
            $rekomendasi->delete();
        }
        return redirect()->route('rekomendasi.daftar')->with('success', 'Data berhasil dihapus!');
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

    public function tampilDetail($id_rek)
    {
        if (!session()->has('loginId')) {
            return redirect('/login');
        }

        $data = rekomendasi::where('id_rek', $id_rek)->get();
        $departments = department::all();
        return view('detailRekomendasi', compact('data', 'departments'));
    }

    public function edit($id)
    {
        $rekomendasi = rekomendasi::findOrFail($id);
        return view('rekomendasi_edit', compact('rekomendasi'));
    }


    public function laporan(Request $req)
    {
        try {
            $query = rekomendasi::query();

            if ($req->filled('noRek') && $req->filled('noRek2')) {
                $query->whereBetween('id_rek', [$req->noRek, $req->noRek2]);
            }
            if ($req->filled('tgl_awal') && $req->filled('tgl_akhir')) {
                $query->whereBetween('tgl_masuk', [$req->tgl_awal, $req->tgl_akhir]);
            }
            if ($req->filled('department')) {
                $query->where('nama_dep', $req->department);
            }
            if (session('loginRole') !== 'IT') {
                $user = \DB::table('users')->where('id_user', session('loginId'))->first();
                if ($user) {
                    $dep = \DB::table('department')->where('kode_dep', $user->kode_dep)->first();
                    if ($dep) {
                        $query->where('nama_dep', $dep->nama_dep);
                    }
                }
            }

            $results = $query->get();
            $departmentList = \DB::table('department')->pluck('nama_dep');

            \Log::info("Sukses menampilkan data laporan, total: " . $results->count());
        } catch (\Exception $e) {
            \Log::error("Gagal menampilkan data laporan : {$e->getMessage()}");
            $results = collect();
            $departmentList = collect();
        }
        return view('report', compact('results', 'departmentList'));
    }

    public function print($id)
    {
        if (!session()->has('loginId')) {
            return redirect('/login');
        }
        $user = DB::table('users')->where('id_user', session('loginId'))->first();
        $data = rekomendasi::findOrFail($id);

        $nama_leng = $user ? $user->nama_leng : 'Unknown';
        $nama_dep = $data->nama_dep ?? 'Unknown';

        // Ambil signature berdasarkan jabatan (untuk nama_approval)
        $signature_approval = DB::table('signature')
                                ->where('jabatan', $nama_dep)
                                ->first();
        $nama_approval = $signature_approval ? $signature_approval->nama_approval : 'Unknown';
        $sign_approval = $signature_approval ? $signature_approval->sign : null;

        // Ambil signature berdasarkan nama_leng (langsung bandingkan dengan nama_approval)
        $signature_user = DB::table('signature')
                            ->where('nama_approval', $nama_leng)
                            ->first();
        $sign_user = $signature_user ? $signature_user->sign : null;

        return view('print', compact(
            'data',
            'nama_leng',
            'nama_dep',
            'nama_approval',
            'sign_approval',
            'sign_user'
        ));
    }



    public function searchRekomendasi(Request $id_rek)
    {
        $query = $id_rek->input('query');

        $data = rekomendasi::where('nama_rek', 'LIKE', '%' . $query . '%')
           ->orWhere('status', 'LIKE', '%' . $query . '%')
            ->orWhere('nama_receiver', 'LIKE', '%' . $query . '%')
            ->orWhere('jabatan_receiver', 'LIKE', '%' . $query . '%')
            ->orWhere('id_rek', 'LIKE', '%' . $query . '%')
            ->get();

        $departments = department::all();
        return view('daftar_rekomendasi', compact('data', 'departments', 'query'));
    }

    public function filterStatus(Request $request)
    {
        $status = $request->input('status');

        if (empty($status) || $status == 'Semua Rekomendasi') {
            $data = rekomendasi::all();
        } elseif ($status == 'Belum Realisasi') {
            $data = rekomendasi::whereIn('status', [
                'menunggu verifikasi Kabag',
                'menunggu verifikasi Tim IT',
                'Ditolak'
            ])->get();
        } else {
            $data = rekomendasi::where('status', $status)->get();
        }
        $departments = department::all();
        return view('daftar_rekomendasi', compact('data', 'departments'));
    }

}
