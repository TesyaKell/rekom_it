<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jabatan extends Model
{
    use SoftDeletes;
    protected $table = 'jabatan';
    protected $primaryKey = 'id_jab';


    protected $fillable = [
        'nama_jab',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'id_jab', 'id_jab');
    }

}
