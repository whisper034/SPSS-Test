<?php

namespace App\Listener;

use App\Service\Contracts\IRegistrasiService;
use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class VerifiedUserListener
{
    private $registrasiService;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(IRegistrasiService $registrasiService)
    {
        $this->registrasiService = $registrasiService;
    }

    /**
     * Handle the event.
     *
     * @param  Verified  $event
     * @return void
     */
    public function handle(Verified $event)
    {
        $peserta = $event->user;
        $this->registrasiService->GenerateKodePeserta($peserta->id);
    }
}
