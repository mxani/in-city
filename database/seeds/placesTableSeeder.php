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
    {  
        $makan=["داروخانه شفا","سوپری محمد","مهندسی پزشکی امیر","ایستگاه امام علی","تاکسی تلفنی بانوان","بانک ملی","بانک تجارت","هایپر مارکت همشهری","سینما تربیت","سینما نور","استخر صدف","درمانگاه امام صادق","خونه خودمون"];
        $fake=\Faker\Factory::create('fa_IR');
        for ($i=14; $i <10000; $i++) { 
         //   $place=$makan[$i-14];
            DB::table('places')->insert([
                'user_id'=>"",
                'parentID'=>rand(9,99),
                'locations_id'=>rand(1,30), 
                'place'=>$fake->name,
                'phone' => $fake->phonenumber,
                'adress' =>$fake->address,
                'webpage' =>$fake->url,
                'pic'=>$fake->imageurl,
                'tag' =>$fake->company,
                'sign' => $fake->company,
            ]);
        }
    }
}
