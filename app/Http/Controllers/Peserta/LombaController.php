<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Model\Requests\Lomba\SubmitAnswerPostRequest;
use App\Model\Requests\Lomba\FinaliseAnswerPostRequest;
use App\Service\Contracts\ILombaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;

class LombaController extends Controller
{
    private $lombaService;

    public function __construct(ILombaService $lombaService) {
        $this->middleware(['auth', 'verified', 'registered']);
        $this->lombaService = $lombaService;
    }

    public function submit(SubmitAnswerPostRequest $request)
    {
        $data = $request->validatedIntoCollection()
                        ->except('SubmitToken')
                        ->merge([
            'peserta' => Auth::user(),
        ]);
        $this->lombaService->SubmitAnswer($data);
        return redirect()->route('dashboard');
    }

    public function finalise(FinaliseAnswerPostRequest $request)
    {
        $peserta = Auth::user();
        $this->lombaService->FinaliseAnswer($peserta->id, $peserta->tahap_id);
        return redirect()->route('dashboard');
    }

    public function downloadAnswer(Request $request)
    {
        try {
            $fileParam = $request->query('file');
            if (is_null($fileParam))
                throw new \Exception();

            $answerFile = Crypt::decrypt($fileParam);
            $peserta = Auth::user();
            $checkResult = $this->lombaService->DownloadAnswer($answerFile, $peserta);
            if (!$checkResult['Downloadable'])
                throw new \Exception();
            
            return Storage::download($checkResult['File Path'], $checkResult['Download File Name']);
        } catch (\Exception $e) {
            dd($e);
            return redirect()->route('dashboard');
        }
    }
}
