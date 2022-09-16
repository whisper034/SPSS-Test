<?php

namespace App\Service\Modules;

use App\Model\DB\Admin;
use App\Model\Lookups\Tahap;
use App\Service\Contracts\IAdminService;
use App\Repository\Contracts\IAdminRepository;
use App\Repository\Contracts\IPembayaranRepository;
use App\Repository\Contracts\IPesertaRepository;
use App\Repository\Contracts\IRoleRepository;
use Illuminate\Support\Facades\Hash;

class AdminService implements IAdminService
{
    private $adminRepository;
    private $pembayaranRepository;
    private $pesertaRepository;
    private $roleRepository;
    
    public function __construct(
        IAdminRepository $adminRepository,
        IPembayaranRepository $pembayaranRepository,
        IPesertaRepository $pesertaRepository,
        IRoleRepository $roleRepository
    ) {
        $this->adminRepository = $adminRepository;
        $this->pembayaranRepository = $pembayaranRepository;
        $this->pesertaRepository = $pesertaRepository;
        $this->roleRepository = $roleRepository;
    }

    public function GetAdmins()
    {
        $admins = $this->adminRepository->FindAll();
        $roles = $this->roleRepository->FindAll();

        return $admins->map(function ($item, $key) use ($roles)
        {
            return [
                'id' => $item->id,
                'email' => $item->email,
                'name' => $item->name,
                'role' => $roles->firstWhere('id', $item->role_id)->Name
            ];
        });
    }

    public function GetAdminByID($id)
    {
        $return_arr = [
            'id' => 0,
            'email' => '',
            'name' => '',
            'role_id' => null,
            'role' => ''
        ];
        if ($id == 0){
            return $return_arr;
        }
        $admin = $this->adminRepository->Find($id);
        $role = $this->roleRepository->Find($admin->role_id);

        $return_arr['id'] = $admin->id;
        $return_arr['email'] = $admin->email;
        $return_arr['name'] = $admin->name;
        $return_arr['role_id'] = $admin->role_id;
        $return_arr['role'] = $role->Name;
        return $return_arr;
    }

    public function InsertUpdateAdmin($data)
    {
        $admin = null;
        if ($data['id'] == 0){
            $admin = new Admin();
        }
        else {
            $admin = $this->adminRepository->Find($data['id']);
        }

        $admin->name = $data['name'];
        $admin->role_id = $data['role_id'];
        if ($data['id'] == 0){
            $admin->email = $data['email'];
            $admin->password = Hash::make($data['password']);
        }
        return $this->adminRepository->InsertUpdate($admin);
    }

    public function DeleteAdmin($id)
    {
        return $this->adminRepository->Delete($id);
    }

    public function GetRoles()
    {
        return $this->roleRepository->FindAll();
    }

    public function GetDashboardInformation()
    {
        $reminders = $this->GetDashboardReminder();
        $showedReminders = $reminders->filter(function ($item, $key)
        {
            return $item['Show'];
        });

        return [
            'Statistics' => $this->GetStatistics(),
            'Reminder' => $showedReminders->toArray(),
        ];
    }

    private function GetStatistics()
    {
        $statistics = [
            'Registered' => 0,
            'Verified' => 0,
            'Tahap 1' => 0,
            'Tahap 2' => 0,
            'Tahap 3' => 0,
        ];
        $pesertaList = $this->pesertaRepository->FindAll();

        $statistics['Registered'] = $pesertaList->count();

        $verifiedList = $pesertaList->filter(function ($item, $key)
        {
            return !(is_null($item->email_verified_at));
        });

        $statistics['Verified'] = $verifiedList->count();

        $tahap3List = $verifiedList->filter(function ($item, $key)
        {
            return ($item->tahap_id == Tahap::TAHAP_3) || ($item->tahap_id == Tahap::SELESAI);
        });

        $statistics['Tahap 3'] = $tahap3List->count();

        $tahap2List = $verifiedList->filter(function ($item, $key)
        {
            return ($item->tahap_id == Tahap::TAHAP_2);
        });

        $statistics['Tahap 2'] = $tahap2List->count() + $statistics['Tahap 3'];

        $tahap1List = $verifiedList->filter(function ($item, $key)
        {
            return ($item->tahap_id == Tahap::TAHAP_1);
        });

        $statistics['Tahap 1'] = $tahap1List->count() + $statistics['Tahap 2'];
        return $statistics;
    }

    private function GetDashboardReminder()
    {
        $reminders = collect([]);

        $unverified_pembayarans = $this->pembayaranRepository->FindAllByStatusVerifikasi(null);
        $reminders->push([
            'Message' => "Terdapat {$unverified_pembayarans->count()} pembayaran yang belum terverifikasi.",
            'Show' => ($unverified_pembayarans->count() > 0) ? true : false
        ]);

        return $reminders;
    }
}
