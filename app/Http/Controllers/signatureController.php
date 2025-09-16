<?php

namespace App\Http\Controllers;

use App\Models\signature;
use Illuminate\Http\Request;

class signatureController extends Controller
{
    // public function create(Request $request)
    // {
    //     $request->validate([
    //         'id_user' => 'required|string|max:255',
    //         'sign' => 'required|string|max:255',
    //         'nama_approval' => 'required|string|max:255',
    //         'keterangan' => 'required|string|max:255',
    //     ]);

    //     signature::create([
    //         'id_user' => $request->id_user,
    //         'sign' => $request->sign,
    //         'nama_approval' => $request->nama_approval,
    //         'keterangan' => $request->keterangan,
    //     ]);

    //     return view('create_signature');
    // }

    // public function update(Request $req, $id)
    // {
    //     $signature = signature::find($id);

    //     $req->validate([
    //         'sign' => 'required|string|max:255',
    //         'nama_approval' => 'required|string|max:255',
    //         'keterangan' => 'required|string|max:255',
    //     ]);

    //     $signature->update([
    //         'sign' => $req->sign,
    //         'nama_approval' => $req->nama_approval,
    //         'keterangan' => $req->keterangan,
    //     ]);

    //     return view('edit_signature', compact('signature'));
    // }



    // public function delete($id)
    // {
    //     $signature = signature::find($id);
    //     $signature->delete();

    //     return view('delete_signature');
    // }

    // public function search(Request $req)
    // {
    //     $query = $req->input('query');

    //     $results = signature::where('nama_approval', 'LIKE', '%' . $query . '%')
    //         ->orWhere('keterangan', 'LIKE', '%' . $query . '%')
    //         ->get();

    //     return view('search_signature', compact('results', 'query'));
    // }

    // public function view()
    // {
    //     $signatures = signature::all();
    //     return view('view_signature', compact('signatures'));
    // }
}
