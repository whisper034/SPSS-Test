<?php

namespace App\Service\Modules;

use App\Service\Contracts\INotificationService;
use App\Repository\Contracts\IAdminRepository;
use App\Repository\Contracts\IPembayaranRepository;
use App\Repository\Contracts\IPesertaRepository;
use App\Repository\Contracts\ITimelineRepository;
use Carbon\Carbon;

class NotificationService implements INotificationService
{
    private $adminRepository;
    private $pembayaranRepository;
    private $pesertaRepository;
    private $timelineRepository;

    public function __construct(
        IAdminRepository $adminRepository,
        IPembayaranRepository $pembayaranRepository,
        IPesertaRepository $pesertaRepository,
        ITimelineRepository $timelineRepository
    ) {
        $this->adminRepository = $adminRepository;
        $this->pembayaranRepository = $pembayaranRepository;
        $this->pesertaRepository = $pesertaRepository;
        $this->timelineRepository = $timelineRepository;
    }

    public function GetNotifications($limit = null)
    {
        $notifications = $this->GetEmailVerificationNotifications();
        $notifications = $notifications->merge($this->GetPembayaranNotifications());
        $notifications = $notifications->sortBy('Priority')->sortByDesc('DateTime')->values();
        $notifications->transform(function ($item, $key)
        {
            $item['DateTime'] = $item['DateTime']->format('d F Y H:i:s');
            return $item;
        });
        if (is_null($limit)){
            return $notifications;
        }
        else {
            return $notifications->take($limit);
        }
    }

    private function GetEmailVerificationNotifications()
    {
        $pesertas = $this->pesertaRepository->FindAllWhereEmailVerifiedAtNotNull();
        return $pesertas->map(function ($peserta, $key)
        {
            $description = "{$peserta->name} telah melakukan verifikasi email.<br> Kode Peserta: {$peserta->KodePeserta}";
            return [
                'Priority' => 2,
                'DateTime' => $peserta->email_verified_at,
                'Description' => $description,
                'Redirect URL' => route('notification-redirect', ['peserta' => $peserta->id]),
            ];
        });
    }

    private function GetPembayaranNotifications()
    {
        $pembayarans = $this->pembayaranRepository->FindAll();
        return $pembayarans->map(function ($pembayaran, $key)
        {
            $peserta = $this->pesertaRepository->Find($pembayaran->peserta_id);
            $description = "{$peserta->name} telah mengirimkan bukti pembayaran.";

            if (!is_null($pembayaran->StatusVerifikasi)){
                $admin = $this->adminRepository->Find($pembayaran->admin_id);
                $description .= "<br> Bukti telah diverifikasi oleh {$admin->name}.";
            }

            return [
                'Priority' => (is_null($pembayaran->StatusVerifikasi) ? 1 : 2),
                'DateTime' => $peserta->updated_at,
                'Description' => $description,
                'Redirect URL' => route('notification-redirect', ['peserta' => $peserta->id]),
            ];
        });
    }
}