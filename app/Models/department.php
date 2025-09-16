<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class department extends Model
{
    use SoftDeletes;
    protected $table = 'department';
    protected $fillable = ['kode_dep', 'nama_dep'];

}
