<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventarioCombustibleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
  public function up()
    {
        Schema::create('inventario_combustible', function (Blueprint $tabla) {
            
            $tabla->increments('id');

            $tabla->date('fecha_inventario');

            $tabla->integer('gal_sup_entrada');
            $tabla->integer('gal_sup_salida');
            $tabla->integer('gal_sup_existencia');
            $tabla->float('precio_promedio_sup');
            $tabla->float('subtotal_entrada_sup');
            $tabla->float('subtotal_salida_sup');
            $tabla->float('subtotal_exis_sup');

            $tabla->integer('gal_reg_entrada');
            $tabla->integer('gal_reg_salida');
            $tabla->integer('gal_reg_existencia');
            $tabla->float('precio_promedio_reg');
            $tabla->float('subtotal_entrada_reg');
            $tabla->float('subtotal_salida_reg');
            $tabla->float('subtotal_exis_reg');

            $tabla->integer('gal_die_entrada');
            $tabla->integer('gal_die_salida');
            $tabla->integer('gal_die_existencia');
            $tabla->float('precio_promedio_die');
            $tabla->float('subtotal_entrada_die');
            $tabla->float('subtotal_salida_die');
            $tabla->float('subtotal_exis_die');

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
        Schema::drop('inventario_combustible');
    }
}
