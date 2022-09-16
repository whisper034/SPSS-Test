<?php

namespace App\Service\Modules;

use App\Model\Lookups\StatusTahap;
use App\Model\Lookups\Tahap;
use App\Model\Lookups\Timeline;
use App\Service\Contracts\IDashboardService;
use Carbon\Carbon;
use App\Repository\Contracts\IJawabanRepository;
use App\Repository\Contracts\IPembayaranRepository;
use App\Repository\Contracts\ITimelineRepository;
use Illuminate\Support\Facades\Storage;

class DashboardService implements IDashboardService
{
    private $pembayaranRepository;
    private $timelineRepository;
    private $jawabanRepository;

    private $folderJawabanTahap = [
        Tahap::TAHAP_1 => 'tahap-1',
        Tahap::TAHAP_2 => 'tahap-2',
        Tahap::TAHAP_3 => 'tahap-3',
    ];

    public function __construct (
        IPembayaranRepository $pembayaranRepository, 
        ITimelineRepository $timelineRepository,
        IJawabanRepository $jawabanRepository
    ) {
        $this->pembayaranRepository = $pembayaranRepository;
        $this->timelineRepository = $timelineRepository;
        $this->jawabanRepository = $jawabanRepository;
    }

    public function CekRegistrasiPembayaran($peserta_id)
    {
        $now = Carbon::now();
        $waktuAkhirRegistrasi = $this->timelineRepository->Find(Timeline::AKHIR_PENDAFTARAN);
        $waktuAwalTahap1 = $this->timelineRepository->Find(Timeline::AWAL_TAHAP_1);
        $pembayaran = $this->pembayaranRepository->FindByPeserta($peserta_id);

        if (is_null($pembayaran) && $now->greaterThan($waktuAkhirRegistrasi->DateTime)){
            return ['StatusRegistrasi' => StatusTahap::GAGAL, 'StatusPembayaran' => 'late'];
        }
        else if (is_null($pembayaran->StatusVerifikasi)){
            return ['StatusRegistrasi' => StatusTahap::PROSES, 'StatusPembayaran' => 'process'];
        }
        else if ($pembayaran->StatusVerifikasi == -1){
            return ['StatusRegistrasi' => StatusTahap::GAGAL, 'StatusPembayaran' => 'fail'];
        }
        else if ($pembayaran->StatusVerifikasi == 1){
            return [
                'StatusRegistrasi' => StatusTahap::SUKSES, 
                'StatusPembayaran' => 'success',
                'Countdown' => $waktuAwalTahap1->DateTime
            ];
        }
        else {
            return ['StatusRegistrasi' => StatusTahap::MENUNGGU, 'StatusPembayaran' => 'waiting'];
        }
    }

