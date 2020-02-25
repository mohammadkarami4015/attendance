<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(DaySeeder::class);
         $this->call(UnitSeeder::class);
         $this->call(UserSeeder::class);
         $this->call(PermissionSeeder::class);

    }
}
