<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 10) as $index) {
            DB::table('projects')->insert([
                'title' => $faker->word,
                'name' => $faker->name,
                'description' => $faker->text,
                'created_at' => Carbon::now(), // Use current date and time
                'updated_at' => Carbon::now(), 
                'author' => $faker->name,
                'prize' => $faker->randomFloat(2, 100, 1000),
            ]);
        }
    }
}
