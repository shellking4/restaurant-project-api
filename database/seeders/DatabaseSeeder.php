<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Drink;
use App\Models\Food;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()
                ->times(4)
                ->create();

        Drink::factory()
                    ->times(100)
                    ->create();

        Food::factory()
                ->times(200)
                ->create();
    }
}
