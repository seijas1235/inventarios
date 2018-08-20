<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiferenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diferencias_combustible', function (Blueprint $tabla) {

            $tabla->increments('id');
            $tabla->date('fecha');

            $tabla->integer('combustible_id')->unsigned()->nullable();
            $tabla->foreign('combustible_id')->references('id')->on('combustible')->onDelete('cascade');

            $tabla->float('gal_inicio_mes');
            $tabla->float('gal_venta_dia');
            $tabla->float('gal_sistema_comb');
            $tabla->float('gal_comprados');
            $tabla->float('gal_descagados');
            $tabla->float('dif_gal_descargados');
            $tabla->float('saldo_gals');
            $tabla->float('dif_dia');
            $tabla->float('dif_acumulada_mes');
            $tabla->string('observaciones',200);
            
            $tabla->integer('user_id')->unsigned()->nullable();
            $tabla->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

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
        Schema::drop('diferencias_combustible');
    }
}
