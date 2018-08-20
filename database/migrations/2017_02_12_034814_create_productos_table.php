<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
     Schema::create('productos', function($tabla)
     {
        $tabla->increments('id');
        $tabla->string('codigobarra',50)->unique();
        $tabla->string('nombre',50);
        $tabla->string('descripcion',200)->nullable();
        $tabla->string('aplicacion',500)->nullable();

        $tabla->string('no_serie')->nullable();

        $tabla->integer('marca_id')->unsigned()->nullable();
        $tabla->foreign('marca_id')->references('id')->on('marcas')->onDelete('cascade');

        $tabla->float('precio_venta');
        $tabla->float('precio_compra');

        $tabla->integer('estado_producto_id')->unsigned()->nullable();
        $tabla->foreign('estado_producto_id')->references('id')->on('estados_producto')->onDelete('cascade');

        $tabla->integer('tipo_producto_id')->unsigned()->nullable();
        $tabla->foreign('tipo_producto_id')->references('id')->on('tipos_productos')->onDelete('cascade');

        $tabla->integer('user_id')->unsigned()->nullable();
        $tabla->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        
            //campos para controlar inserts y updates
            //created_at updated_at
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
        Schema::drop('productos');
    }
}
