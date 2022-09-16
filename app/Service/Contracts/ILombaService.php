<?php

namespace App\Service\Contracts;

interface ILombaService
{
    public function GetJawabanByPesertaAndTahap($peserta_id, $tahap_id);
    public function SubmitAnswer($data);
    public function FinaliseAnswer($peserta_id, $tahap_id);
    public function CheckDownloadEligibility($peserta, $kodeFile);
    public function DownloadAnswer($answerFileParam, $peserta, $admin_id = null);
    public function GetJawabansWithPesertaByTahap($tahap_id);
    public function ChoosePesertaToNextPhase($kodePesertaList, $tahap_id);
}