<?php

namespace App\Repository\Repositories;

use App\Model\DB\Jawaban;
use App\Repository\Base\BaseRepository;
use App\Repository\Contracts\IJawabanRepository;

class JawabanRepository extends BaseRepository implements IJawabanRepository
{
    public function __construct() {
        parent::__construct(new Jawaban());
    }

    public function FindByPesertaAndTahap($peserta_id, $tahap_id)
    {
        return Jawaban::where('peserta_id', '=', $peserta_id)
                      ->where('tahap_id', '=', $tahap_id)
                      ->first();
    }

    public function FindAllByTahapAndWhereInByPeserta($peserta_ids, $tahap_id)
    {
        return Jawaban::where('tahap_id', '=', $tahap_id)
                      ->whereIn('peserta_id', $peserta_ids)
                      ->get();
    }

    public function FindAllByTahap($tahap_id)
    {
        return Jawaban::where('tahap_id', '=', $tahap_id)->get();
    }

    public function FindByFileSubmit($fileSubmit)
    {
        return Jawaban::where('FileSubmit', '=', $fileSubmit)->first();
    }
}
