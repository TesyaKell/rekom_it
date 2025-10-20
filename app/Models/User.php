<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use SoftDeletes;
    protected $primaryKey = 'id_user';
    protected $table = 'users';
    public $incrementing = true;
    protected $fillable = [
        'id_user',
        'nama_user',
        'username',
        'password',
        'kode_dep',
        'id_jab',
        'nama_leng',
        'alamat'
    ];


    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'id_jab', 'id_jab');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'kode_dep', 'kode_dep');
    }

}
