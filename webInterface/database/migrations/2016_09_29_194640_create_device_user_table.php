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
            $table->integer('pair_id');
            $table->integer('user_id');
            $table->integer('device_id');
            $table->timestamps();
            $table->foreign('user_id')->references('user_id')->on('users');
            $table->foreign('user_id')->references('user_id')->on('users');
            $table->primary('pair_id');
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
