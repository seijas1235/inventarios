<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoInventarioCombustibleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        Schema::create('tipo_inventario_combustible', function (Blueprint $tabla) {
            
            $tabla->increments('id');
            $tabla->string('tipo_inventario_combustible');
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
        Schema::drop('tipo_inventario:combustible');
    }

}
