<?php

namespace App\Http\Controllers;

use App\Models\department;
use Illuminate\Http\Request;
use App\Models\rekomendasi;
use App\Models\DetailRekomendasi;
use Illuminate\Support\Facades\DB;
use App\Exports\ReportExport;
use Maatwebsite\Excel\Facades\Excel;

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
                'created_by' => $user->nama_leng ?? '',
            ]);


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

            \Log::info("Sukses tambah rekomendasi oleh user {$user->nama_leng}");
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


    public function updateStatus(Request $req, $id_rek = null)
    {
        try {
            $id_rek = $req->input('id_rek') ?? $id_rek;
            if (!$id_rek) {
                return redirect()->route('rekomendasi.daftar')->with('error', 'ID rekomendasi tidak ditemukan!');
            }

            $rekomendasi = rekomendasi::find($id_rek);
            if (!$rekomendasi) {
                return redirect()->route('rekomendasi.daftar')->with('error', 'Data rekomendasi tidak ditemukan!');
            }

            $user = \DB::table('users')->where('id_user', session('loginId'))->first();

            if ($req->input('action') === 'acc') {
                $rekomendasi->nama_receiver = $user ? $user->nama_leng : '';
                $rekomendasi->tgl_verif_kabag = now();
                $rekomendasi->status = 'menunggu verifikasi Tim IT';

                // Jika centang "Tidak ada masukan", update semua detail yang belum ada masukan_kabag
                if ($req->has('masukan_kabag') && $req->input('masukan_kabag') === 'Tidak ada masukan') {
                    \DB::table('detail_rekomendasi')
                        ->where('id_rek', $id_rek)
                        ->whereNull('masukan_kabag')
                        ->update(['masukan_kabag' => 'Tidak ada masukan']);
                } else {
                    // Cek apakah masih ada barang yang belum diisi masukan_kabag
                    $countNull = \DB::table('detail_rekomendasi')
                        ->where('id_rek', $id_rek)
                        ->whereNull('masukan_kabag')
                        ->count();
                    if ($countNull > 0) {
                        return redirect()->route('rekomendasi.daftar')->with('error', 'Masukan Kabag harus diisi untuk semua barang atau centang Tidak ada masukan.');
                    }
                }
                $rekomendasi->save();
            } elseif ($req->input('action') === 'acc_it') {
                $rekomendasi->tgl_verif_it = now();
                $rekomendasi->status = 'Diterima';

                if ($req->has('masukan_it') && $req->input('masukan_it') === 'Tidak ada masukan') {
                    \DB::table('detail_rekomendasi')
                        ->where('id_rek', $id_rek)
                        ->whereNull('masukan_it')
                        ->update(['masukan_it' => 'Tidak ada masukan']);
                } else {
                    $countNull = \DB::table('detail_rekomendasi')
                        ->where('id_rek', $id_rek)
                        ->whereNull('masukan_it')
                        ->count();
                    if ($countNull > 0) {
                        return redirect()->route('rekomendasi.daftar')->with('error', 'Masukan IT harus diisi untuk semua barang atau centang Tidak ada masukan.');
                    }
                }
                $rekomendasi->save();
            } elseif ($req->input('action') === 'tolak') {
                $rekomendasi->status = 'Ditolak';
                $rekomendasi->save();
            }

            \Log::info("Input status rekomendasi oleh user " . ($user ? $user->id_user : ''));
            return redirect()->route('rekomendasi.daftar')->with('success', 'Status berhasil diperbarui!');
        } catch (\Exception $e) {
            \Log::error("Gagal update status : {$e->getMessage()}");
            return redirect()->route('rekomendasi.daftar')->with('error', 'Gagal update status!');
        }
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
        $query = rekomendasi::query();

        $user = \DB::table('users')->where('id_user', session('loginId'))->first();

        if (session('loginRole') === 'Kabag') {
            $dep = \DB::table('department')->where('kode_dep', $user->kode_dep)->first();
            if ($dep) {
                $query->where('nama_dep', $dep->nama_dep);
            }
        }

        $data = $query->get();
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

        $user = \DB::table('users')->where('id_user', session('loginId'))->first();
        $data = rekomendasi::where('id_rek', $id_rek)->first();
        $departments = department::all();
        $status = $data?->status;
        $namauser = $user?->nama_leng ?? '';

        $details = \DB::table('detail_rekomendasi')->where('id_rek', $id_rek)->get();
        \Log::info($status);

        return view('detailRekomendasi', compact('namauser', 'data', 'departments', 'details', 'status'));
    }


    public function edit($id)
    {
        // Ambil data rekomendasi (bisa lebih dari satu, gunakan get() agar konsisten dengan view)
        $data = rekomendasi::where('id_rek', $id)->get();
        $departments = department::all();
        $details = \DB::table('detail_rekomendasi')->where('id_rek', $id)->get();

        return view('edit_rekomendasi', compact('data', 'departments', 'details'));
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

            // Ambil detail_rekomendasi untuk setiap rekomendasi
            foreach ($results as $item) {
                $item->detail_rekomendasi = \DB::table('detail_rekomendasi')->where('id_rek', $item->id_rek)->get();
            }

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

        $nama_dep = $data->nama_dep ?? '';
        $details = \DB::table('detail_rekomendasi')->where('id_rek', $id)->get();

        $signature_approval = DB::table('signature')
            ->where('jabatan', $nama_dep)
            ->first();
        $nama_approval = $signature_approval ? $signature_approval->nama_approval : '';
        $sign_approval = $signature_approval ? $signature_approval->sign : null;

        $signature_user = DB::table('signature')
            ->where('nama_approval', $data->nama_it)
            ->first();
        $sign_user = $signature_user ? $signature_user->sign : null;


        return view('print', compact(
            'data',
            'details',
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

    public function restore($id_rek)
    {
        $deleted = DB::table('deleted')->where('id_rek', $id_rek)->first();
        if ($deleted) {
            $data = (array) $deleted;

            $rekData = $data;
            unset(
                $rekData['id_rek'],
                $rekData['deleted_by'],
                $rekData['jenis_unit'],
                $rekData['ket_unit'],
                $rekData['masukan'],
                $rekData['masukan_kabag'],
                $rekData['masukan_it'],
                $rekData['estimasi_harga'],
                $rekData['harga_akhir']
            );


            $newIdRek = DB::table('rekomendasi')->insertGetId($rekData);
            $detailData = [
                'id_rek' => $newIdRek,
                'jenis_unit' => $data['jenis_unit'] ?? '-',
                'ket_unit' => $data['ket_unit'] ?? null,
                'masukan_kabag' => $data['masukan_kabag'] ?? null,
                'masukan_it' => $data['masukan_it'] ?? null,
                'estimasi_harga' => $data['estimasi_harga'] ?? null,
                'harga_akhir' => $data['harga_akhir'] ?? null,
            ];

            DB::table('detail_rekomendasi')->insert($detailData);
            DB::table('deleted')->where('id_rek', $id_rek)->delete();
        }
        return redirect()->route('rekomendasi.deleted')->with('success', 'Data berhasil direstore!');
    }


    public function export()
    {
        $query = DB::table('detail_rekomendasi')
            ->join('rekomendasi', 'detail_rekomendasi.id_rek', '=', 'rekomendasi.id_rek')
            ->select(
                'rekomendasi.*',
                'detail_rekomendasi.jenis_unit',
                'detail_rekomendasi.ket_unit',
                'detail_rekomendasi.estimasi_harga',
                'detail_rekomendasi.masukan_kabag',
                'detail_rekomendasi.masukan_it',
                'detail_rekomendasi.harga_akhir',
                'detail_rekomendasi.tanggal_realisasi'
            );

        if (request('noRek')) {
            $query->where('rekomendasi.id_rek', '>=', request('noRek'));
        }
        if (request('nospb')) {
            $query->where('rekomendasi.no_spb', '<=', request('nospb'));
        }
        if (request('nama_lengkap')) {
            $query->where('rekomendasi.nama_lengkap', 'LIKE', '%' . request('nama_lengkap') . '%');
        }
        if (request('nama_dep')) {
            $query->where('rekomendasi.nama_dep', 'LIKE', '%' . request('nama_dep') . '%');
        }
        if (request('jenis_unit')) {
            $query->where('detail_rekomendasi.jenis_unit', 'LIKE', '%' . request('jenis_unit') . '%');
        }
        if (request('ket_unit')) {
            $query->where('detail_rekomendasi.ket_unit', 'LIKE', '%' . request('ket_unit') . '%');
        }
        if (request('alasan_rek')) {
            $query->where('rekomendasi.alasan_rek', 'LIKE', '%' . request('alasan_rek') . '%');
        }
        if (request('estimasi_harga')) {
            $query->where('detail_rekomendasi.estimasi_harga', '<=', request('estimasi_harga'));
        }
        if (request('tgl_awal')) {
            $query->where('rekomendasi.tgl_masuk', '>=', request('tgl_awal'));
        }
        if (request('tanggal_realisasi')) {
            $query->where('detail_rekomendasi.tanggal_realisasi', '<=', request('tanggal_realisasi'));
        }

        $results = $query->get();

        return Excel::download(new ReportExport($results), 'report.xlsx');
    }



}
