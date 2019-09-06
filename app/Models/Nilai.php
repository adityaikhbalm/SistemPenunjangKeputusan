<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    protected $table = 'nilai';

    protected $primarykey = ['kd_kywn', 'kd_krt', 'thn_periode'];

    protected $fillable = [
        'kd_kywn',
        'kd_krt',
        'nilai_kywn',
        'thn_periode'
    ];

    public $incrementing = false;

    public $timestamps = false;
}
