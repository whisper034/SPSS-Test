<?php

namespace App\Service\Modules;

use App\Service\Contracts\IAuthService;
use App\Repository\Contracts\IAdminRepository;
use App\Repository\Contracts\IPesertaRepository;
use App\Repository\Contracts\ITimelineRepository;
use App\Model\DB\Peserta;
use App\Model\Lookups\Tahap;
use App\Model\Lookups\Timeline;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class AuthService implements IAuthService
{
    private $adminRepository;
    private $pesertaRepository;
    private $timelineRepository;

    public function __construct(
        IAdminRepository $adminRepository,
        IPesertaRepository $pesertaRepository,
        ITimelineRepository $timelineRepository
    ) {
        $this->adminRepository = $adminRepository;
        $this->pesertaRepository = $pesertaRepository;
        $this->timelineRepository = $timelineRepository;
    }

    public function GetPesertaByEmail($email){
        $peserta = $this->pesertaRepository->FindByEmail($email);
        if (!is_null($peserta))
            return $peserta;

        return null;
    }

    public function CheckRegistrationPeriod()
    {
        $timelines = $this->timelineRepository->FindAllWhereIn([
            Timeline::AWAL_PENDAFTARAN, Timeline::AKHIR_PENDAFTARAN
        ])
        ->sortBy('DateTime')
        ->pluck('DateTime');

        $now = Carbon::now();
        if ($now->lessThan($timelines[0]) || $now->greaterThan($timelines[1]))
            return false;
        else
            return true;
    }

    public function RegisterPeserta($data){
        $peserta = new Peserta();

        $peserta->name = $data['NamaLengkap'];
        $peserta->AsalUniversitas = $data['AsalUniversitas'];
        $peserta->email = $data['email'];
        $peserta->NoHP = $data['NoHP'];
        $peserta->password = Hash::make($data['password']);
        $peserta->tahap_id = Tahap::REGISTRASI;

        return $this->pesertaRepository->InsertUpdate($peserta);
    }

    public function ChangePassword($peserta_id, $new_password, $admin_id = null)
    {
        if (is_null($admin_id)){
            $peserta = $this->pesertaRepository->Find($peserta_id);
            $peserta->password = Hash::make($new_password);
            return $this->pesertaRepository->InsertUpdate($peserta);
        }
        else {
            $admin = $this->adminRepository->Find($admin_id);
            $admin->password = Hash::make($new_password);
            return $this->adminRepository->InsertUpdate($admin);
        }
    }

    public function GetAdminByEmail($email)
    {
        $admin = $this->adminRepository->FindByEmail($email);
        if (!is_null($admin))
            return $admin;

        return null;
    }
}