<?php

namespace Database\Seeders;

use App\Models\Day;
use Illuminate\Database\Seeder;

class DaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Day::create(['index' => 1, 'name' => 'Senin']);
        Day::create(['index' => 2, 'name' => 'Selasa']);
        Day::create(['index' => 3, 'name' => 'Rabu']);
        Day::create(['index' => 4, 'name' => 'Kamis']);
        Day::create(['index' => 5, 'name' => 'Jumat']);
        Day::create(['index' => 6, 'name' => 'Sabtu']);
        Day::create(['index' => 0, 'name' => 'Minggu']);
    }
}
