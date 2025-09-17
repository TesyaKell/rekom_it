<?php

namespace App\Http\Controllers;

use App\Models\department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class departmentController extends Controller
{
    // Add index method to fetch departments

    public function index()
    {
        $departments = department::all();
        return view('department', compact('departments'));
    }

    public function generateDepartmentId()
    {
        do {
            $lastNumber = department::withTrashed()
                ->select('kode_dep')
                ->get()
                ->map(fn($item) => (int) substr($item->kode_dep, 3))
                ->sortDesc()
                ->first();

            $nextNumber = $lastNumber ? $lastNumber + 1 : 1;
            $newId = 'DEP' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

            $exists = department::withTrashed()->where('kode_dep', $newId)->exists();
        } while ($exists);

        return $newId;
    }


    public function create(Request $req)
    {
        if (!session()->has('loginId')) {
            return redirect('/login');
        }

        $user = DB::table('users')->where('id_user', session('loginId'))->first();

        try {


            $req->validate([
                'nama_dep' => 'required|string|max:255',
            ]);

            department::create([
                'kode_dep' => $this->generateDepartmentId(),
                'nama_dep' => $req->nama_dep,
            ]);

            \Log::info("Data department: ", $req->all());
            return redirect()->route('department.index');
        } catch (\Exception $e) {
            \Log::info("Data department: ", $req->all());
            \Log::error("Gagal simpan data : {$e->getMessage()}");
        }

    }

    public function edit($id)
    {
        $edit = department::where('kode_dep', $id)->firstOrFail();
        return view('edit_department', compact('edit'));
    }

    public function update(Request $req, $id)
    {
        $edit = department::where('kode_dep', $id)->firstOrFail();

        $req->validate(
            [
                'nama_dep' => 'required|string|max:255',
            ]
        );
        $edit->update([
            'nama_dep' => $req->nama_dep,
        ]);

        return redirect()->route('department.index');
    }

    public function destroy($kode_dep)
    {
        $departments = department::find($kode_dep);
        $departments->delete();

        return redirect()->route('department.index');
    }

    // public function search(Request $request)
    // {
    //     $query = $request->input('query');

    //     $result = department::where('nama_dep', 'LIKE', '%' . $query . '%')
    //         ->orWhere('kode_dep', 'LIKE', '%' . $query . '%')
    //         ->get();

    //     return view('search_department', compact('result', 'query'));
    // }

}
