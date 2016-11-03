<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSamplesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('samples', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('sample_id');
            $table->integer('pair_id')->unsigned();
            $table->timestamps();
            $table->string('gestureName');
            $table->mediumtext('sampleData');
            
            /* Indexes */
            $table->foreign('pair_id')->references('pair_id')->on('device_user')
                  ->onDelete('cascade')->onUpdate('cascade');

            // $table->primary('sample_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('samples');
    }
}