    public function CekStatusLomba($peserta)
    {
        $initial_arr = [
            'Status' => StatusTahap::MENUNGGU,
            'Level' => 'Menunggu',
        ];
        $result = [
            'Tahap 1' => $initial_arr, 
            'Tahap 2' => $initial_arr, 
            'Tahap 3' => $initial_arr,
        ];
        $timeline_to_get = [
            Timeline::AWAL_TAHAP_1,
            Timeline::AKHIR_TAHAP_1,
            Timeline::PENGUMUMAN_TAHAP_1,
            Timeline::AWAL_TAHAP_2,
            Timeline::AKHIR_TAHAP_2,
            Timeline::PENGUMUMAN_TAHAP_2,
            Timeline::AWAL_PENGERJAAN_TAHAP_3,
            Timeline::AKHIR_PENGERJAAN_TAHAP_3,
            Timeline::PRESENTASI_TAHAP_3,
            Timeline::PENGUMUMAN_PEMENANG,
        ];

        $timeline_db_arr = $this->timelineRepository->FindAllWhereIn($timeline_to_get);
        $timeline_arr = $timeline_db_arr->mapWithKeys(function ($item)
        {
            return [$item['id'] => $item['DateTime']];
        });

        $tahap_id = $peserta->tahap_id;
        $now = Carbon::now();

        if ($tahap_id == Tahap::TAHAP_1){
            $hasilCek = $this->GetStatusTahap1($peserta, $timeline_arr);

            $result['Tahap 1']['Status'] = $hasilCek['Status'];
            $result['Tahap 1']['Level'] = $hasilCek['Level'];
            $result['Tahap 1']['Countdown'] = $hasilCek['Countdown'];
            if (array_key_exists('Submission', $hasilCek))
                $result['Tahap 1']['Submission'] = $hasilCek['Submission'];
        }
        else if ($tahap_id == Tahap::TAHAP_2){
            $result['Tahap 1']['Status'] = ($now->lessThan($timeline_arr[Timeline::PENGUMUMAN_TAHAP_1]))
                                           ? StatusTahap::MENUNGGU
                                           : StatusTahap::SUKSES;
            $hasilCek = $this->GetStatusTahap2($peserta, $timeline_arr);

            $result['Tahap 2']['Status'] = $hasilCek['Status'];
            $result['Tahap 2']['Level'] = $hasilCek['Level'];
            $result['Tahap 2']['Countdown'] = $hasilCek['Countdown'];
            if (array_key_exists('Submission', $hasilCek))
                $result['Tahap 2']['Submission'] = $hasilCek['Submission'];
        }
        else if ($tahap_id == Tahap::TAHAP_3){
            $result['Tahap 1']['Status'] = StatusTahap::SUKSES;
            $result['Tahap 2']['Status'] = ($now->lessThan($timeline_arr[Timeline::PENGUMUMAN_TAHAP_2]))
                                           ? StatusTahap::MENUNGGU
                                           : StatusTahap::SUKSES;
            
            $hasilCek = $this->GetStatusTahap3($peserta, $timeline_arr);
            $result['Tahap 3']['Status'] = $hasilCek['Status'];
            $result['Tahap 3']['Level'] = $hasilCek['Level'];
            $result['Tahap 3']['Countdown'] = $hasilCek['Countdown'];
            if (array_key_exists('Submission', $hasilCek))
                $result['Tahap 3']['Submission'] = $hasilCek['Submission'];
        }
        else if ($tahap_id == Tahap::SELESAI){
            $result['Tahap 1']['Status'] = StatusTahap::SUKSES;
            $result['Tahap 2']['Status'] = StatusTahap::SUKSES;
            $announceWinner = ($now->lessThan($timeline_arr[Timeline::PENGUMUMAN_PEMENANG]));
            $result['Tahap 3']['Status'] = $announceWinner ? StatusTahap::MENUNGGU : StatusTahap::SUKSES;
            $result['Tahap 3']['Level'] = $announceWinner ? 'Pengumuman' : 'Akhir';
            $result['Tahap 3']['Countdown'] = $timeline_arr[Timeline::PENGUMUMAN_PEMENANG];
        }

        return $result;
    }

    private function GetStatusTahap1($peserta, $timeline_arr)
    {
        $jawaban = $this->jawabanRepository->FindByPesertaAndTahap($peserta->id, Tahap::TAHAP_1);
        $now = Carbon::now();
        $timelineToShow = 0;
        $result = [];
        if ($now->lessThan($timeline_arr[Timeline::AWAL_TAHAP_1])){
            $result = ['Status' => StatusTahap::MENUNGGU, 'Level' => 'Menunggu'];
            $timelineToShow = Timeline::AWAL_TAHAP_1;
        }
        else if ($now->lessThan($timeline_arr[Timeline::AKHIR_TAHAP_1]) 
            && (is_null($jawaban) 
            || (!is_null($jawaban) && is_null($jawaban->WaktuFinalisasi))))
        {
            $result = ['Status' => StatusTahap::PROSES, 'Level' => 'Pengerjaan'];
            if (!is_null($jawaban) && is_null($jawaban->WaktuFinalisasi))
                $result['Submission'] = $this->GetSubmissionDetail($jawaban, $peserta);
            $timelineToShow = Timeline::AKHIR_TAHAP_1;
        }
        else if ($now->lessThan($timeline_arr[Timeline::PENGUMUMAN_TAHAP_1])){
            $result = ['Status' => StatusTahap::MENUNGGU, 'Level' => 'Pengumuman'];
            $timelineToShow = Timeline::PENGUMUMAN_TAHAP_1;
        }
        else {
            $result = ['Status' => StatusTahap::GAGAL, 'Level' => 'Gagal'];
        }

        if ($timelineToShow > 0)
            $result['Countdown'] = $timeline_arr[$timelineToShow];
        else
            $result['Countdown'] = $now;

        return $result;
    }

