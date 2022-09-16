<?php

namespace App\Model\DB;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jawaban extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'peserta_id', 'tahap_id', 'FileSubmit', 'FileName', 'WaktuSubmit', 'WaktuFinalisasi',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'WaktuSubmit' => 'datetime',
        'WaktuFinalisasi' => 'datetime',
    ];
}
