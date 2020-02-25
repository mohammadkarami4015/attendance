<?php

use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('units')->insert([
            [
                'title' => 'بک اند'
            ],
            [
                'title' => 'فرانت اند'
            ],
            [
                'title' => 'یو آی یو ایکس'
            ],
            [
                'title' => 'خدمات'
            ],
            [
                'title' => 'اندروید'
            ],
            [
                'title' => 'آی او اس'
            ],
            [
                'title' => 'گرافیک'
            ]

        ]);

    }
}
