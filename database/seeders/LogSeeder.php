<?php

namespace Database\Seeders;

use App\Models\Attack;
use App\Models\Customer;
use App\Models\Error;
use App\Models\Log;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Log::factory()->for(Customer::factory())->for(Error::factory(), 'logable')->count(20)->create();
        Log::factory()->for(Customer::factory())->for(Attack::factory(), 'logable')->count(20)->create();
    }
}
