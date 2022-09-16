<?php

use App\Model\DB\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['Name' => 'Superadmin']);
        Role::create(['Name' => 'Divisi Acara']);
        Role::create(['Name' => 'Divisi Regis']);
        Role::create(['Name' => 'Divisi Danus']);
    }
}
