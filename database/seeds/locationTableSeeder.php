<?php

use Illuminate\Database\Seeder;

class locationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $mantaghe=["باجک","نیروگاه","آذر","جمهوری","حرم","آزادگان","نبوت","سالاریه","بلوار امین","صفاییه "];
        $fake=\Faker\Factory::create('fa_IR');
            for ($i=0; $i < 11; $i++) { 
            $local=array_rand($mantaghe);$a=$mantaghe[$local];
	    	DB::table('locations')->insert([
                'parentID'=>rand(1,4),
                'local'=>"$a",
	        ]);
    }
}
}