<?php

namespace App\Service\Contracts;

interface IRegistrasiService
{
    public function GenerateKodePeserta($peserta_id);
    public function CekRegistrasiPeserta($peserta_id);
    public function StorePembayaran($data);
    public function StoreDataPeserta($data);
    public function GetLatestPembayaranByPeserta($peserta_id);
    public function RenameAndDeletePembayaran($peserta_id);
    public function GetPesertas();
    public function GetInfoPeserta($peserta_id);
    public function VerifyPayment($pembayaran_id, $statusVerifikasi, $admin_id);
    public function GetKTMPeserta($peserta_id);
}