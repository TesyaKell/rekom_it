<?php

namespace App\Http\Controllers;

use App\Models\signature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Log;

class signatureController extends Controller
{
    public function index()
    {
        if (!session()->has('loginId')) {
            return redirect('/login');
        }

        $user = \DB::table('users')->where('id_user', session('loginId'))->first();
        if ($user) {
            $signatures = signature::all();
            $lastId = signature::max('id_sign');
            $department = \DB::table('department')->pluck('nama_dep');
            return view('signature', compact('signatures', 'lastId', 'department'));
        } else {
            return view('home');
        }
    }

    public function create(Request $request)
    {
        if (!session()->has('loginId')) {
            return redirect('/login');
        }

        $user = DB::table('users')->where('id_user', session('loginId'))->first();

        try {
            $request->validate([
                'nama_approval' => 'required|string|max:255',
                'jabatan' => 'required|string|max:255',
            ]);

            if ($request->hasFile('sign')) {
                $file = $request->file('sign');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('signatures'), $filename);
                $signPath = 'signatures/' . $filename;
            } else {
                $signPath = null;
            }

            Signature::create([
                'nama_approval' => $request->nama_approval,
                'jabatan' => $request->jabatan,
                'created_by' => $user ? $user->nama_leng : 'Unknown',
                'sign' => $signPath,
            ]);

            Log::info("Data signature: ", $request->all());
            return redirect()->route('signature.index');

        } catch (\Exception $e) {
            Log::error("Gagal simpan data : {$e->getMessage()}");
            return redirect()->route('signature.index');
        }
    }


    public function edit($id)
    {
        $signature = Signature::findOrFail($id);
        return view('signature_edit', compact('signature'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_approval' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
        ]);


        $signature = Signature::findOrFail($id);
        $user = DB::table('users')->where('id_user', session('loginId'))->first();

        $signature->update(['nama_approval' => $request->nama_approval, 'jabatan' => $request->jabatan,  'updated_by' => $user ? $user->nama_leng : 'Unknown',]);

        return redirect()->route('signature.index')->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $signature = signature::findOrFail($id);

        $user = DB::table('users')->where('id_user', session('loginId'))->first();
        $deletedBy = $user ? $user->nama_leng : 'Unknown';

        $signature->deleted_by = $deletedBy;
        $signature->save();
        $signature->delete();
        \Log::info("Signature {$signature->nama_approval} (ID: {$signature->id_sign}) dihapus oleh user ID: " . session('loginId'));
        return redirect()->route('signature.index')->with('success', 'Signature berhasil dihapus.');
    }
}
