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
         $mantaghe=["باجک","نیروگاه","آذر","جمهوری","حرم","آزادگان","نبوت","سالاریه","بلوار امین","صفاییه ",
         "زنگارکی","جوادالائمه","گلزار","انقلاب","عماریاسر","معلم","جمکران","شاه ابراهیم ","علی آباد سعدگان","جهاد ",
         "الغدیر","پردیسان","پاسداران","شیخ آباد","امام حسن","سمیه","یزدان شهر","هفتاد و تن","کیوانفر","باجک 2"];
        $fake=\Faker\Factory::create('fa_IR');
            for ($i=0; $i <count($mantaghe); $i++) { 
            $local=$mantaghe[$i];
	    	DB::table('locations')->insert([
                'parentID'=>rand(1,8),
                'local'=>"$local",
	        ]);
    }
}
}