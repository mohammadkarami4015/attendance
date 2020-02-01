<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_times', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('day_shift_id');
            $table->time('start');
            $table->time('end');
            $table->timestamp('from')->default(now());
            $table->timestamp('to')->nullable();
            $table->timestamps();
            $table->foreign('day_shift_id')
                ->references('id')->on('day_shift')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('work_times');
    }
}
