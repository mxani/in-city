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
         $mantaghe=["آذر","آزادگان","امام","امامزاده ابراهیم","انسجام","انصار‌الحسین","انقلاب (چهارمردان)","باجک (۱۹ دی)","بلوار ۱۵ خرداد","بلوار امین","بلوار کاشانی","بنیاد","پردیسان","پلیس","پیام نور","توحید","جمهوری","حرم","دانیال","دورشهر","زنبیل‌آباد (شهید صدوقی)","سالاریه","سمیه","شهرک قدس","شهید بهشتی","صفاشهر","صفائیه","عطاران","عمار یاسر","کلهری","کیوانفر","گلزار","مدرس","هفت تیر","هنرستان","یزدان‌شهر"];
         DB::table('locations')->insert([
            'parentID'=>0,
            'local'=>"همه ی شهر",
        ]);
            for ($i=0; $i <count($mantaghe); $i++) { 
            $local=$mantaghe[$i];
	    	DB::table('locations')->insert([
                'parentID'=>1,
                'local'=>"$local",
	        ]);
    }
}
}