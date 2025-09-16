<?php

namespace App\Http\Controllers;

use App\Models\department;
use Illuminate\Http\Request;

class departmentController extends Controller
{
    // public function create(Request $req)
    // {
    //     $req->validate(
    //         [
    //             'kode_dep' => 'required|string|max:255|unique:departement',
    //             'nama_dep' => 'required|string|max:255',
    //         ]
    //     );

    //     department::create([
    //         'kode_dep' => $req->kode_dep,
    //         'nama_dep' => $req->nama_dep,
    //     ]);
    //     return view('create_department');
    // }

    // public function update(Request $req, $id)
    // {
    //     $edit =  department::where('id', $id)->firstOrFail();

    //     $req->validate(
    //         [
    //             'kode_dep' => 'required|string|max:255|unique:departement',
    //             'nama_dep' => 'required|string|max:255',
    //         ]
    //     );
    //     $edit->update([
    //         'kode_dep' => $req->kode_dep,
    //         'nama_dep' => $req->nama_dep,
    //     ]);

    //     return view('edit_department', compact('edit'));
    // }

    // public function delete($id)
    // {
    //     $softdelete = department::where('id', $id)->firstOrFail();
    //     $softdelete->delete();
    //     return redirect()->route('department.index');
    // }

    // public function search(Request $request)
    // {
    //     $query = $request->input('query');

    //     $result = department::where('nama_dep', 'LIKE', '%' . $query . '%')
    //         ->orWhere('kode_dep', 'LIKE', '%' . $query . '%')
    //         ->get();

    //     return view('search_department', compact('result', 'query'));
    // }




}
