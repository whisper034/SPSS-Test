<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Model\Requests\Auth\ChangePasswordPostRequest;
use App\Providers\RouteServiceProvider;
use App\Service\Contracts\IAuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChangePasswordController extends Controller
{
    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::DASHBOARD;

    private $authService;
    
    public function __construct(IAuthService $authService) {
        $this->middleware(['auth', 'verified']);
        $this->authService = $authService;
    }

    public function index()
    {
        return view('auth.passwords.change');
    }

    public function change(ChangePasswordPostRequest $request)
    {
        $peserta_id = Auth::id();
        $this->authService->ChangePassword($peserta_id, $request['password']);
        return redirect($this->redirectTo);
    }
}
