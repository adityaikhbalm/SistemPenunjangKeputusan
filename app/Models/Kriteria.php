<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    protected $table = 'kriteria';

    protected $primarykey = 'kd_krt';

    protected $fillable = [
        'kd_krt',
        'nm_krt',
        'bobot'
    ];

    public $incrementing = false;

    public $timestamps = false;

}
