<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('days', function (Blueprint $table) {
            $table->bigIncrements('id');
//            $table->unsignedBigInteger('shift_id');
            $table->string('title');
//            $table->timestamp('form')->default(now());
//            $table->timestamp('to')->nullable();
//            $table->foreign('shift_id')
//                ->references('id')->on('shifts')
//                ->onDelete('cascade');
        });
        Schema::create('day_shift', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('shift_id');
            $table->unsignedBigInteger('day_id');
            $table->timestamp('from')->default(now());
            $table->timestamp('to')->nullable();
            $table->foreign('shift_id')
                ->references('id')->on('shifts')
                ->onDelete('cascade');
            $table->foreign('day_id')
                ->references('id')->on('days')
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
        Schema::dropIfExists('work_days');
    }
}
