<?php

namespace App\Http\Controllers\Admin;

use App\Model\Lookups\SessionKey;
use App\Http\Controllers\Controller;
use App\Service\Contracts\INotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    private $notificationService;

    public function __construct(INotificationService $notificationService) {
        $this->notificationService = $notificationService;
        $this->middleware(['auth:admin']);
    }

    public function index()
    {
        $viewData = [
            'notifications' => $this->notificationService->GetNotifications()
        ];
        return view('admin.notification', $viewData);
    }

    public function redirect(Request $request)
    {
        $peserta_id = $request->query('peserta');
        if (is_null($peserta_id)){
            return redirect('/admin/notification');
        }
        session()->flash(Sessionkey::DETAIL_PESERTA_REDIRECT, ['id' => $peserta_id]);
        return redirect('/admin/peserta');
    }
}
