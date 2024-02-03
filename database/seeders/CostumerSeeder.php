<?php

namespace Database\Seeders;

use App\Models\Costumer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CostumerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // hasinvoice merupakan relasi dengan invoice di model costumer
        Costumer::factory()->count(25)->hasinvoice(10)->create();

        Costumer::factory()->count(100)->hasinvoice(5)->create();

        Costumer::factory()->count(100)->hasinvoice(3)->create();

        Costumer::factory()->count(5)->create();

    }
}
