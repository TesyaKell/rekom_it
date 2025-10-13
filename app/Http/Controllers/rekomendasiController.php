<?php

namespace App\Http\Controllers;

use App\Models\department;
use App\Models\signature;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\rekomendasi;
use App\Models\DetailRekomendasi;
use Illuminate\Support\Facades\DB;
use App\Exports\ReportExport;
use Maatwebsite\Excel\Facades\Excel;

class rekomendasiController extends Controller
{
    public function index(Request $request)
    {
        if (!session()->has('loginId')) {
            return redirect('/login');
        }

        $perPage = $request->get('per_page', 10);
        $currentPage = $request->get('page', 1);

        $user = \DB::table('users')->where('id_user', session('loginId'))->first();

        $query = rekomendasi::where('id_user', $user->id_user);

        $data = $query->paginate($perPage, ['*'], 'page', $currentPage);
        $data->appends(['per_page' => $perPage]);

        $departments = \DB::table('department')->get();
        $lastId = rekomendasi::where('id_user', $user->id_user)->max('id_rek');

        return view('add_rekomendasi', compact('user', 'departments', 'lastId', 'data', 'perPage'));
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
        $user = \DB::table('users')->where('id_user', session('loginId'))->first();

        $req->validate([
            'alasan_rek' => 'nullable|string|max:255',
            'no_spb' => 'nullable|numeric',
            'nama_lengkap' => 'required|string|max:255',
            'tgl_masuk' => 'required|date',
            'nama_dep' => 'required|string|max:255',
        ]);

        $rekomendasi = rekomendasi::findOrFail($id_rek);
        $rekomendasi->update($req->all());
        $rekomendasi->updated_by = $user->nama_leng ?? '';
        $rekomendasi->save();

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
                $rekomendasi->nama_it = $user ? $user->nama_leng : '';
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
        $rekomendasi = DB::table('rekomendasi')->where('id_rek', $id_rek)->first();

        if ($rekomendasi) {
            DB::table('deleted')->insert((array) $rekomendasi);

            $details = DB::table('detail_rekomendasi')->where('id_rek', $id_rek)->get();
            foreach ($details as $detail) {
                DB::table('detail_del')->insert((array) $detail);
            }
            DB::table('detail_rekomendasi')->where('id_rek', $id_rek)->delete();
            DB::table('rekomendasi')->where('id_rek', $id_rek)->delete();
        }
        return redirect()->route('rekomendasi.daftar')->with('success', 'Data berhasil dihapus dan diarsipkan!');
    }

    public function restore($id_rek)
    {
        $deleted = DB::table('deleted')->where('id_rek', $id_rek)->first();

        if ($deleted) {
            $rekData = (array) $deleted;
            unset($rekData['deleted_by'], $rekData['deleted_at']);
            $newIdRek = DB::table('rekomendasi')->insertGetId($rekData);
            $details = DB::table('detail_del')->where('id_rek', $id_rek)->get();

            foreach ($details as $detail) {
                $detailData = (array) $detail;
                unset($detailData['id_detail_del']);
                $detailData['id_rek'] = $newIdRek;
                DB::table('detail_rekomendasi')->insert($detailData);
            }
            DB::table('deleted')->where('id_rek', $id_rek)->delete();
            DB::table('detail_del')->where('id_rek', $id_rek)->delete();
        }

        return redirect()->route('rekomendasi.deleted')->with('success', 'Data berhasil direstore!');
    }

