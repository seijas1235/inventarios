<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSalidasProducto extends Migration
{
 /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salidas_productos', function($table)
        {
            $table->increments('id');

            $table->integer('producto_id')->unsigned()->nullable();
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');

            $table->integer('cantidad_salida');
            $table->date('fecha_salida');
            
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('tipo_salida_id')->unsigned()->nullable();
            $table->foreign('tipo_salida_id')->references('id')->on('tipos_salida')->onDelete('cascade');

            $table->string('razon_salida',200);
            
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
        Schema::drop('salidas_productos');
    }
}
