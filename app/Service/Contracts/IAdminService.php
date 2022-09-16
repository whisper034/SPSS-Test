<?php

namespace App\Service\Contracts;

interface IAdminService
{
    public function GetAdmins();
    public function GetAdminByID($id);
    public function InsertUpdateAdmin($data);
    public function DeleteAdmin($id);
    public function GetRoles();
    public function GetDashboardInformation();
}