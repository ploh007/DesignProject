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
            $table->foreign('pivotuser_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('pivotdevice_id')->references('id')->on('devices')->onUpdate('cascade')->onDelete('cascade');

            // Adding unique index and prvent duplicate assignment o same device to user
            $table->unique( array('pivotuser_id','pivotdevice_id'));

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
