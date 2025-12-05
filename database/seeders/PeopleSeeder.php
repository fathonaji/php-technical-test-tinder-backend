<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PeopleSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        $people = [];

        for ($i = 0; $i < 60; $i++) {
            $people[] = [
                'name' => $faker->name(),
                'age' => $faker->numberBetween(18, 45),
                'photo_url' => $faker->imageUrl(400, 400, 'people', true),
                'location' => $faker->numberBetween(1, 30) . 'km away',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('people')->insert($people);
    }
}
