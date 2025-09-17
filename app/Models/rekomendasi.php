<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class rekomendasi extends Model
{
    public $timestamps = false;
    protected $table = 'rekomendasi';
    public $primaryKey = 'id_rek';
    protected $fillable =
        [
            'id_rek',
            'id_user',
            'id_sign',
            'no_spb',
            'nama_rek',
            'jenis_unit',
            'ket_unit',
            'alasan_rek',
            'tgl_masuk',
            'nama_receiver',
            'tgl_verif',
            'masukan',
            'status',
            'estimasi_harga',
            'jabatan_receiver'
        ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

}