    public function tampilData()
    {
        if (!session()->has('loginId')) {
            return redirect('/login');
        }
        $perPage = request('per_page', 10);
        $currentPage = request('page', 1);

        $query = rekomendasi::query();

        $user = \DB::table('users')->where('id_user', session('loginId'))->first();

        if (session('loginRole') === 'Kabag') {
            $dep = \DB::table('department')->where('kode_dep', $user->kode_dep)->first();
            if ($dep) {
                $query->where('nama_dep', $dep->nama_dep);
            }
        }

        $data = $query->paginate($perPage, ['*'], 'page', $currentPage);
        $data->appends(['per_page' => $perPage]);

        $departments = department::all();
        return view('daftar_rekomendasi', compact('data', 'departments', 'perPage'));
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

            if (!empty($req->department)) {
                $query->whereIn('nama_dep', $req->department);
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
        $alamat = User::where('id_user', $data->id_user)->value('alamat') ?? '';
        $details = DB::table('detail_rekomendasi')->where('id_rek', $id)->get();
        $nama_dep = $data->nama_dep ?? '';

        $receiver = DB::table('users')
            ->join('jabatan', 'users.id_jab', '=', 'jabatan.id_jab')
            ->join('department', 'users.kode_dep', '=', 'department.kode_dep')
            ->where('users.nama_leng', $data->nama_receiver)
            ->select('users.nama_leng', 'jabatan.nama_jab', 'department.nama_dep')
            ->first();

        $receiverName = $receiver->nama_leng ?? $data->nama_receiver;
        $receiverRole = $receiver->nama_jab ?? '';
        $receiverDep = $receiver->nama_dep ?? $nama_dep;

        $getSignature = function ($nama) {
            $user = DB::table('users')
                ->join('jabatan', 'users.id_jab', '=', 'jabatan.id_jab')
                ->where('users.nama_leng', $nama)
                ->select('jabatan.nama_jab')
                ->first();

            $jabatan = $user->nama_jab ?? '';

            $sign = DB::table('signature')
                ->where('nama_approval', $nama)
                ->value('sign');

            return [$sign, $jabatan];
        };

        // Diminta Oleh
        [$signRequester, $jabatanRequester] = $getSignature($data->nama_lengkap);

        // Diketahui Oleh (IT)
        [$signIT, $jabatanIT] = $getSignature($data->nama_it);

        // Disetujui Oleh
        [$signApproval, $jabatanApproval] = $getSignature($data->nama_approval);

        return view('print', compact(
            'data',
            'details',
            'alamat',
            'nama_dep',
            'receiverName',
            'receiverRole',
            'receiverDep',
            'signRequester',
            'jabatanRequester',
            'signIT',
            'jabatanIT',
            'signApproval',
            'jabatanApproval'
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



    public function filterStatus(Request $request)
    {
        $status = $request->status;
        $departments = \DB::table('department')->get();
        $query = Rekomendasi::query();

        if ($status === "Belum Realisasi") {

            $query->where("status", "!=", "Diterima");
        } elseif ($status === "Diterima") {

            $query->where("status", "Diterima");
        }

        $data = $query->get();

        return view('daftar_rekomendasi', compact('data', 'departments', 'status'));
    }


    public function export()
    {
        $user = DB::table('users')->where('id_user', session('loginId'))
            ->first();

        $dep = DB::table('department')->where('kode_dep', $user->kode_dep)
            ->first();

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


        if ($dep) {
            $query->where('rekomendasi.nama_dep', $dep->nama_dep);
        }

        // filter tambahan dari request
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
    public function grafik()
    {
        if (!session('loginId')) {
            return redirect('/login');
        }

        $monthlyData = Rekomendasi::select(
            DB::raw('MONTH(tgl_masuk) as bulan'),
            DB::raw('COUNT(*) as total')
        )
            ->whereYear('tgl_masuk', date('Y'))
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get()
            ->map(function ($item) {
                $bulanNama = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
                return [
                    'bulan' => $bulanNama[$item->bulan - 1],
                    'total' => $item->total
                ];
            });

        // Data per departemen
        $departmentData = Rekomendasi::select('nama_dep', DB::raw('COUNT(*) as total'))
            ->groupBy('nama_dep')
            ->orderBy('total', 'desc')
            ->get();
        return view('home', compact('monthlyData', 'departmentData'));
    }

    public function detailDeleted($id_rek)
    {
        $data = DB::table('deleted')->where('id_rek', $id_rek)->first();
        // Ambil detail unit dari tabel deleted jika ada, atau dari detail_rekomendasi jika masih ada
        $details = DB::table('detail_del')->where('id_rek', $id_rek)->get();
        // Jika tidak ada detail di detail_rekomendasi, coba ambil dari kolom di tabel deleted (jika ada)
        if ($details->isEmpty() && isset($data->jenis_unit)) {
            $details = collect([
                (object) [
                    'jenis_unit' => $data->jenis_unit,
                    'ket_unit' => $data->ket_unit ?? null,
                    'estimasi_harga' => $data->estimasi_harga ?? null,
                    'masukan_kabag' => $data->masukan_kabag ?? null,
                    'masukan_it' => $data->masukan_it ?? null,
                    'harga_akhir' => $data->harga_akhir ?? null,
                ]
            ]);
        }
        return view('detail_deleted_rekom', compact('data', 'details'));
    }
}
