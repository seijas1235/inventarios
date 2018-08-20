<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLibroVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        Schema::create('libro_ventas', function (Blueprint $tabla) {

            $tabla->increments('id');

            $tabla->integer('mes_id')->unsigned()->nullable();
            $tabla->foreign('mes_id')->references('id')->on('meses')->onDelete('cascade');

            $tabla->integer('no_folio');
            $tabla->date('fecha');

            $tabla->integer('serie_id')->unsigned()->nullable();
            $tabla->foreign('serie_id')->references('id')->on('series')->onDelete('cascade');

            $tabla->string('no_documento',20);

            $tabla->integer('documento_id')->unsigned()->nullable();
            $tabla->foreign('documento_id')->references('id')->on('documentos')->onDelete('cascade');

            $tabla->string('nit',15);
            $tabla->string('cliente',15);
            $tabla->float('bienes');
            $tabla->float('servicios');
            $tabla->float('exportacion');
            $tabla->float('iva');
            $tabla->float('total');

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
        Schema::drop('libro_ventas');
    }
}
