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
            'nama_lengkap',
            'alasan_rek',
            'tgl_masuk',
            'nama_receiver',
            'tgl_verif',
            'masukan',
            'nama_dep',
            'status',
            'no_spb',
            'jabatan_receiver',
            'bukti_pembelian'
        ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

}
