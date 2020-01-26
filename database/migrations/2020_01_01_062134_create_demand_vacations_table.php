<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDemandVacationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demand_vacations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('vacation_type_id');
            $table->timestamp('start');
            $table->timestamp('end')->nullable();
            $table->unsignedBigInteger('hourly_daily_id');
            $table->unsignedBigInteger('justification_type_id');
            $table->tinyInteger('confirmation_type_id');
            $table->text('description');
            $table->timestamps();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
            $table->foreign('vacation_type_id')
                ->references('id')->on('vacation_types')
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
        Schema::dropIfExists('demand_vacations');
    }
}
