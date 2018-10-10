<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableIngresosProductos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingresos_productos', function($table)
        {
            $table->increments('id');

            $table->unsignedInteger('producto_id')->nullable();
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');

            $table->integer('cantidad_ingreso');
            $table->date('fecha_ingreso');
            
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('edo_ingreso_id')->unsigned()->nullable();
            $table->foreign('edo_ingreso_id')->references('id')->on('estado_ingresos')->onDelete('cascade');

            $table->string('serie_factura',3);
            $table->integer('num_factura');
            $table->date('fecha_factura');
            
            $table->integer('proveedor_id')->unsigned()->nullable();
            $table->foreign('proveedor_id')->references('id')->on('proveedores')->onDelete('cascade');
            
            //campos para controlar inserts y updates
            //created_at updated_at
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ingresos_productos');
    }
}
