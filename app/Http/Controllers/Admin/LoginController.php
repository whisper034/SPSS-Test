<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Service\Contracts\IAuthService;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::ADMIN_DASHBOARD;

    private $authService;

    protected function guard()
    {
        return Auth::guard('admin');
    }

    public function __construct(IAuthService $authService) {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:admin')->except('logout');
        $this->authService = $authService;
        parent::__construct($authService);
    }

    /**
     * Show the admin's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('admin.login');
    }

    /**
     * Define the error messages for login request's fields
     * 
     * @var array
     */
    private $messages = [
        'email.required' => 'Email must not be empty',
        'email.email' => 'Email must be a valid email address',
        'password.required' => 'Password must not be empty'
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
        $admin = $this->authService->GetAdminByEmail($request->email);
        if (is_null($admin)){
            $message = 'There is no admin account associated with this email';
        }
        else {
            $message = 'Email or password is incorrect';
        }

        throw ValidationException::withMessages([
            $this->username() => $message
        ]);
    }
}
