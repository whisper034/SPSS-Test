<?php

namespace App\Service\Modules;

use App\Model\DB\Pembayaran;
use App\Model\DB\DetailPeserta;
use App\Model\Lookups\Registrasi;
use App\Model\Lookups\Tahap;
use App\Model\Lookups\Timeline;
use App\Service\Contracts\IRegistrasiService;
use App\Repository\Contracts\IAdminRepository;
use App\Repository\Contracts\IPesertaRepository;
use App\Repository\Contracts\IPembayaranRepository;
use App\Repository\Contracts\IDetailPesertaRepository;
use App\Repository\Contracts\ITimelineRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RegistrasiService implements IRegistrasiService
{
    private $adminRepository;
    private $pesertaRepository;
    private $pembayaranRepository;
    private $detailPesertaRepository;
    private $timelineRepository;

    public function __construct(
        IAdminRepository $adminRepository,
        IPesertaRepository $pesertaRepository,
        IPembayaranRepository $pembayaranRepository,
        IDetailPesertaRepository $detailPesertaRepository,
        ITimelineRepository $timelineRepository
    ) {
        $this->adminRepository = $adminRepository;
        $this->pesertaRepository = $pesertaRepository;
        $this->pembayaranRepository = $pembayaranRepository;
        $this->detailPesertaRepository = $detailPesertaRepository;
        $this->timelineRepository = $timelineRepository;
    }

    public function GenerateKodePeserta($peserta_id)
    {
        $peserta = $this->pesertaRepository->Find($peserta_id);
        $peserta->KodePeserta = sprintf("%03d", $peserta->id) . substr($peserta->NoHP, -2);
        return $this->pesertaRepository->InsertUpdate($peserta);
    }

    public function CekRegistrasiPeserta($peserta_id)
    {
        $now = Carbon::now();
        $waktuAkhirRegistrasi = $this->timelineRepository->Find(Timeline::AKHIR_PENDAFTARAN);
        $pembayaran = $this->pembayaranRepository->FindByPeserta($peserta_id);

        if (is_null($pembayaran) && $now->greaterThan($waktuAkhirRegistrasi->DateTime)){
            return 0;
        }

        if (is_null($pembayaran)) {
            return Registrasi::PEMBAYARAN;
        }

        $detail_peserta = $this->detailPesertaRepository->FindByPeserta($peserta_id);
        if (is_null($detail_peserta) || $detail_peserta->isEmpty()){
            return Registrasi::DATA_PESERTA;
        }

        return 0;
    }

    public function StorePembayaran($data)
    {
        $peserta = $data['peserta'];
        $file = $data['file'];
        $storedFileName = sprintf("BuktiTransfer-%s-%s.%s"
            , $peserta->KodePeserta
            , str_replace(' ', '_', $peserta->name)
            , $file->extension()
        );
        Storage::putFileAs('bukti_pembayaran', $file, $storedFileName);

        $pembayaran = new Pembayaran();
        $pembayaran->peserta_id = $peserta->id;
        $pembayaran->Pengirim = $data['NamaPengirim'];
        $pembayaran->Bank = $data['NamaBank'];
        $pembayaran->BuktiTransfer = $storedFileName;
        return $this->pembayaranRepository->InsertUpdate($pembayaran);
    }

    public function StoreDataPeserta($data)
    {
        $peserta = $data['peserta'];
        $ktmFilePeserta1 = $data['file_ktm1'];
        $ktmFilePeserta2 = $data['file_ktm2'];
        $ktmFilePeserta3 = $data['file_ktm3'];

        Storage::makeDirectory('peserta//'.$peserta->KodePeserta);
        Storage::makeDirectory('peserta//'.$peserta->KodePeserta.'/ktm');

        $ktmFolderPath = 'peserta//'.$peserta->KodePeserta.'/ktm';
        $ktmFileNameFormat = "KTM-%s-%s.%s";

        $ktmPeserta1FileName = sprintf($ktmFileNameFormat
            , $peserta->KodePeserta
            , str_replace(' ', '_', $data['Peserta1']['Nama'])
            , $ktmFilePeserta1->extension()
        );

        $ktmPeserta2FileName = sprintf($ktmFileNameFormat
            , $peserta->KodePeserta
            , str_replace(' ', '_', $data['Peserta2']['Nama'])
            , $ktmFilePeserta2->extension()
        );

        $ktmPeserta3FileName = sprintf($ktmFileNameFormat
            , $peserta->KodePeserta
            , str_replace(' ', '_', $data['Peserta3']['Nama'])
            , $ktmFilePeserta3->extension()
        );

        Storage::putFileAs($ktmFolderPath, $ktmFilePeserta1, $ktmPeserta1FileName);
        Storage::putFileAs($ktmFolderPath, $ktmFilePeserta2, $ktmPeserta2FileName);
        Storage::putFileAs($ktmFolderPath, $ktmFilePeserta3, $ktmPeserta3FileName);

        $detail_peserta1 = new DetailPeserta();
        $data_peserta1 = $data['Peserta1'];

        $detail_peserta1->peserta_id = $peserta->id;
        $detail_peserta1->Nama = $data_peserta1['Nama'];
        $detail_peserta1->Jurusan = $data_peserta1['Jurusan'];
        $detail_peserta1->NoHP = $data_peserta1['NoHP'];
        $detail_peserta1->IDLine = $data_peserta1['IDLine'];
        $detail_peserta1->KTM = $ktmPeserta1FileName;
        $this->detailPesertaRepository->InsertUpdate($detail_peserta1);

        $detail_peserta2 = new DetailPeserta();
        $data_peserta2 = $data['Peserta2'];

        $detail_peserta2->peserta_id = $peserta->id;
        $detail_peserta2->Nama = $data_peserta2['Nama'];
        $detail_peserta2->Jurusan = $data_peserta2['Jurusan'];
        $detail_peserta2->NoHP = $data_peserta2['NoHP'];
        $detail_peserta2->IDLine = $data_peserta2['IDLine'];
        $detail_peserta2->KTM = $ktmPeserta2FileName;
        $this->detailPesertaRepository->InsertUpdate($detail_peserta2);

        $detail_peserta3 = new DetailPeserta();
        $data_peserta3 = $data['Peserta3'];

        $detail_peserta3->peserta_id = $peserta->id;
        $detail_peserta3->Nama = $data_peserta3['Nama'];
        $detail_peserta3->Jurusan = $data_peserta3['Jurusan'];
        $detail_peserta3->NoHP = $data_peserta3['NoHP'];
        $detail_peserta3->IDLine = $data_peserta3['IDLine'];
        $detail_peserta3->KTM = $ktmPeserta3FileName;
        $this->detailPesertaRepository->InsertUpdate($detail_peserta3);
    }

    public function GetLatestPembayaranByPeserta($peserta_id)
    {
        return $this->pembayaranRepository->FindByPeserta($peserta_id);
    }

    public function RenameAndDeletePembayaran($peserta_id)
    {
        $all_pembayaran = $this->pembayaranRepository->FindAllWithDeletedByPeserta($peserta_id);
        $latest_pembayaran = $all_pembayaran->where('deleted_at', null)->first();

        $latestFileName = $latest_pembayaran->BuktiTransfer;
        $countPembayaran = $all_pembayaran->count();
        $newFileName = Str::replaceLast('.', '-Attempt-'.$countPembayaran.'.', $latestFileName);

        Storage::move('bukti_pembayaran\\'.$latestFileName, 'bukti_pembayaran\\'.$newFileName);
        $latest_pembayaran->BuktiTransfer = $newFileName;
        $latest_pembayaran->deleted_at = Carbon::now();
        $this->pembayaranRepository->InsertUpdate($latest_pembayaran);
    }

    public function GetPesertas()
    {
        $pesertas = $this->pesertaRepository->FindAll();
        return $pesertas->map(function ($item, $key)
        {
            return [
                'id' => $item->id,
                'KodePeserta' => $item->KodePeserta ?? 'Email Unverified',
                'Nama' => $item->name,
                'email' => $item->email,
                'Tahap' => ($item->tahap_id == Tahap::SELESAI) 
                            ? 'Tahap 3' 
                            : Tahap::GetConstantName($item->tahap_id),
                'Status Registrasi' => $this->CekStatusRegistrasi($item->id)
            ];
        });
    }

    private function CekStatusRegistrasi($peserta_id)
    {
        $pembayaran = $this->pembayaranRepository->FindByPeserta($peserta_id);
        if (is_null($pembayaran)){
            return 'In Progress';
        }

        $detail_peserta = $this->detailPesertaRepository->FindByPeserta($peserta_id);
        if ($detail_peserta->isEmpty()){
            return 'In Progress';
        }

        if (is_null($pembayaran->StatusVerifikasi)){
            return 'Needs Verification';
        }
        else if ($pembayaran->StatusVerifikasi == -1){
            return 'Verification Failed';
        }
        else {
            return 'Finished';
        }
    }

    public function GetInfoPeserta($peserta_id)
    {
        $result = [];
        $peserta = $this->pesertaRepository->Find($peserta_id);
        $result = [
            'Account' => [
                'id' => $peserta->id,
                'Kode Peserta' => $peserta->KodePeserta ?? 'Email Unverified',
                'Nama' => $peserta->name,
                'Email' => $peserta->email,
                'No. HP' => $peserta->NoHP,
                'Asal Universitas' => $peserta->AsalUniversitas
            ]
        ];

        $pembayaran = $this->pembayaranRepository->FindByPeserta($peserta_id);
        if (!is_null($pembayaran)){
            $admin_verifier = $this->adminRepository->Find($pembayaran->admin_id ?? 0);
            $result['Payment'] = [
                'id' => $pembayaran->id,
                'Nama Pengirim' => $pembayaran->Pengirim,
                'Nama Bank' => $pembayaran->Bank,
                'Waktu Submit' => $pembayaran->created_at,
                'Status Verifikasi' => $pembayaran->StatusVerifikasi,
                'Verified By' => (is_null($admin_verifier) ? '' : $admin_verifier->name),
            ];
        }

        $detail_peserta = $this->detailPesertaRepository->FindByPeserta($peserta_id);
        if (!is_null($detail_peserta) && !$detail_peserta->isEmpty()){
            $result['Detail'] = [];
            $result['Detail']['Peserta'] = array_merge($detail_peserta
                    ->makeHidden(['created_at', 'updated_at', 'deleted_at', 'peserta_id'])
                    ->toArray()
            );
            $result['Detail']['Waktu Submit'] = $detail_peserta->first()->created_at;
        }
        return $result;
    }

    public function VerifyPayment($pembayaran_id, $statusVerifikasi, $admin_id)
    {
        $pembayaran = $this->pembayaranRepository->Find($pembayaran_id);
        $pembayaran->StatusVerifikasi = $statusVerifikasi;
        $pembayaran->admin_id = $admin_id;
        $this->pembayaranRepository->InsertUpdate($pembayaran);

        if ($statusVerifikasi == 1){
            $peserta = $this->pesertaRepository->Find($pembayaran->peserta_id);
            $peserta->tahap_id = Tahap::TAHAP_1;
            $this->pesertaRepository->InsertUpdate($peserta);
        }
    }

    public function GetKTMPeserta($peserta_id)
    {
        $detail_peserta = $this->detailPesertaRepository->FindByPeserta($peserta_id);
        if (is_null($detail_peserta) || $detail_peserta->isEmpty()){
            return collect([]);
        }

        $peserta = $this->pesertaRepository->Find($peserta_id);
        return collect([
            'Kode Peserta' => $peserta->KodePeserta,
            'KTM' => $detail_peserta->pluck('KTM')
        ]);
    }
}