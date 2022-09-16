<?php

namespace App\Model\Lookups;

class StatusTahap
{
    public const MENUNGGU = 1;
    public const PROSES = 2;
    public const SUKSES = 3;
    public const GAGAL = 4;

    public static function GetConstantName($value)
    {
        $name = '';
        switch ($value) {
            case StatusTahap::MENUNGGU:
                $name = 'Menunggu';
                break;
            case StatusTahap::PROSES:
                $name = 'Proses';
                break;
            case StatusTahap::SUKSES:
                $name = 'Sukses';
                break;
            case StatusTahap::GAGAL:
                $name = 'Gagal';
                break;
        }
        return $name;
    }
}