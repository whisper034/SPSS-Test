<?php

namespace App\Http\Middleware;

use App\Model\Lookups\Registrasi;
use App\Service\Contracts\IRegistrasiService;
use Closure;
use Illuminate\Support\Facades\Auth;

class CekRegistrasi
{
    private $registrasiService;

    public function __construct(
        IRegistrasiService $registrasiService
    ) {
        $this->registrasiService = $registrasiService;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $peserta_id = Auth::id();
        $registrasi = $this->registrasiService->CekRegistrasiPeserta($peserta_id);

        if ($registrasi == 0 && ($request->is('pembayaran') || $request->is('data-peserta'))){
            return redirect('/dashboard');
        }
        else if ($registrasi == Registrasi::PEMBAYARAN && !$request->is('pembayaran')){
            return redirect('/pembayaran');
        }
        else if ($registrasi == Registrasi::DATA_PESERTA && !$request->is('data-peserta')){
            return redirect('/data-peserta');
        }

        return $next($request);
    }
}