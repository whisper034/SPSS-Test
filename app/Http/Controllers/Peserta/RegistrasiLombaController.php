<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Model\Requests\Registrasi\PembayaranLombaPostRequest;
use App\Model\Requests\Registrasi\DataPesertaPostRequest;
use App\Service\Contracts\IDashboardService;
use App\Service\Contracts\IRegistrasiService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RegistrasiLombaController extends Controller
{
    private $registrasiService;

    public function __construct (
        IRegistrasiService $registrasiService
    ) {
        $this->middleware(['auth', 'verified', 'registered']);
        $this->registrasiService = $registrasiService;
    }

    public function showFormPembayaran()
    {
        return view('peserta.pembayaran');
    }

    public function submitPembayaran(PembayaranLombaPostRequest $request)
    {
        $data = $request->validatedIntoCollection()->merge([
            'peserta' => Auth::user(),
            'file' => $request->file('BuktiTransfer')
        ]);
        $pembayaran = $this->registrasiService->StorePembayaran($data);
        return redirect()->route('dashboard');
    }

    public function resubmitPembayaran()
    {
        $peserta_id = Auth::id();
        $pembayaran = $this->registrasiService->GetLatestPembayaranByPeserta($peserta_id);
        if ($pembayaran->StatusVerifikasi == -1){
            $this->registrasiService->RenameAndDeletePembayaran($peserta_id);
        }
        return redirect()->route('dashboard');
    }

    public function showFormDataPeserta()
    {
        return view('peserta.data');
    }

    public function submitDataPeserta(DataPesertaPostRequest $request)
    {
        $data = $this->separateDataPeserta($request->validatedIntoCollection())->merge([
            'peserta' => Auth::user(),
            'file_ktm1' => $request->file('Peserta1_KTM'),
            'file_ktm2' => $request->file('Peserta2_KTM'),
            'file_ktm3' => $request->file('Peserta3_KTM')
        ]);
        $this->registrasiService->StoreDataPeserta($data);
        return redirect()->route('dashboard');
    }

    private function separateDataPeserta($data)
    {
        $peserta1 = $data->filter(function ($value, $key)
        {
            return Str::contains($key, 'Peserta1');
        })->keyBy(function ($value, $key)
        {
            return Str::replaceFirst('Peserta1_', '', $key);
        });

        $peserta2 = $data->filter(function ($value, $key)
        {
            return Str::contains($key, 'Peserta2');
        })->keyBy(function ($value, $key)
        {
            return Str::replaceFirst('Peserta2_', '', $key);
        });

        $peserta3 = $data->filter(function ($value, $key)
        {
            return Str::contains($key, 'Peserta3');
        })->keyBy(function ($value, $key)
        {
            return Str::replaceFirst('Peserta3_', '', $key);
        });

        return collect([
            'Peserta1' => $peserta1, 'Peserta2' => $peserta2, 'Peserta3' => $peserta3
        ]);
    }
}
