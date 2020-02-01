<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShiftUnitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shift_unit', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('unit_id');
            $table->unsignedBigInteger('shift_id');
            $table->timestamp('from')->default(now());
            $table->timestamp('to')->nullable();
            $table->foreign('unit_id')
                ->references('id')->on('units')
                ->onDelete('cascade');
            $table->foreign('shift_id')
                ->references('id')->on('shifts')
                ->onDelete('cascade');
          //  $table->primary(['user_id','shift_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shift_user');
    }
}
