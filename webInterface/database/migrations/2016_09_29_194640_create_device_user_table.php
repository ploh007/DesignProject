<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeviceUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('device_user', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('pair_id');
            $table->integer('pivotuser_id')->unsigned();
            $table->integer('pivotdevice_id');
            $table->timestamps();
            $table->foreign('pivotuser_id')->references('id')->on('users');
            $table->foreign('pivotdevice_id')->references('id')->on('devices');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('device_user');
    }
}
