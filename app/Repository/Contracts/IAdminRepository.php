<?php

namespace App\Repository\Contracts;

interface IAdminRepository
{
    public function FindByEmail($email);
}