<?php

use Illuminate\Database\Seeder;

class FlightCallSignsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

     public function run()
     {
        factory(App\FlightCallSigns::class, 3)->create()->each(function ($saveFlight) {
             $saveFlight->save();
         });
     }
}
