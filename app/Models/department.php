<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class department extends Model
{
    protected $table = 'department';
    protected $fillable = ['kode_dep', 'nama_dep'];

}
