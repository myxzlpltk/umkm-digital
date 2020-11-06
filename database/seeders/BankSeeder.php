<?php

namespace Database\Seeders;

use App\Models\Bank;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $banks = json_decode(Storage::disk('local')->get('bank.json'));
        foreach ($banks as $bank){
            Bank::create([
                'name' => $bank->name,
                'icon' => $bank->file
            ]);
        }
    }
}
