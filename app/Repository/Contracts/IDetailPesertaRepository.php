<?php

namespace App\Repository\Contracts;

interface IDetailPesertaRepository
{
    public function FindByPeserta($peserta_id);
}