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
            'masukan_kabag',
            'masukan_it',
            'estimasi_harga',
            'harga_akhir',
            'tanggal_realisasi',
            'id_jab',
            'status_verifikasi_it',
            'updated_at',
        ];

    public function rekomendasi()
    {
        return $this->hasMany(DetailRekomendasi::class, 'id_rek', 'id_rek');
    }

}
