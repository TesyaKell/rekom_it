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
            'id_detail_rekomendasi',
            'id_rek',
            'jenis_unit',
            'ket_unit',
            'masukan',
            'estimasi_harga',
            'harga_akhir',
        ];

    public function rekomendasi()
    {
        return $this->belongsTo(Rekomendasi::class, 'id_rek', 'id_rek');
    }
}
