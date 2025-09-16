<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class signature extends Model
{
    protected $table = 'signature';
    public $timestamps = false;
    public $primaryKey = 'id_sign';
    protected $fillable = [ 'id_user', 'sign', 'nama_approval', 'jabatan'];

    public function user()
    {
        return $this->belongsTo(user::class, 'id_user', 'id_user');
    }
}
