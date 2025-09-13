<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class users extends Model
{
    protected $table = 'users';
    protected $fillable = ['id_user', 'kode_dep', 'jabatan', 'username', 'password', 'nama_leng', 'nip'] ;

    public function department()
    {
        return $this->belongsTo(department::class, 'kode_dep', 'kode_dep');
    }
}
