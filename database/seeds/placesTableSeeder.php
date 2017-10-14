<?php

use Illuminate\Database\Seeder;


class placesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   $sardaste=["خرید","حمل و نقل","بهداشت و درمان","خدمات شهری"];
        $daste=["پوشاک","سوپرمارکت","قطار","تاکسی تلفنی","تجهیزات پزشکی","داروخانه","بانک","سینما"]; 
        $makan=["داروخانه شفا","سوپری محمد","مهندسی پزشکی امیر","ایستگاه امام علی","تاکسی تلفنی بانوان","بانک ملی","بانک تجارت","هایپر مارکت همشهری","سینما تربیت","سینما نور","استخر صدف","درمانگاه امام صادق","خونه خودمون"];
        $fake=\Faker\Factory::create('fa_IR');
    	for ($i=0; $i < 4; $i++) { 
            $place=$sardaste[$i];
	    	DB::table('places')->insert([
                'parentID'=>0,
                'locations_id'=>0,
                'place'=>$place,
                'phone'=>"",
                'adress'=>"",
                'webpage'=>"",
                'tag'=>"",
                'sign'=>"",
              
	        ]);
        }
        for ($i=5; $i < 13; $i++) { 
            $place=$daste[$i-5];
            DB::table('places')->insert([
                'parentID'=>rand(1,4),
                'locations_id'=>0, 
                'place'=>$place,
                'phone'=>"",
                'adress'=>"",
                'webpage'=>"",
                'tag'=>"",
                'sign'=>"",
            ]);
        }
        for ($i=14; $i < 27; $i++) { 
            $place=$makan[$i-14];
            DB::table('places')->insert([
                'parentID'=>rand(5,12),
                'locations_id'=>rand(1,10), 
                'place'=>$place,
                'phone' => $fake->phonenumber,
                'adress' =>$fake->address,
                'webpage' =>$fake->url,
                'tag' =>$fake->company,
                'sign' => $fake->company,
            ]);
        }
    }
}
