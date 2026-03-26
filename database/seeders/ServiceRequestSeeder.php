<?php

namespace Database\Seeders;

use App\Models\ServiceRequest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        ServiceRequest::factory()->count(50)->create();
    }
}