    private function GetStatusTahap2($peserta, $timeline_arr)
    {
        $jawaban = $this->jawabanRepository->FindByPesertaAndTahap($peserta->id, Tahap::TAHAP_2);
        $now = Carbon::now();
        $timelineToShow = 0;
        $result = [];
        if ($now->lessThan($timeline_arr[Timeline::PENGUMUMAN_TAHAP_1])){
            $result = ['Status' => StatusTahap::MENUNGGU, 'Level' => 'Menunggu Lanjut'];
            $timelineToShow = Timeline::PENGUMUMAN_TAHAP_1;
        }
        else if ($now->lessThan($timeline_arr[Timeline::AWAL_TAHAP_2])){
            $result = ['Status' => StatusTahap::MENUNGGU, 'Level' => 'Menunggu Babak'];
            $timelineToShow = Timeline::AWAL_TAHAP_2;
        }
        else if ($now->lessThan($timeline_arr[Timeline::AKHIR_TAHAP_2]) 
            && (is_null($jawaban) 
            || (!is_null($jawaban) && is_null($jawaban->WaktuFinalisasi))))
        {
            $result = ['Status' => StatusTahap::PROSES, 'Level' => 'Pengerjaan'];
            if (!is_null($jawaban) && is_null($jawaban->WaktuFinalisasi))
                $result['Submission'] = $this->GetSubmissionDetail($jawaban, $peserta);
            $timelineToShow = Timeline::AKHIR_TAHAP_2;
        }
        else if ($now->lessThan($timeline_arr[Timeline::PENGUMUMAN_TAHAP_2])){
            $result = ['Status' => StatusTahap::MENUNGGU, 'Level' => 'Pengumuman'];
            $timelineToShow = Timeline::PENGUMUMAN_TAHAP_2;
        }
        else {
            $result = ['Status' => StatusTahap::GAGAL, 'Level' => 'Gagal'];
        }

        if ($timelineToShow > 0)
            $result['Countdown'] = $timeline_arr[$timelineToShow];
        else
            $result['Countdown'] = $now;

        return $result;
    }

    private function GetStatusTahap3($peserta, $timeline_arr)
    {
        $jawaban = $this->jawabanRepository->FindByPesertaAndTahap($peserta->id, Tahap::TAHAP_3);
        $now = Carbon::now();
        $timelineToShow = 0;
        $result = [];
        if ($now->lessThan($timeline_arr[Timeline::PENGUMUMAN_TAHAP_2])){
            $result = ['Status' => StatusTahap::MENUNGGU, 'Level' => 'Menunggu Lanjut'];
            $timelineToShow = Timeline::PENGUMUMAN_TAHAP_2;
        }
        else if ($now->lessThan($timeline_arr[Timeline::AWAL_PENGERJAAN_TAHAP_3])){
            $result = ['Status' => StatusTahap::MENUNGGU, 'Level' => 'Menunggu Babak'];
            $timelineToShow = Timeline::AWAL_PENGERJAAN_TAHAP_3;
        }
        else if ($now->lessThan($timeline_arr[Timeline::AKHIR_PENGERJAAN_TAHAP_3]) 
            && (is_null($jawaban) 
            || (!is_null($jawaban) && is_null($jawaban->WaktuFinalisasi))))
        {
            $result = ['Status' => StatusTahap::PROSES, 'Level' => 'Pengerjaan'];
            if (!is_null($jawaban) && is_null($jawaban->WaktuFinalisasi))
                $result['Submission'] = $this->GetSubmissionDetail($jawaban, $peserta);
            $timelineToShow = Timeline::AKHIR_PENGERJAAN_TAHAP_3;
        }
        else if ($now->lessThan($timeline_arr[Timeline::PRESENTASI_TAHAP_3])){
            $result = ['Status' => StatusTahap::MENUNGGU, 'Level' => 'Presentasi'];
            $timelineToShow = Timeline::PRESENTASI_TAHAP_3;
        }
        else if ($now->lessThan($timeline_arr[Timeline::PENGUMUMAN_PEMENANG])){
            $result = ['Status' => StatusTahap::MENUNGGU, 'Level' => 'Pengumuman'];
            $timelineToShow = Timeline::PENGUMUMAN_PEMENANG;
        }
        else {
            $result = ['Status' => StatusTahap::GAGAL, 'Level' => 'Gagal'];
        }

        if ($timelineToShow > 0)
            $result['Countdown'] = $timeline_arr[$timelineToShow];
        else
            $result['Countdown'] = $now;

        return $result;
    }

    private function GetSubmissionDetail($jawaban, $peserta)
    {
        $filePath = join('/', [
            'peserta',
            $peserta->KodePeserta,
            $this->folderJawabanTahap[$peserta->tahap_id],
            $jawaban->FileSubmit
        ]);
        return [
            'Upload Date' => $jawaban->WaktuSubmit->toDateTimeString(),
            'Name' => $jawaban->FileName,
            'Size' => Storage::size($filePath),
            'Timestamp Submit' => $jawaban->WaktuSubmit->timestamp,
            'File Submit' => $jawaban->FileSubmit
        ];
    }
}
