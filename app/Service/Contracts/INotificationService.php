<?php

namespace App\Service\Contracts;

interface INotificationService
{
    public function GetNotifications($limit = null);
}