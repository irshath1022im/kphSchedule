<?php

namespace Database\Seeders;

use App\Models\Maid;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MaidSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Maid::factory()->count(50)->create();
    }
}
