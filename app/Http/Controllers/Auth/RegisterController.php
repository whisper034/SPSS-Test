<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Model\DB\Peserta;
use App\Model\Requests\Auth\RegisterPesertaPostRequest;
use App\Service\Contracts\IAuthService;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Collection;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::DASHBOARD;

    private $authService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(IAuthService $authService)
    {
        $this->middleware('guest');

        $this->authService = $authService;

        $this->middleware(function ($request, $next) use ($authService)
        {
            $canRegister = $authService->CheckRegistrationPeriod();
            if ($canRegister)
                return $next($request);
            else
                return redirect(RouteServiceProvider::HOME);
        });
        parent::__construct($authService);
    }

    /**
     * Show the application registration form
     * or redirect user if it's not within
     * registration period
     *
     * @return mixed
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \App\Model\Requests\Auth\RegisterPesertaPostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function register(RegisterPesertaPostRequest $request)
    {
        event(new Registered($peserta = $this->create($request->validatedIntoCollection())));

        $this->guard()->login($peserta);

        return $this->registered($request, $peserta)
                        ?: redirect($this->redirectPath());
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  \Illuminate\Support\Collection $data
     * @return \App\Model\DB\Peserta
     */
    protected function create(Collection $data)
    {
        return $this->authService->RegisterPeserta($data);
    }
}
