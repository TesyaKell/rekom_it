<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailRekomendasi extends Model
{
    public $timestamps = false;
    protected $table = 'detail_rekomendasi';
    public $primaryKey = 'id_detail_rekomendasi';
    protected $fillable =
        [
            'id_rek',
            'jenis_unit',
            'ket_unit',
            'masukan',
            'estimasi_harga',
            'harga_akhir',
        ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
