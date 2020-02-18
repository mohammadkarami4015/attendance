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
                'title' => 'backEnd'
            ],
            [
                'title' => 'frontEnd'
            ],
            [
                'title' => 'UiUX'
            ],
            [
                'title' => 'Services'
            ]

        ]);

    }
}
