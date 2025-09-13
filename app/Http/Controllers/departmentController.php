<?php

namespace App\Http\Controllers;

use App\Models\department;
use Illuminate\Http\Request;

class departmentController extends Controller
{
    public function create(Request $req)
    {
        $req->validate(
            [
                'kode_dep' => 'required|string|max:255|unique:departement',
                'nama_dep' => 'required|string|max:255',
            ]
        );

        department::create([
            'kode_dep' => $req->kode_dep,
            'nama_dep' => $req->nama_dep,
        ]);
        return view('create_department');
    }


}
