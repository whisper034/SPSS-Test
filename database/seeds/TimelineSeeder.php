<?php

use App\Model\DB\Timeline;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TimelineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Timeline::create([
            'Description' => 'Awal Pendaftaran',
            'DateTime' => Carbon::create(2020, 9, 1, 00, 00, 00, '+07:00')
        ]);

        Timeline::create([
            'Description' => 'Akhir Pendaftaran',
            'DateTime' => Carbon::create(2020, 10, 8, 23, 59, 59, '+07:00')
        ]);

        Timeline::create([
            'Description' => 'Awal Tahap 1', 
            'DateTime' => Carbon::create(2020, 11, 1, 12, 00, 00, '+07:00')
        ]);

        Timeline::create([
            'Description' => 'Akhir Tahap 1', 
            'DateTime' => Carbon::create(2020, 11, 4, 23, 59, 59, '+07:00')
        ]);

        Timeline::create([
            'Description' => 'Pengumuman Tahap 1', 
            'DateTime' => Carbon::create(2020, 11, 10, 12, 00, 00, '+07:00')
        ]);

        Timeline::create([
            'Description' => 'Awal Tahap 2', 
            'DateTime' => Carbon::create(2020, 11, 14, 13, 00, 00, '+07:00')
        ]);

        Timeline::create([
            'Description' => 'Akhir Tahap 2', 
            'DateTime' => Carbon::create(2020, 11, 14, 15, 30, 00, '+07:00')
        ]);

        Timeline::create([
            'Description' => 'Pengumuman Tahap 2', 
            'DateTime' => Carbon::create(2020, 11, 15, 12, 00, 00, '+07:00')
        ]);

        Timeline::create([
            'Description' => 'Awal Pengerjaan Tahap 3', 
            'DateTime' => Carbon::create(2020, 11, 27, 12, 00, 00, '+07:00')
        ]);

        Timeline::create([
            'Description' => 'Akhir Pengerjaan Tahap 3', 
            'DateTime' => Carbon::create(2020, 11, 27, 16, 00, 00, '+07:00')
        ]);

        Timeline::create([
            'Description' => 'Presentasi Tahap 3', 
            'DateTime' => Carbon::create(2020, 11, 28, 13, 00, 00, '+07:00')
        ]);

        Timeline::create([
            'Description' => 'Pengumuman Pemenang', 
            'DateTime' => Carbon::create(2020, 11, 29, 13, 00, 00, '+07:00')
        ]);

        Timeline::create([
            'Description' => 'Seminar',
            'DateTime' => Carbon::create(2020, 11, 26, 13, 00, 00, '+07:00')
        ]);
    }
}
