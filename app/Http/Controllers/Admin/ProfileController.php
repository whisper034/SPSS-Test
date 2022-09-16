<?php

namespace App\Http\Controllers\Admin;

use App\Model\Requests\Admin\ChangePasswordPostRequest;
use App\Model\Requests\Admin\UpdateProfilePostRequest;
use App\Service\Contracts\IAdminService;
use App\Service\Contracts\IAuthService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    private $adminService;

    private $authService;

    public function __construct(
        IAdminService $adminService, 
        IAuthService $authService
    ) {
        $this->adminService = $adminService;
        $this->authService = $authService;
        $this->middleware(['auth:admin']);
    }

    public function index()
    {
        $admin_id = Auth::id();
        $viewData = [
            'admin' => $this->adminService->GetAdminByID($admin_id)
        ];
        return view('admin.profile', $viewData);
    }

    public function update(UpdateProfilePostRequest $request)
    {
        dd($request->validatedIntoCollection());
        $admin = $this->adminService->InsertUpdateAdmin($request->validatedIntoCollection());
        return redirect('admin/profile');
    }

    public function changePassword(ChangePasswordPostRequest $request)
    {
        $admin_id = Auth::id();
        $this->authService->ChangePassword(null, $request['password'], $admin_id);
        return redirect('admin/profile');
    }
}
