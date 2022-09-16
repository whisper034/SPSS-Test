<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(TimelineSeeder::class);
        $this->call(TahapSeeder::class);
        $this->call(RoleSeeder::class);
        // $this->call(NotificationTypeSeeder::class);
    }
}
