<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBombaCombustibleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bomba_combustible', function (Blueprint $tabla) {
            $tabla->increments('id');
            
            $tabla->integer('bomba_id')->unsigned()->nullable();
            $tabla->foreign('bomba_id')->references('id')->on('bomba')->onDelete('cascade');

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
        Schema::drop('bomba_combustible');
    }
}
