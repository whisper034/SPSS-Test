<?php

namespace App\Repository\Contracts;

interface IPembayaranRepository
{
    public function FindByPeserta($peserta_id);
    public function FindAllWithDeletedByPeserta($peserta_id);
    public function FindAllByStatusVerifikasi($status_verifikasi);
}