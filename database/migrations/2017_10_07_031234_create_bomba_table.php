<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBombaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bomba', function($tabla)
        {
            $tabla->increments('id');
            $tabla->string('bomba',20)->unique();

             $tabla->integer('combustible_id')->unsigned()->nullable();
            $tabla->foreign('combustible_id')->references('id')->on('combustible')->onDelete('cascade');

            $tabla->integer('user_id')->unsigned()->nullable();
            $tabla->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $tabla->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('bomba');
    }
}
