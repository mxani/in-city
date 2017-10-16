<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      
        $this->call(placesTableSeeder::class);
        $this->call(locationTableSeeder::class);
         $this->call(categoriesTableSeeder::class);
    }
}
