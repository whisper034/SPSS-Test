<?php

namespace App\Repository\Repositories;

use App\Model\DB\Pembayaran;
use App\Repository\Base\BaseRepository;
use App\Repository\Contracts\IPembayaranRepository;

class PembayaranRepository extends BaseRepository implements IPembayaranRepository
{
    public function __construct() {
        parent::__construct(new Pembayaran());
    }

    public function FindByPeserta($peserta_id)
    {
        return Pembayaran::where('peserta_id', '=', $peserta_id)->first();
    }

    public function FindAllWithDeletedByPeserta($peserta_id)
    {
        return Pembayaran::withTrashed()->where('peserta_id', '=', $peserta_id)->get();
    }

    public function FindAllByStatusVerifikasi($status_verifikasi)
    {
        return Pembayaran::where('StatusVerifikasi', '=', $status_verifikasi)->get();
    }
}
