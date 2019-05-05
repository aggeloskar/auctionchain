<?php

use Illuminate\Database\Seeder;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('items')->insert([
            'title' => Str::random(10),
            'description' => Str::random(10),
            'seller' => Str::random(10),
            'starting_price' => rand(1,10),
            'reserve_price' => rand(1,5),
            'currency' => "EUR",
            'startDate' => date('Y-m-d H:i:s'),
            'duration' => rand(1,7),

        ]);
    }
}
