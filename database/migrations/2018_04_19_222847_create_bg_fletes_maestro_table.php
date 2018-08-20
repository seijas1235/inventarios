<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBgFletesMaestroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bg_fletes_maestro', function (Blueprint $tabla) {

            $tabla->increments('id');

            $tabla->date('fecha_corte');
            $tabla->string('codigo_corte',12);

            $tabla->integer('proveedor_id')->unsigned()->nullable();
            $tabla->foreign('proveedor_id')->references('id')->on('proveedores')->onDelete('cascade');

            $tabla->integer('camion_id')->unsigned()->nullable();
            $tabla->foreign('camion_id')->references('id')->on('camion')->onDelete('cascade');

            $tabla->integer('destino_id')->unsigned()->nullable();
            $tabla->foreign('destino_id')->references('id')->on('destino')->onDelete('cascade');

            $tabla->integer('no_pedido');
            $tabla->integer('no_carga');
            $tabla->string('serie_factura');
            $tabla->integer('no_factura');

            $tabla->integer('gal_super');
            $tabla->integer('gal_regular');
            $tabla->integer('gal_diesel');
            $tabla->integer('total_galones');
            $tabla->float('total_compra');
            $tabla->string('observaciones',100);

            $tabla->integer('estado_corte_id')->unsigned()->nullable();
            $tabla->foreign('estado_corte_id')->references('id')->on('estado_corte')->onDelete('cascade');

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
        Schema::drop('bg_fletes_maestro');
    }
}
