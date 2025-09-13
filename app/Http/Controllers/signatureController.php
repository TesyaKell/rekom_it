<?php

namespace App\Http\Controllers;

use App\Models\signature;
use Illuminate\Http\Request;

class signatureController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'id_user' => 'required|string|max:255',
            'sign' => 'required|string|max:255',
            'nama_approval' => 'required|string|max:255',
            'keterangan' => 'required|string|max:255',
        ]);

        signature::create([
            'id_user' => $request->id_user,
            'sign' => $request->sign,
            'nama_approval' => $request->nama_approval,
            'keterangan' => $request->keterangan,
        ]);

        return view('create_signature');
    }

    public function edit(Request $request, $id)
    {
        $signature = signature::find($id);

        $request->validate([
            'sign' => 'required|string|max:255',
            'nama_approval' => 'required|string|max:255',
            'keterangan' => 'required|string|max:255',
        ]);

        $signature->update([
            'sign' => $request->sign,
            'nama_approval' => $request->nama_approval,
            'keterangan' => $request->keterangan,
        ]);

        return view('edit_signature', compact('signature'));
    }



    public function delete($id)
    {
        $signature = signature::find($id);
        $signature->delete();

        return view('delete_signature');
    }
}
