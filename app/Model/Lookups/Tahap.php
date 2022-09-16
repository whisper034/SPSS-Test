<?php

namespace App\Model\Lookups;

class Tahap
{
    public const REGISTRASI = 1;
    public const TAHAP_1 = 2;
    public const TAHAP_2 = 3;
    public const TAHAP_3 = 4;
    public const SELESAI = 5;

    public const FOLDER_JAWABAN = [
        self::TAHAP_1 => 'tahap-1',
        self::TAHAP_2 => 'tahap-2',
        self::TAHAP_3 => 'tahap-3',
    ];

    public static function GetConstantName($value)
    {
        $name = '';
        switch ($value) {
            case Tahap::REGISTRASI:
                $name = 'Registrasi';
                break;
            case Tahap::TAHAP_1:
                $name = 'Tahap 1';
                break;
            case Tahap::TAHAP_2:
                $name = 'Tahap 2';
                break;
            case Tahap::TAHAP_3:
                $name = 'Tahap 3';
                break;
            case Tahap::SELESAI:
                $name = 'Selesai';
                break;
        }
        return $name;
    }
}