<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Service\Contracts\IRegistrasiService;
use App\Model\Lookups\SessionKey;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class PesertaController extends Controller
{
    private $registrasiService;

    public function __construct(IRegistrasiService $registrasiService) {
        $this->registrasiService = $registrasiService;
        $this->middleware(['auth:admin']);
    }

    public function index()
    {
        $viewData = [
            'pesertas' => $this->registrasiService->GetPesertas()
        ];
        if (session()->has(SessionKey::DETAIL_PESERTA_REDIRECT)){
            $viewData['redirect_id'] = session(SessionKey::DETAIL_PESERTA_REDIRECT)['id'];
        }
        return view('admin.peserta', $viewData);
    }

    public function detail(Request $request)
    {
        $viewData = [
            'peserta' => $this->registrasiService->GetInfoPeserta($request->id)
        ];
        return view('admin.sub-view.detail-peserta', $viewData);
    }

    public function paymentPhoto($peserta_id)
    {
        $pembayaran = $this->registrasiService->GetLatestPembayaranByPeserta($peserta_id);
        $filePath = 'bukti_pembayaran/'.$pembayaran->BuktiTransfer;
        if (!Storage::exists($filePath)) {
            abort(404);
        }
        return response()->file(storage_path('app/'.$filePath), ['Content-Type' => 'image/jpeg']);
    }

    public function verifyPayment(Request $request)
    {
        $this->registrasiService->VerifyPayment(
            $request->pembayaran_id, $request->status, Auth::id()
        );
        return redirect('/admin/peserta');
    }

    public function downloadKtm($peserta_id)
    {
        $detailKtm = $this->registrasiService->GetKTMPeserta($peserta_id);
        if (is_null($detailKtm) || $detailKtm->isEmpty()){
            return redirect('/admin/peserta');
        }
        $zipPath = $this->CreateKtmZipFile($detailKtm);
        return response()->download($zipPath, 'KTM '.$detailKtm['Kode Peserta'].'.zip')->deleteFileAfterSend();
    }

    private function CreateKtmZipFile($detailKtm)
    {
        $ktmDirectory = 'peserta/'.$detailKtm['Kode Peserta'].'/ktm';
        $zip = new ZipArchive();
        $zipName = Carbon::now()->getTimestamp().'.zip';
        $zip->open($zipName, ZipArchive::CREATE | ZipArchive::OVERWRITE);
        foreach ($detailKtm['KTM'] as $fileName) {
            $filePath = $ktmDirectory.'/'.$fileName;
            if (Storage::exists($filePath)){
                $zip->addFile(storage_path('app/'.$filePath), $fileName);
            }
        }
        $zip->close();
        return public_path($zipName);
    }
}
