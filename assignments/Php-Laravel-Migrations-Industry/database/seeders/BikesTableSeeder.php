<?php

namespace Database\Seeders;

use App\Models\bike;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class BikesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // seeding with json file 
        // $json = File::get("database/seeders/data.json");

        // $data = json_decode($json,true);

        // DB::table('bikes')->insert($data);  
        
        // random fakes data generate
        for ($i = 0; $i < 50; $i++) {
            bike::create(["name" => fake()->name(), "price" => fake()->randomNumber(), "color" => fake()->colorName()]);
        }

        // bike::create([
        //     'name'=>'Kawasaki',
        //     'price'=>90000,
        //     'color'=>'Green'
        // ]);

        // seeding with array 
        // $bikes = [
        //     ['name' => 'hornet', 'price' => 80000, 'color' => 'saffron'],
        //     ['name' => 'honda', 'price' => 70000, 'color' => 'black'],
        //     ['name' => 'bajaj', 'price' => 90000, 'color' => 'red'],
        //     ['name' => 'suzuki', 'price' => 80000, 'color' => 'white'],
        //     ['name' => 'platina', 'price' => 70000, 'color' => 'blacke']
        // ];

        // foreach($bikes as $bikedata){
        //     bike::create($bikedata);
        // }

    }
}
