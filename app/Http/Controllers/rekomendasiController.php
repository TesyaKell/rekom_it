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

        try {
            // Simpan data utama ke tabel rekomendasi
            $selectedDep = $departments->where('kode_dep', $req->kode_dep)->first();
            $nama_dep = $selectedDep ? $selectedDep->nama_dep : '';

            $rekomendasi = \App\Models\rekomendasi::create([
                'id_user' => $user->id_user,
                'no_spb' => $req->no_spb,
                'nama_lengkap' => $req->nama_lengkap,
                'tgl_masuk' => $req->tgl_masuk,
                'alasan_rek' => $req->alasan_rek,
                'nama_dep' => $nama_dep,
                'status' => 'menunggu verifikasi Kabag',
            ]);

            // Simpan detail rekomendasi ke tabel detail_rekomendasi
            if ($req->has('detail_rekomendasi')) {
                foreach ($req->detail_rekomendasi as $detail) {
                    \DB::table('detail_rekomendasi')->insert([
                        'id_rek' => $rekomendasi->id_rek,
                        'jenis_unit' => $detail['jenis_unit'] ?? null,
                        'ket_unit' => $detail['ket_unit'] ?? null,
                        'estimasi_harga' => $detail['estimasi_harga'] ?? null,
                    ]);
                }
            }

            \Log::info("Sukses tambah rekomendasi oleh user {$user->id_user}");
            return redirect()->route('rekomendasi.daftar')->with('success', 'Data berhasil ditambahkan!');
        } catch (\Exception $e) {
            \Log::error("Gagal simpan data : {$e->getMessage()}");
            $lastId = \App\Models\rekomendasi::max('id_rek');
            return view('add_rekomendasi', compact('departments', 'lastId'))
                ->with('error', 'Gagal simpan data!');
        }
    }

    public function update(Request $req, $id_rek)
    {
        $req->validate([
            'alasan_rek' => 'nullable|string|max:255',
            'no_spb' => 'nullable|numeric',
            'nama_lengkap' => 'required|string|max:255',
            'tgl_masuk' => 'required|date',
            'nama_dep' => 'required|string|max:255',
        ]);

        $rekomendasi = rekomendasi::findOrFail($id_rek);
        $rekomendasi->update($req->all());

        return redirect()->route('rekomendasi.daftar')->with('success', 'Data berhasil diperbarui!');
    }


    public function updateStatus(Request $req, $id_rek)
    {
        $rekomendasi = rekomendasi::findOrFail($id_rek);

        // Cek role user dari session
        $role = session('loginRole');

        if ($role === 'IT') {
            $rekomendasi->status = 'Selesai';
        } elseif ($role === 'Kepala Bagian') {
            $rekomendasi->status = 'menunggu verifikasi Tim IT';
        } else {
            // Jika role lain, gunakan status dari request (atau default)
            $rekomendasi->status = $req->input('status', $rekomendasi->status);
        }

        $rekomendasi->save();

        return redirect()->route('rekomendasi.approve')->with('success', 'Status berhasil diperbarui!');
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
        $details = \DB::table('detail_rekomendasi')->where('id_rek', $id_rek)->get();

        // Pastikan view 'detailRekomendasi' menampilkan variable 'details'
        return view('detailRekomendasi', compact('data', 'departments', 'details'));
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

        $data = rekomendasi::where('nama_lengkap', 'LIKE', '%' . $query . '%')
            ->orWhereIn('id_rek', function ($sub) use ($query) {
                $sub->select('id_rek')
                    ->from('detail_rekomendasi')
                    ->where('jenis_unit', 'LIKE', '%' . $query . '%');
            })
            ->orWhere('status', 'LIKE', '%' . $query . '%')
            ->orWhere('nama_receiver', 'LIKE', '%' . $query . '%')
            ->orWhere('jabatan_receiver', 'LIKE', '%' . $query . '%')
            ->orWhere('nama_dep', 'LIKE', '%' . $query . '%')
            ->orWhere('id_rek', 'LIKE', '%' . $query . '%')
            ->get();

        $departments = department::all();
        return view('daftar_rekomendasi', compact('data', 'departments', 'query'));
    }
}
