<?php

use App\Model\DB\Tahap;
use Illuminate\Database\Seeder;

class TahapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tahap::create(["NamaTahap" => "Registrasi"]);
        Tahap::create(["NamaTahap" => "Tahap 1"]);
        Tahap::create(["NamaTahap" => "Tahap 2"]);
        Tahap::create(["NamaTahap" => "Tahap 3"]);
        Tahap::create(["NamaTahap" => "Selesai"]);
    }
}
