<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class signature extends Model
{
    use SoftDeletes;
    protected $table = 'signature';

    protected $fillable = ['id_sign', 'id_user', 'sign', 'nama_approval', 'keterangan'];

    public function user()
    {
        return $this->belongsTo(users::class, 'id_user', 'id_user');
    }
}
