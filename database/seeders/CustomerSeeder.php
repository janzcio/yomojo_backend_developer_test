<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Insert 5 fake customers
        foreach (range(1, 5) as $index) {
            DB::table('customers')->insert([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'age' => $faker->numberBetween(18, 99),
                'dob' => $faker->date('Y-m-d', '2003-01-01'), // Ensuring DOB is realistic
                'email' => $faker->unique()->safeEmail,
            ]);
        }
    }
}
