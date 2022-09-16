<?php

namespace App\Model\DB;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pembayaran extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'peserta_id', 'Pengirim', 'Bank', 'BuktiTransfer', 'StatusVerifikasi',
        
    ];
}
