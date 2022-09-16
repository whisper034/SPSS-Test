<?php

namespace App\Http\Controllers\Admin;

use App\Model\Lookups\Tahap;
use App\Http\Controllers\Controller;
use App\Service\Contracts\ILombaService;
use App\Service\Contracts\ITimelineService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use ZipArchive;

class LombaController extends Controller
{
    private $lombaService;
    private $timelineService;

    public function __construct(
        ILombaService $lombaService,
        ITimelineService $timelineService
    ) {
        $this->lombaService = $lombaService;
        $this->timelineService = $timelineService;
        $this->middleware(['auth:admin']);
    }

    public function index()
    {
        $viewData = [
            'tahap' => $this->timelineService->GetTahapDropdown()
        ];
        return view('admin.lomba', $viewData);
    }

    public function loadTable($tahap_id)
    {
        $dateCheck = $this->timelineService->GetLombaStartAndEndDate($tahap_id);
        $viewData = [
            'title' => Tahap::GetConstantName($tahap_id),
            'tahap_id' => $tahap_id,
            'startDate' => $dateCheck['Start Date']->valueOf(),
            'endDate' => $dateCheck['End Date']->valueOf(),
        ];
        return view('admin.sub-view.lomba-table', $viewData);
    }

    public function dataLomba($tahap_id)
    {
        $data = $this->lombaService->GetJawabansWithPesertaByTahap($tahap_id);
        return response()->json($data);
    }

    public function download(Request $request, $tahap_id)
    {
        $fileParam = $request->query('file');
        if (is_null($fileParam)){
            $result = $this->lombaService->GetJawabansWithPesertaByTahap($tahap_id);
            if (!$this->validateDownloadAll($result)){
                return redirect('/admin/lomba');
            }
            $zipPath = $this->CreateJawabanFileZip($result, $tahap_id);
            return response()->download($zipPath, 'Jawaban '.Tahap::GetConstantName($tahap_id).'.zip')->deleteFileAfterSend();
        }
        else {
            try {
                $answerFile = Crypt::decrypt($fileParam);

                $checkResult = $this->lombaService->DownloadAnswer($answerFile, null, Auth::id());
                if (!$checkResult['Downloadable'])
                    throw new \Exception();

                return Storage::download($checkResult['File Path'], $checkResult['Download File Name']);
            } catch (\Exception $e) {
                return redirect('/admin/lomba');
            }
        }
    }

    private function validateDownloadAll($lombaData)
    {
        if (is_null($lombaData) || $lombaData->isEmpty()){
            return false;
        }

        return $lombaData->contains(function ($data, $key)
        {
            if ($data['File Submit'] !== ''){
                return true;
            }
        });
    }

    private function CreateJawabanFileZip($fileData, $tahap_id)
    {
        $baseDirectory = 'peserta/{KodePeserta}/'.Tahap::FOLDER_JAWABAN[$tahap_id];
        $zip = new ZipArchive();
        $zipName = $zipName = Carbon::now()->getTimestamp().'.zip';
        $zip->open($zipName, ZipArchive::CREATE | ZipArchive::OVERWRITE);
        foreach ($fileData as $fileDetail) {
            if ($fileDetail['File Submit'] == ''){
                continue;
            }

            $filePath = Str::replaceFirst('{KodePeserta}', $fileDetail['Kode Peserta'], $baseDirectory).'/'.$fileDetail['File Submit'];
            if (Storage::exists($filePath)){
                $zip->addFile(storage_path('app/'.$filePath), $fileDetail['Nama File']);
            }
        }
        $zip->close();
        return public_path($zipName);
    }

    public function nextPhase(Request $request, $tahap_id)
    {
        $this->validateNextPhase($request->all());
        $this->lombaService->ChoosePesertaToNextPhase($request->input('KodePeserta'), $tahap_id);
        return redirect('/admin/lomba');
    }
    
    private function validateNextPhase($fields)
    {
        Validator::make($fields, [
            'KodePeserta' => ['required', 'array']
        ])->validate();
    }
}
