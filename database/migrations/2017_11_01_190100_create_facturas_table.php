<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factura', function (Blueprint $tabla) {
            $tabla->increments('id');

            

            $tabla->string('nit',15);
            $tabla->string('cliente',150);

            $tabla->integer('serie_id')->unsigned()->nullable();
            $tabla->foreign('serie_id')->references('id')->on('series')->onDelete('cascade');

            $tabla->integer('estado_id')->unsigned()->nullable();
            $tabla->foreign('estado_id')->references('id')->on('estado_factura')->onDelete('cascade');

            $tabla->integer('no_factura');
            $tabla->string('direccion',50);
            $tabla->float('total');
            $tabla->float('idp_regular');
            $tabla->float('idp_super');
            $tabla->float('idp_diesel');
            $tabla->float('idp_total');
            $tabla->date('fecha_factura');

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
        Schema::drop('factura');
    }
}
