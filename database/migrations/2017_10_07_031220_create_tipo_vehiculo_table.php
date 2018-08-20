<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoVehiculoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
     Schema::create('tipo_vehiculo', function($tabla)
     {
      $tabla->increments('id');
      $tabla->string('tipo_vehiculo',25);
      
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
     Schema::drop('tipo_vehiculo');
   }
 }
