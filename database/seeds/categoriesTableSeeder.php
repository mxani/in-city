<?php

use Illuminate\Database\Seeder;

class categoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sardaste=["خرید","حمل و نقل","بهداشت و درمان","خدمات شهری"];
        $daste=["پوشاک","سوپرمارکت","قطار","تاکسی تلفنی","تجهیزات پزشکی","داروخانه","بانک","سینما"]; 
      
        $fake=\Faker\Factory::create('fa_IR');
    	for ($i=0; $i < 4; $i++) { 
            $place=$sardaste[$i];
	    	DB::table('categories')->insert([
                'parentID'=>0,
                'Category'=>$place,
	        ]);
        }
        for ($i=5; $i < 13; $i++) { 
            $place=$daste[$i-5];
            DB::table('categories')->insert([
                'parentID'=>rand(1,4),
                'Category'=>$place,
               
            ]);
        }
       
        }
    }
