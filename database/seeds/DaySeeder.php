<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {


        DB::table('days')->insert([

            [
                'id'=>1,
                'title' => 'Monday',
                'label'=>'دوشنبه'
            ],
            [
                'id'=>2,
                'title' => 'Tuesday',
                'label'=>'سه شنبه'
            ],
            [
                'id'=>3,
                'title' => 'Wednesday',
                'label'=>'چهارشنبه'
            ],
            [
                'id'=>4,
                'title' => 'Thursday',
                'label'=>'پنجشنبه'
            ],

            [
                'id'=>5,
                'title' => 'Friday',
                'label'=>'جمعه'
            ],
            [
                'id'=>6,
                'title' => 'Saturday',
                'label'=>'شنبه'
            ],
            [
                'id'=>0,
                'title' => 'Sunday',
                'label'=>'یکشنبه'
            ],
            ]);
    }
}
