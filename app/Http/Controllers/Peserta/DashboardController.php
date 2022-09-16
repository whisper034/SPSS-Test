<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Model\Lookups\StatusTahap;
use App\Model\Lookups\Tahap;
use App\Service\Contracts\IDashboardService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    private $dashboardService;

    protected $statusTahap = [
        "Registrasi" => StatusTahap::MENUNGGU,
        "Tahap 1" => StatusTahap::MENUNGGU,
        "Tahap 2" => StatusTahap::MENUNGGU,
        "Tahap 3" => StatusTahap::MENUNGGU,
    ];

    private $tahapViewFolder = [
        Tahap::REGISTRASI => 'registrasi',
        Tahap::TAHAP_1 => 'tahap-1',
        Tahap::TAHAP_2 => 'tahap-2',
        Tahap::TAHAP_3 => 'tahap-3',
        Tahap::SELESAI => 'tahap-3',
    ];

    private $statusTahapViewFile = [
        StatusTahap::MENUNGGU => 'waiting',
        StatusTahap::PROSES => 'process',
        StatusTahap::SUKSES => 'success',
        StatusTahap::GAGAL => 'fail',
    ];

    public function __construct(IDashboardService $dashboardService) {
        $this->middleware(['auth', 'verified', 'registered']);
        $this->statusTahap = collect($this->statusTahap);
        $this->dashboardService = $dashboardService;
    }

    public function index()
    {
        $viewData = collect(['name' => 'peserta.dashboard']);
        $peserta = Auth::user();
        if ($peserta->tahap_id == Tahap::REGISTRASI)
            $viewData = $this->cekRegistrasi($peserta->id);
        else
            $viewData = $this->cekStatusTahapLomba($peserta);

        $viewData->put('statusTahap', $this->turnStatusTahapToView());
        $viewData->put('currentTahap', $peserta->tahap_id);
        // dd($viewData);
        return view($viewData['name'], $viewData->except('name'));
    }

    private function cekRegistrasi($peserta_id)
    {
        $hasilCek = $this->dashboardService->CekRegistrasiPembayaran($peserta_id);
        $this->statusTahap['Registrasi'] = $hasilCek['StatusRegistrasi'];

        $view = $this->statusTahapViewFile[$hasilCek['StatusRegistrasi']];
        $viewData = collect([
            'name' => 'peserta.dashboard.registrasi.'.$view,
            'statusPembayaran' => $hasilCek['StatusPembayaran']
        ]);
        if (array_key_exists('Countdown', $hasilCek)){
            $viewData->put('countdown', $hasilCek['Countdown']->valueOf());
        }
        return $viewData;
    }

    private function cekStatusTahapLomba($peserta)
    {
        $tahap_id = $peserta->tahap_id;
        $this->statusTahap['Registrasi'] = StatusTahap::SUKSES;
        $tahapViewName = $this->tahapViewFolder[$tahap_id];
        $hasilCek = $this->dashboardService->CekStatusLomba($peserta);

        $this->statusTahap['Tahap 1'] = $hasilCek['Tahap 1']['Status'];
        $this->statusTahap['Tahap 2'] = $hasilCek['Tahap 2']['Status'];
        $this->statusTahap['Tahap 3'] = $hasilCek['Tahap 3']['Status'];
        $viewData = collect([]);

        $tahap_to_get = Tahap::GetConstantName(($tahap_id == Tahap::SELESAI ? Tahap::TAHAP_3 : $tahap_id));
        $currentPesertaTahap = $hasilCek[$tahap_to_get];
        $tahapViewName .= '.'.$this->statusTahapViewFile[$currentPesertaTahap['Status']];
        $viewData->put('level', $currentPesertaTahap['Level']);
        $viewData->put('countdown', $currentPesertaTahap['Countdown']->valueOf());

        if (array_key_exists('Submission', $currentPesertaTahap)){
            $viewData->put('detailJawaban', $currentPesertaTahap['Submission']);
        }
        $viewData->put('name', 'peserta.dashboard.'.$tahapViewName);

        return $viewData;
    }

    protected function turnStatusTahapToView()
    {
        return $this->statusTahap->map(function ($item, $key)
        {
            $stateColor = 'orange';
            if ($item == StatusTahap::PROSES)
                $stateColor = 'yellow';
            else if ($item == StatusTahap::SUKSES)
                $stateColor = 'green';
            else if ($item == StatusTahap::GAGAL)
                $stateColor = 'red';
            return $stateColor;
        });
    }
}
