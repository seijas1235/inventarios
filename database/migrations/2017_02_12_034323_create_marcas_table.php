<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarcasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('marcas', function($tabla)
      {
        $tabla->increments('id');
        $tabla->string('marca',50)->unique();

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
        Schema::drop('marcas');
    }
}
