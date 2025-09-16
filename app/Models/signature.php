<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class signature extends Model
{
    protected $table = 'signature';

    protected $fillable = ['id_sign', 'id_user', 'sign', 'nama_approval', 'keterangan'];

    public function user()
    {
        return $this->belongsTo(users::class, 'id_user', 'id_user');
    }
}
