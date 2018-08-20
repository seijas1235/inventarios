<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBgCorteMensualTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bg_corte_mensual', function (Blueprint $tabla) {

            $tabla->increments('id');

            $tabla->integer('mes_id')->unsigned()->nullable();
            $tabla->foreign('mes_id')->references('id')->on('meses')->onDelete('cascade');

            $tabla->integer('total_galones');
            $tabla->float('total_ingreso');
            $tabla->float('total_impuesto');
            $tabla->float('total_seguro');
            
            $tabla->float('total_repuestos');
            $tabla->float('total_viaticos');
            $tabla->float('total_salarios');
            $tabla->float('total_combustible');
            $tabla->float('total_mantenimientos');
            $tabla->float('total_contabilidad');
            $tabla->float('total_gastos_bg');

            $tabla->float('utilidad_bg');

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
        Schema::drop('bg_corte_mensual');
    }
}
