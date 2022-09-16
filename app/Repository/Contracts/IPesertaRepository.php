<?php

namespace App\Repository\Contracts;

interface IPesertaRepository
{
    public function FindByEmail($email);
    public function FindAllByTahapJoinJawabanAndJoinDetailPeserta($tahap_id);
    public function FindByJawaban($jawaban_id);
    public function FindAllWhereInByKodePeserta($kode_pesertas);
    public function FindAllWhereEmailVerifiedAtNotNull();
}