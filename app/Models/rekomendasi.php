<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class rekomendasi extends Model
{
    protected $table = 'rekomendasi';
    protected $fillable = ['id_rek', 'id_user', 'id_sign', 'nama_rek', 'jenis_unit', 'ket_unit', 'alasan_rek', 'tgl_masuk', 'nama_receiver', 'tgl_verif', 'masukan', 'stastus' ];

    public function user()
    {
        return $this->belongsTo(users::class, 'id_user', 'id_user');
    }

}
