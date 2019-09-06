<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    protected $table = 'karyawan';

    protected $primaryKey = 'kd_kywn';

    protected $fillable = [
        'kd_kywn',
        'nm_kywn',
        'jabatan'
    ];

    public $incrementing = false;

    public $timestamps = false;
}
