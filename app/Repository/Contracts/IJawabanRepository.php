<?php

namespace App\Repository\Contracts;

interface IJawabanRepository
{
    public function FindByPesertaAndTahap($peserta_id, $tahap_id);
    public function FindAllByTahap($tahap_id);
    public function FindByFileSubmit($fileSubmit);
}