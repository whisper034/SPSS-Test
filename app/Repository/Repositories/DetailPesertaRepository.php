<?php

namespace App\Repository\Repositories;

use App\Model\DB\DetailPeserta;
use App\Repository\Base\BaseRepository;
use App\Repository\Contracts\IDetailPesertaRepository;

class DetailPesertaRepository extends BaseRepository implements IDetailPesertaRepository
{
    public function __construct() {
        parent::__construct(new DetailPeserta());
    }

    public function FindByPeserta($peserta_id)
    {
        return DetailPeserta::where('peserta_id', '=', $peserta_id)->get();
    }
}
