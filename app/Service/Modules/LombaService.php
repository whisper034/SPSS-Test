<?php

namespace App\Service\Modules;

use App\Model\DB\Jawaban;
use App\Model\Lookups\Tahap;
use App\Model\Lookups\Timeline;
use App\Model\Lookups\KodeFile;
use App\Service\Contracts\ILombaService;
use App\Repository\Contracts\IAdminRepository;
use App\Repository\Contracts\IJawabanRepository;
use App\Repository\Contracts\IPesertaRepository;
use App\Repository\Contracts\ITimelineRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LombaService implements ILombaService
{
    private $adminRepository;

    private $jawabanRepository;

    private $pesertaRepository;

    private $timelineRepository;

    private $folderJawabanTahap = [
        Tahap::TAHAP_1 => 'tahap-1',
        Tahap::TAHAP_2 => 'tahap-2',
        Tahap::TAHAP_3 => 'tahap-3',
    ];

    public function __construct(
        IAdminRepository $adminRepository,
        IJawabanRepository $jawabanRepository,
        IPesertaRepository $pesertaRepository,
        ITimelineRepository $timelineRepository
    ) {
        $this->adminRepository = $adminRepository;
        $this->jawabanRepository = $jawabanRepository;
        $this->pesertaRepository = $pesertaRepository;
        $this->timelineRepository = $timelineRepository;
    }

    public function GetJawabanByPesertaAndTahap($peserta_id, $tahap_id)
    {
        return $this->jawabanRepository->FindByPesertaAndTahap($peserta_id, $tahap_id);
    }

    public function SubmitAnswer($data)
    {
        $peserta = $data['peserta'];
        $tahap_id = $peserta->tahap_id;
        $file = $data['FileSubmit'];
        $storedFileName = sprintf("%s-%d-%s.%s"
            , $peserta->KodePeserta
            , $tahap_id - 1
            , (string) Str::uuid()
            , $file->extension()
        );

        $directories = collect(Storage::directories('peserta/'.$peserta->KodePeserta));
        $folderJawaban = join('/', [
            'peserta',
            $peserta->KodePeserta,
            $this->folderJawabanTahap[$tahap_id]
        ]);
        if(!$directories->contains($folderJawaban)){
            Storage::makeDirectory($folderJawaban);
        }

        $existingAnswer = $this->jawabanRepository->FindByPesertaAndTahap($peserta->id, $tahap_id);
        if (!is_null($existingAnswer)){
            $file_path = storage_path(join('\\', [
                'app\peserta',
                $peserta->KodePeserta,
                $this->folderJawabanTahap[$tahap_id],
                $existingAnswer->FileSubmit
            ]));
            if (File::exists($file_path)){
                Storage::delete($folderJawaban.'/'.$existingAnswer->FileSubmit);
            }
        }

        Storage::putFileAs($folderJawaban, $file, $storedFileName);
        
        if (!is_null($existingAnswer))
            $jawaban = $existingAnswer;
        else
            $jawaban = new Jawaban();
        
        $jawaban->peserta_id = $peserta->id;
        $jawaban->tahap_id = $tahap_id;
        $jawaban->FileSubmit = $storedFileName;
        $jawaban->FileName = $file->getClientOriginalName();
        $jawaban->WaktuSubmit = Carbon::now();

        $this->jawabanRepository->InsertUpdate($jawaban);
    }

    public function FinaliseAnswer($peserta_id, $tahap_id)
    {
        $jawaban = $this->jawabanRepository->FindByPesertaAndTahap($peserta_id, $tahap_id);
        $jawaban->WaktuFinalisasi = Carbon::now();
        $this->jawabanRepository->InsertUpdate($jawaban);
    }

    public function CheckDownloadEligibility($peserta, $kodeFile)
    {
        $mapAllowedKodeFileWithTahap = [
            KodeFile::PANDUAN_TAHAP_1 => Tahap::TAHAP_1,
            KodeFile::SOAL_TAHAP_1 => Tahap::TAHAP_1,
            KodeFile::PANDUAN_TAHAP_2 => Tahap::TAHAP_2,
            KodeFile::SOAL_TAHAP_2 => Tahap::TAHAP_2,
            KodeFile::PANDUAN_TAHAP_3 => Tahap::TAHAP_3,
            KodeFile::SOAL_TAHAP_3 => Tahap::TAHAP_3,
        ];

        $mapAllowedKodeFileWithTimeline = [
            KodeFile::PANDUAN_TAHAP_1 => [
                'min-lesser' => Timeline::AWAL_PENDAFTARAN, 
                'max-greater' => Timeline::AWAL_TAHAP_1
            ],
            KodeFile::SOAL_TAHAP_1 => [
                'min-lesser' => Timeline::AWAL_TAHAP_1, 
                'max-greater' => Timeline::AKHIR_TAHAP_1
            ],
            KodeFile::PANDUAN_TAHAP_2 => [
                'min-lesser' => Timeline::PENGUMUMAN_TAHAP_1, 
                'max-greater' => Timeline::AWAL_TAHAP_2
            ],
            KodeFile::SOAL_TAHAP_2 => [
                'min-lesser' => Timeline::AWAL_TAHAP_2, 
                'max-greater' => Timeline::AKHIR_TAHAP_2
            ],
            KodeFile::PANDUAN_TAHAP_3 => [
                'min-lesser' => Timeline::PENGUMUMAN_TAHAP_2, 
                'max-greater' => Timeline::AWAL_PENGERJAAN_TAHAP_3
            ],
            KodeFile::SOAL_TAHAP_3 => [
                'min-lesser' => Timeline::AWAL_PENGERJAAN_TAHAP_3, 
                'max-greater' => Timeline::AKHIR_PENGERJAAN_TAHAP_3
            ],
        ];
        
        $requiredTahap = $mapAllowedKodeFileWithTahap[$kodeFile];
        $timelines = $this->timelineRepository->FindTwoLessThanAndGreaterOrEqualThanAndWhereIn(Carbon::now()->toDateTimeString(), [
            Timeline::AWAL_PENDAFTARAN, Timeline::AKHIR_PENDAFTARAN, Timeline::AWAL_TAHAP_1, 
            Timeline::AKHIR_TAHAP_1, Timeline::PENGUMUMAN_TAHAP_1, Timeline::AWAL_TAHAP_2, 
            Timeline::AKHIR_TAHAP_2, Timeline::PENGUMUMAN_TAHAP_2, Timeline::AWAL_PENGERJAAN_TAHAP_3, 
            Timeline::AKHIR_PENGERJAAN_TAHAP_3
        ]);

        if (is_null($timelines['lesser']) || is_null($timelines['greater']))
            return false;
        
        if ($timelines['lesser']->id < $mapAllowedKodeFileWithTimeline[$kodeFile]['min-lesser']
            || $timelines['greater']->id > $mapAllowedKodeFileWithTimeline[$kodeFile]['max-greater'])
                return false;

        if ($peserta->tahap_id != $mapAllowedKodeFileWithTahap[$kodeFile])
            return false;

        return true;
    }

    public function DownloadAnswer($answerFileParam, $peserta, $admin_id = null)
    {
        $mapAllowedTimelineToDownload = [
            Tahap::TAHAP_1 => [
                'min-lesser' => Timeline::AWAL_TAHAP_1, 
                'max-greater' => Timeline::AKHIR_TAHAP_1
            ],
            Tahap::TAHAP_2 => [
                'min-lesser' => Timeline::AWAL_TAHAP_2, 
                'max-greater' => Timeline::AKHIR_TAHAP_2
            ],
            Tahap::TAHAP_3 => [
                'min-lesser' => Timeline::AWAL_PENGERJAAN_TAHAP_3, 
                'max-greater' => Timeline::AKHIR_PENGERJAAN_TAHAP_3
            ],
        ];
        $result = ['Downloadable' => false, 'File Path' => '', 'Download File Name' => ''];

        if (is_null($admin_id)){
            $answer = $this->jawabanRepository->FindByPesertaAndTahap($peserta->id, $peserta->tahap_id);
            if (is_null($answer))
                return $result;
            
            if ($answer->FileSubmit !== $answerFileParam)
                return $result;

            $timelines = $this->timelineRepository->FindAllWhereIn([
                $mapAllowedTimelineToDownload[$peserta->tahap_id]['min-lesser'],
                $mapAllowedTimelineToDownload[$peserta->tahap_id]['max-greater']
            ]);
            
            $now = Carbon::now();
            if ($now->lessThan($timelines[0]) || $now->greaterThan($timelines[1]))
                return $result;
                
            if (!is_null($answer->WaktuFinalisasi))
                return $result;
        }
        else {
            $admin = $this->adminRepository->Find($admin_id);
            if (is_null($admin)){
                return $result;
            }

            $answer = $this->jawabanRepository->FindByFileSubmit($answerFileParam);
            if (is_null($answer)){
                return $result;
            }

            $peserta = $this->pesertaRepository->FindByJawaban($answer->id);
        }

        $filePath = storage_path(join('\\', [
            'app\peserta',
            $peserta->KodePeserta,
            $this->folderJawabanTahap[$peserta->tahap_id],
            $answer->FileSubmit
        ]));
        if (!File::exists($filePath))
            return $result;
        
        $result['Downloadable'] = true;
        $result['File Path'] = join('/', [
            'peserta', $peserta->KodePeserta, 
            $this->folderJawabanTahap[$peserta->tahap_id],
            $answer->FileSubmit
        ]);
        $result['Download File Name'] = $answer->FileName;
        return $result;
    }

    public function GetJawabansWithPesertaByTahap($tahap_id)
    {
        $result = $this->pesertaRepository->FindAllByTahapJoinJawabanAndJoinDetailPeserta($tahap_id);
        return $result->groupBy('KodePeserta')->map(function ($item, $key) use ($tahap_id)
        {
            $waktuSubmit = is_null($item[0]->WaktuSubmit) 
                            ? 'Belum Submit' 
                            : Carbon::parse($item[0]->WaktuSubmit)->format('d F Y H:i:s');

            $waktuFinalisasi = '';
            if ($waktuSubmit == 'Belum Submit'){
                $waktuFinalisasi = 'Belum Submit';
            }
            else if (is_null($item[0]->WaktuFinalisasi)){
                $waktuFinalisasi = 'Belum Finalisasi';
            }
            else {
                $waktuFinalisasi = Carbon::parse($item[0]->WaktuFinalisasi)->format('d F Y H:i:s');
            }

            $downloadUrl = '';
            if (!is_null($item[0]->FileSubmit)){
                $downloadUrl = route('download-data-lomba', [
                    'tahap_id' => $tahap_id,
                    'file' => Crypt::encrypt($item[0]->FileSubmit)
                ]);
            }

            return [
                'Kode Peserta' => $key,
                'Peserta 1' => $item[0]->Nama,
                'Peserta 2' => $item[1]->Nama,
                'Peserta 3' => $item[2]->Nama,
                'Nama File' => $item[0]->FileName ?? 'Belum Submit',
                'File Submit' => $item[0]->FileSubmit ?? '',
                'Waktu Submit' => $waktuSubmit,
                'Waktu Finalisasi' => $waktuFinalisasi,
                'Download URL' => $downloadUrl,
            ];
        })->values();
    }

    public function ChoosePesertaToNextPhase($kodePesertaList, $tahap_id)
    {
        $mapNextPhase = [
            Tahap::TAHAP_1 => Tahap::TAHAP_2,
            Tahap::TAHAP_2 => Tahap::TAHAP_3,
            Tahap::TAHAP_3 => Tahap::SELESAI,
        ];
        $nextTahapId = $mapNextPhase[$tahap_id];
        
        $pesertaList = $this->pesertaRepository->FindAllWhereInByKodePeserta($kodePesertaList);
        $pesertaList->each(function ($peserta, $key) use ($nextTahapId)
        {
            $peserta->tahap_id = $nextTahapId;
            $this->pesertaRepository->InsertUpdate($peserta);
        });
    }
}
