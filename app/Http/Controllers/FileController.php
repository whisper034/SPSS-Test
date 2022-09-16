<?php

namespace App\Http\Controllers;

use App\Model\Lookups\KodeFile;
use App\Service\Contracts\ILombaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    private $downloadFileName = [
        KodeFile::PANDUAN_TAHAP_1 => 'Panduan Tahap 1.pdf',
        KodeFile::SOAL_TAHAP_1 => 'Soal Tahap 1.pdf',
        KodeFile::PANDUAN_TAHAP_2 => 'Panduan Tahap 2.pdf',
        KodeFile::SOAL_TAHAP_2 => 'Soal Tahap 2.pdf',
        KodeFile::PANDUAN_TAHAP_3 => 'Panduan Tahap 3.pdf',
        KodeFile::SOAL_TAHAP_3 => 'Soal Tahap 3.pdf',
        KodeFile::SYARAT_KETENTUAN_LOMBA => 'Syarat dan Ketentuan Lomba.pdf',
    ];

    private $storageFileName = [
        KodeFile::PANDUAN_TAHAP_1 => 'Panduan Tahap 1.pdf',
        KodeFile::SOAL_TAHAP_1 => 'Soal Tahap 1.pdf',
        KodeFile::PANDUAN_TAHAP_2 => 'Panduan Tahap 2.pdf',
        KodeFile::SOAL_TAHAP_2 => 'Soal Tahap 2.pdf',
        KodeFile::PANDUAN_TAHAP_3 => 'Panduan Tahap 3.pdf',
        KodeFile::SOAL_TAHAP_3 => 'Soal Tahap 3.pdf',
        KodeFile::SYARAT_KETENTUAN_LOMBA => 'Syarat dan Ketentuan Lomba.pdf',
    ];

    private $generalFile = [
        KodeFile::SYARAT_KETENTUAN_LOMBA
    ];

    private $authRequiredFile = [
        KodeFile::PANDUAN_TAHAP_1,
        KodeFile::SOAL_TAHAP_1,
        KodeFile::PANDUAN_TAHAP_2,
        KodeFile::SOAL_TAHAP_2,
        KodeFile::PANDUAN_TAHAP_3,
        KodeFile::SOAL_TAHAP_3,
    ];

    private $lombaService;

    public function __construct(ILombaService $lombaService) {
        $this->middleware(['auth', 'verified', 'registered'])->except('downloadUmum');
        $this->lombaService = $lombaService;
    }

    public function downloadUmum(Request $request)
    {
        try {
            $fileParam = $request->query('file');
            if (is_null($fileParam))
                throw new \Exception();

            $kodeFile = Crypt::decrypt($fileParam);
            if (!in_array($kodeFile, $this->generalFile))
                throw new \Exception();

            $filePath = storage_path('app/file/'.$this->storageFileName[$kodeFile]);
            if (!File::exists($filePath))
                throw new \Exception();
            
            return Storage::download('file/'.$this->storageFileName[$kodeFile]
                                    , $this->downloadFileName[$kodeFile]);
        } catch (\Exception $e) {
            return redirect('/');
        }
    }

    public function downloadLomba(Request $request)
    {
        try {
            $fileParam = $request->query('file');
            if (is_null($fileParam))
                throw new \Exception();

            $kodeFile = Crypt::decrypt($fileParam);
            if (!in_array($kodeFile, $this->authRequiredFile))
                throw new \Exception();

            if (!$this->lombaService->CheckDownloadEligibility(Auth::user(), $kodeFile))
                throw new \Exception();

            $filePath = storage_path('app/file/'.$this->storageFileName[$kodeFile]);
            if (!File::exists($filePath))
                throw new \Exception();
            
            return Storage::download('file/'.$this->storageFileName[$kodeFile]
                                    , $this->downloadFileName[$kodeFile]);
        } catch (\Exception $e) {
            // dd($e);
            return redirect()->route('dashboard');
        }
    }
}
