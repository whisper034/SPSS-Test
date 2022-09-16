<?php

namespace App\Service\Contracts;

interface IAuthService
{
    public function GetPesertaByEmail($email);
    public function CheckRegistrationPeriod();
    public function RegisterPeserta($data);
    public function ChangePassword($peserta_id, $new_password, $admin_id = null);
    public function GetAdminByEmail($email);
}