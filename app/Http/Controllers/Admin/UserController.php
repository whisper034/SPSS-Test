<?php

namespace App\Http\Controllers\Admin;

use App\Model\Lookups\Role;
use App\Model\Requests\Admin\StoreAdminPostRequest;
use App\Http\Controllers\Controller;
use App\Service\Contracts\IAdminService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $adminService;

    public function __construct(IAdminService $adminService) {
        $this->adminService = $adminService;
        $this->middleware([
            'auth:admin', 
            'check-role:'.Role::SUPERADMIN
        ]);
    }

    public function index($id = null)
    {
        $viewData = [
            'users' => $this->adminService->GetAdmins()
        ];
        if (!is_null($id)){
            $viewData = array_merge($viewData, [
                'user' => $this->adminService->GetAdminByID($id),
                'roles' => $this->adminService->GetRoles()->toDropdown('id', 'Name'),
            ]);
        }
        return view('admin.user', $viewData);
    }

    public function store(StoreAdminPostRequest $request)
    {
        $admin = $this->adminService->InsertUpdateAdmin($request->validatedIntoCollection());
        return redirect('/admin/user');
    }

    public function delete(Request $request)
    {
        $this->adminService->DeleteAdmin($request->id);
        return redirect('/admin/user');
    }
}
