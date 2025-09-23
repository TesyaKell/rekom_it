<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class department extends Model
{
    use SoftDeletes;
    public $timestamps = false;
    public $incrementing = false;

    protected $table = 'department';
    protected $primaryKey = 'kode_dep';
    protected $fillable = [
        'kode_dep',
    'nama_dep',
    'created_by',
        'updated_by',
        'deleted_by'];

}
