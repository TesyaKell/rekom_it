<?php

namespace App\Http\Controllers;

use App\Models\department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class departmentController extends Controller
{
    // Add index method to fetch departments

    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 5);
        $currentPage = $request->get('page', 1);

        $departments = department::paginate($perPage, ['*'], 'page', $currentPage);

        // Append the per_page parameter to pagination links
        $departments->appends(['per_page' => $perPage]);

        $newId = $this->generateDepartmentId();
        return view('department', compact('departments', 'newId', 'perPage'));
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
                'created_by' => $user ? $user->nama_leng : '',
            ]);

            \Log::info("Data department: ", $req->all());
            return redirect()->route('department.index');
        } catch (\Exception $e) {
            \Log::info("Data department: ", $req->all());
            \Log::error("Gagal simpan data : {$e->getMessage()}");
            return redirect()->route('department.index')->with(['error', "Gagal simpan department!"]);
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
        $user = DB::table('users')->where('id_user', session('loginId'))->first();


        $req->validate(
            [
                'nama_dep' => 'required|string|max:255',
            ]
        );
        $edit->update([
            'nama_dep' => $req->nama_dep,
            'updated_by' => $user ? $user->nama_leng : '',
        ]);

        return redirect()->route('department.index');
    }

    public function destroy($id)
    {
        $departments = department::find($id);

        $user = DB::table('users')->where('id_user', session('loginId'))->first();
        $deletedBy = $user ? $user->nama_leng : '';

        $departments->deleted_by = $deletedBy;
        $departments->save();
        $departments->delete();
        \Log::info("Department {$departments->nama_dep} (ID: {$departments->kode_dep}) dihapus oleh user ID: " . session('loginId'));
        return redirect()->route('department.index')->with('success', 'Department berhasil dihapus.');
    }
}
