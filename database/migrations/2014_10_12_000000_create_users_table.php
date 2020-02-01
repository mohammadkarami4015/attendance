<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('family');
            $table->string('national_code');
            $table->string('personal_code')->unique();
            $table->string('date_of_employment');
            $table->string('email')->unique();
            $table->unsignedBigInteger('unit_id')->nullable();;
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('unit_id')
                ->references('id')->on('units');
        });

        DB::table('users')->insert([
            'name' => 'محمد',
            'family' => 'فتحی',
            'national_code' => '3732111111',
            'personal_code' => '10100',
            'date_of_employment' => Carbon::now(),
            'email' => 'fathi@admin.com',
            'password' => '$2y$10$cz449UJOuDzyyXPM2ECSYOVBCc5s2yRE8stdpf6vDKfYUpC1/9kW6',
        ]);

        DB::table('users')->insert([
            'name' => 'پرویز',
            'family' => 'کاظمی',
            'national_code' => '3732111111',
            'personal_code' => '10101',
            'date_of_employment' => Carbon::now(),
            'email' => 'kazemi@admin.com',
            'password' => '$2y$10$cz449UJOuDzyyXPM2ECSYOVBCc5s2yRE8stdpf6vDKfYUpC1/9kW6',
        ]);

        DB::table('users')->insert([
            'name' => 'پیام',
            'family' => 'کریمیان',
            'national_code' => '3732111111',
            'personal_code' => '10102',
            'date_of_employment' => Carbon::now(),
            'email' => 'karimian@admin.com',
            'password' => '$2y$10$cz449UJOuDzyyXPM2ECSYOVBCc5s2yRE8stdpf6vDKfYUpC1/9kW6',
        ]);

        DB::table('users')->insert([
            'name' => 'دیاکو',
            'family' => 'محمودی',
            'national_code' => '3732111111',
            'personal_code' => '10103',
            'date_of_employment' => Carbon::now(),
            'email' => 'admin@admin.com',
            'password' => '$2y$10$cz449UJOuDzyyXPM2ECSYOVBCc5s2yRE8stdpf6vDKfYUpC1/9kW6',
        ]);

        DB::table('users')->insert([
            'name' => 'کاربر',
            'family' => 'عادی',
            'national_code' => '3732111111',
            'personal_code' => '10126',
            'date_of_employment' => Carbon::now(),
            'email' => 'ordinary@gmail.com',
            'password' => '$2y$10$cz449UJOuDzyyXPM2ECSYOVBCc5s2yRE8stdpf6vDKfYUpC1/9kW6',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
