<?php

namespace App\Http\Controllers;

use App\Models\department;
use App\Models\signature;
use App\Models\User;
use Illuminate\Auth\Events\Login;
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
        $divisions = \DB::table('jabatan')
            ->whereBetween('id_jab', [18, 20])
            ->get();
        return view('add_rekomendasi', compact('user', 'departments', 'lastId', 'data', 'perPage', 'divisions'));


    }

    public function create(Request $req)
    {
        if (!session()->has('loginId')) {
            return redirect('/login');
        }

        $user = \DB::table('users')->where('id_user', session('loginId'))->first();
        $departments = \DB::table('department')->get();
        $divisions = \DB::table('jabatan')->get();

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
                'status' => 'menunggu verifikasi IT GSK',
                'created_by' => $user->nama_leng ?? '',
            ]);


            if ($req->has('detail_rekomendasi')) {
                foreach ($req->detail_rekomendasi as $detail) {
                    \DB::table('detail_rekomendasi')->insert([
                        'id_rek' => $rekomendasi->id_rek,
                        'jenis_unit' => $detail['jenis_unit'] ?? null,
                        'ket_unit' => $detail['ket_unit'] ?? null,
                        'estimasi_harga' => $detail['estimasi_harga'] ?? null,
                        'id_jab' => $detail['id_jab'] ?? null,
                    ]);
                }
            }

            \Log::info('Sukses simpan semua data rekomendasi:', $rekomendasi->toArray());
            return redirect()->route('rekomendasi.daftar')->with('success', 'Data berhasil ditambahkan!');
        } catch (\Exception $e) {
            \Log::error("Gagal simpan data : {$e->getMessage()}");
            return redirect()->route('rekomendasi.index')->with('error', 'Gagal menyimpan data!');
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
            if (!$user) {
                return redirect()->route('login')->with('error', 'Sesi login habis.');
            }

            $detailQuery = \DB::table('detail_rekomendasi')
                ->where('id_rek', $id_rek)
                ->where('id_jab', $user->id_jab);


            if ($req->input('action') === 'acc') {
                $rekomendasi->nama_receiver = $user->nama_leng;
                $rekomendasi->tgl_verif_kabag = now();
                $nama_jab = \DB::table('jabatan')
                    ->where('id_jab', $user->id_jab)
                    ->value('nama_jab');

                $rekomendasi->jabatan_receiver = $nama_jab;
                $detailQuery->update([
                    'status_verifikasi_it' => 1,
                    'updated_at' => now(),
                ]);


                if ($req->filled('masukan_kabag')) {
                    $detailQuery->update(['masukan_kabag' => $req->masukan_kabag]);
                }

                $belumApprove = \DB::table('detail_rekomendasi')
                    ->where('id_rek', $id_rek)
                    ->whereNull('status_verifikasi_it')
                    ->count();

                $rekomendasi->status = $belumApprove === 0
                    ? 'menunggu verifikasi Tim IT'
                    : 'menunggu verifikasi IT GSK (parsial)';

                $rekomendasi->save();
            } elseif ($req->input('action') === 'acc_it') {
                $rekomendasi->nama_it = $user->nama_leng;
                $rekomendasi->tgl_verif_it = now();
                $rekomendasi->status = 'Diterima';

                \DB::table('detail_rekomendasi')
                    ->where('id_rek', $id_rek)
                    ->update([
                        'tanggal_realisasi' => now(),
                        'status_verifikasi_it' => 1
                    ]);

                $rekomendasi->save();
            } elseif ($req->input('action') === 'tolak') {
                $detailQuery->update([
                    'status_verifikasi_it' => 0,
                ]);

                $rekomendasi->status = 'Ditolak';
                $rekomendasi->save();
            }

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

        if (session('loginRole') === 'Network' || session('loginRole') === 'Helpdesk' || session('loginRole') === 'Server') {
            $query->whereHas('detailRekomendasi', function ($q) use ($user) {
                $q->where('id_jab', $user->id_jab);
            });

        }

        $data = $query->paginate($perPage, ['*'], 'page', $currentPage);
        $data->appends(['per_page' => $perPage]);
        $departments = department::all();
        return view('daftar_rekomendasi', compact('data', 'departments', 'perPage', 'user'));
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

        if ($user && in_array(session('loginRole'), [ 'Server', 'Network', 'Helpdesk'])) {
            $details = \DB::table('detail_rekomendasi')
                ->where('id_rek', $id_rek)
                ->where('id_jab', $user->id_jab)
                ->get();
        } else {
            $details = \DB::table('detail_rekomendasi')->where('id_rek', $id_rek)->get();
        }

        \Log::info($status);

        return view('detailRekomendasi', compact('namauser', 'data', 'departments', 'details', 'status'));

    }


    public function edit($id)
    {
        if (!session()->has('loginId')) {
            return redirect('/login');
        }

        $user = \DB::table('users')->where('id_user', session('loginId'))->first();
        $departments = department::all();
        $data = rekomendasi::where('id_rek', $id)->get();

        if ($user && in_array(session('loginRole'), ['Server', 'Network', 'Helpdesk'])) {
            $details = \DB::table('detail_rekomendasi')
                ->where('id_rek', $id)
                ->where('id_jab', $user->id_jab)
                ->get();
        } else {
            $details = \DB::table('detail_rekomendasi')->where('id_rek', $id)->get();
        }

        return view('edit_rekomendasi', compact('data', 'departments', 'details'));
    }


    public function laporan(Request $req)
    {
        try {
            $query = \App\Models\Rekomendasi::query();

            if ($req->filled('noRek') && $req->filled('noRek2')) {
                $query->whereBetween('id_rek', [$req->noRek, $req->noRek2]);
            }

            if ($req->filled('tgl_awal') && $req->filled('tgl_akhir')) {
                $query->whereBetween('tgl_masuk', [$req->tgl_awal, $req->tgl_akhir]);
            }

            if (!empty($req->department)) {
                $query->whereIn('nama_dep', $req->department);
            }

            $user = DB::table('users')->where('id_user', session('loginId'))->first();


            if (in_array(session('loginRole'), ['Network', 'Helpdesk', 'Server'])) {
                $idRekList = DB::table('detail_rekomendasi')
                    ->where('id_jab', $user->id_jab)
                    ->pluck('id_rek');
                $query->whereIn('id_rek', $idRekList);
            } elseif (session('loginRole') !== 'IT') {
                if ($user) {
                    $dep = DB::table('department')->where('kode_dep', $user->kode_dep)->first();
                    if ($dep) {
                        $query->where('nama_dep', $dep->nama_dep);
                    }
                }
            }

            $results = $query->get();

            foreach ($results as $item) {
                if (in_array(session('loginRole'), ['Network', 'Helpdesk', 'Server'])) {
                    $item->detail_rekomendasi = DB::table('detail_rekomendasi')
                        ->where('id_rek', $item->id_rek)
                        ->where('id_jab', $user->id_jab)
                        ->get();
                } else {
                    $item->detail_rekomendasi = DB::table('detail_rekomendasi')
                        ->where('id_rek', $item->id_rek)
                        ->get();
                }
            }

            $departmentList = DB::table('department')->pluck('nama_dep');
        } catch (\Exception $e) {
            \Log::error("Gagal menampilkan data laporan : {$e->getMessage()}");
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

        [$signRequester, $jabatanRequester] = $getSignature($data->nama_lengkap);

        [$signIT, $jabatanIT] = $getSignature($data->nama_it);

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


    public function export(Request $req)
    {
        try {
            $query = Rekomendasi::query();

            if ($req->filled('noRek') && $req->filled('noRek2')) {
                $query->whereBetween('id_rek', [$req->noRek, $req->noRek2]);
            }
            if ($req->filled('tgl_awal') && $req->filled('tgl_akhir')) {
                $query->whereBetween('tgl_masuk', [$req->tgl_awal, $req->tgl_akhir]);
            }
            if (!empty($req->department)) {
                $query->whereIn('nama_dep', $req->department);
            }
            $user = DB::table('users')->where('id_user', session('loginId'))->first();

            if (in_array(session('loginRole'), ['Network', 'Helpdesk', 'Server'])) {
                $idRekList = DB::table('detail_rekomendasi')
                    ->where('id_jab', $user->id_jab)
                    ->pluck('id_rek');
                $query->whereIn('id_rek', $idRekList);
            } elseif (session('loginRole') !== 'IT') {
                if ($user) {
                    $dep = DB::table('department')->where('kode_dep', $user->kode_dep)->first();
                    if ($dep) {
                        $query->where('nama_dep', $dep->nama_dep);
                    }
                }
            }
            $results = $query->get();

            foreach ($results as $item) {
                if (in_array(session('loginRole'), ['Network', 'Helpdesk', 'Server'])) {
                    $item->detail_rekomendasi = DB::table('detail_rekomendasi')
                        ->where('id_rek', $item->id_rek)
                        ->where('id_jab', $user->id_jab)
                        ->get();
                } else {
                    $item->detail_rekomendasi = DB::table('detail_rekomendasi')->where('id_rek', $item->id_rek)->get();
                }
            }
            \Log::info('Jumlah data export: ' . $results->count());
            return Excel::download(new ReportExport($results), 'report.xlsx');
        } catch (\Exception $e) {
            \Log::error("Gagal export laporan: {$e->getMessage()}");
            return redirect()->back()->with('error', 'Gagal export laporan!');
        }
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

        $departmentData = Rekomendasi::select('nama_dep', DB::raw('COUNT(*) as total'))
            ->groupBy('nama_dep')
            ->orderBy('total', 'desc')
            ->get();
        return view('home', compact('monthlyData', 'departmentData'));
    }

    public function detailDeleted($id_rek)
    {
        $data = DB::table('deleted')->where('id_rek', $id_rek)->first();
        $details = DB::table('detail_del')->where('id_rek', $id_rek)->get();
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
