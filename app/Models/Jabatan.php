<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jabatan extends Model
{
    protected $table = 'jabatan';
    protected $primaryKey = 'id_jab';
    public $timestamps = false;


    protected $fillable = [
        'nama_jab',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'id_jab', 'id_jab');
    }

}
