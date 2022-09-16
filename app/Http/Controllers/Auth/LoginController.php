<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Service\Contracts\IAuthService;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:admin')->except('logout');
        $this->authService = $authService;
        parent::__construct($authService);
    }

    /**
     * Define the error messages for login request's fields
     * 
     * @var array
     */
    private $messages = [
        'email.required' => 'Alamat Surel tidak boleh kosong',
        'email.email' => 'Alamat Surel tidak memiliki format yang tepat',
        'password.required' => 'Kata Sandi tidak boleh kosong'
    ];

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string|email',
            'password' => 'required|string',
        ], $this->messages);
    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        $message = '';
        $peserta = $this->authService->GetPesertaByEmail($request->email);
        if (is_null($peserta)){
            $message = 'Tidak ditemukan akun dengan email yang diberikan';
        }
        else {
            $message = 'Email atau password salah';
        }

        throw ValidationException::withMessages([
            $this->username() => $message
        ]);
    }
}
