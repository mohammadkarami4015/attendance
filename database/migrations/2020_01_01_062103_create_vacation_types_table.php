<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateVacationTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vacation_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->integer('default_amount')->nullable();
            $table->unsignedBigInteger('vacation_period_time_id');
            $table->unsignedBigInteger('vacation_measurement_id');
            $table->timestamps();
            $table->foreign('vacation_period_time_id')
                ->references('id')->on('vacation_period_time');
            $table->foreign('vacation_measurement_id')
                ->references('id')->on('vacation_measurement');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vacation_types');
    }
}
