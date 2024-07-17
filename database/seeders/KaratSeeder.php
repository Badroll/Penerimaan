<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Karat;

class KaratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Karat::create(['value' => '18K']);
        Karat::create(['value' => '24K']);
    }
}
