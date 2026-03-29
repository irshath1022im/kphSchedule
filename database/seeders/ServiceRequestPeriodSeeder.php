<?php

namespace Database\Seeders;

use App\Models\ServiceRequestPeriod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceRequestPeriodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
      ServiceRequestPeriod::factory()->count(2)->create();
    }
}
