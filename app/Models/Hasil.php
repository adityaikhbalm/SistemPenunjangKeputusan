<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hasil extends Model
{
  protected $table = 'hasil';

  protected $primarykey = ['kd_kywn', 'thn_periode', 'nilai_akhir'];

  protected $fillable = [
      'kd_kywn',
      'thn_periode',
      'nilai_akhir'
  ];

  public $incrementing = false;

  public $timestamps = false;
}
