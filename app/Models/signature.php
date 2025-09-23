<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class signature extends Model
{
    use SoftDeletes;
    public $timestamps = false;
    protected $table = 'signature';

    public $primaryKey = 'id_sign';
    protected $fillable = [ 'id_user',
     'sign',
     'nama_approval',
     'jabatan',
     'created_by',
        'updated_by',
        'deleted_by', ];

    public function user()
    {
        return $this->belongsTo(user::class, 'id_user', 'id_user');
    }
}
