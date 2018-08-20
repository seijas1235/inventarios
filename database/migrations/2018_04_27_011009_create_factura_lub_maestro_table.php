<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacturaLubMaestroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        Schema::create('factura_lub_maestro', function (Blueprint $tabla) {

            $tabla->increments('id');

            $tabla->date('fecha_factura');

            $tabla->integer('proveedor_id')->unsigned()->nullable();
            $tabla->foreign('proveedor_id')->references('id')->on('proveedores')->onDelete('cascade');

            $tabla->string('serie_factura',20);
            $tabla->string('num_factura',15);
            $tabla->float('total_factura');

            $tabla->integer('estado_factura_id')->unsigned()->nullable();
            $tabla->foreign('estado_factura_id')->references('id')->on('estado_factura')->onDelete('cascade');

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
        Schema::drop('factura_lub_maestro');
    }
}
