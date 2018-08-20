<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBgFleteCompraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
      public function up()
    {
        Schema::create('bg_flete_compra', function (Blueprint $tabla) {

            $tabla->increments('id');

            $tabla->integer('bg_flete_maestro_id')->unsigned()->nullable();
            $tabla->foreign('bg_flete_maestro_id')->references('id')->on('bg_fletes_maestro')->onDelete('cascade');

            $tabla->integer('total_galones');
            $tabla->float('total_flete');
            
            $tabla->integer('estado_flete_id')->unsigned()->nullable();
            $tabla->foreign('estado_flete_id')->references('id')->on('estado_flete')->onDelete('cascade');

            $tabla->integer('estado');

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
        Schema::drop('bg_flete_compra');
    }
}
