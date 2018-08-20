<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIdpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('idps', function($tabla)
      {
        $tabla->increments('id');

        $tabla->integer('combustible_id')->unsigned()->nullable();
        $tabla->foreign('combustible_id')->references('id')->on('combustible')->onDelete('cascade');

        $tabla->float('costo_idp');

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
        Schema::drop('idps');
    }
}
