<?php

namespace Database\Seeders;

use App\Models\IP;
use Illuminate\Database\Seeder;

class IPTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        IP::factory(10)->create();
    }
}
