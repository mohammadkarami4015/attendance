<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{

    public function run()
    {
        DB::table('permissions')->insert([
            [
                'title' => 'users',
                'label' => 'مدیریت کاربران'
            ],
            [
                'title' => 'units',
                'label' => 'مدیریت گروه کاری'
            ],
            [
                'title' => 'shifts',
                'label' => 'مدیریت شیفت کاری',
            ],
            [
                'title' => 'workTimes',
                'label' => 'مدیریت زمان کاری',
            ]


        ]);
    }
}
