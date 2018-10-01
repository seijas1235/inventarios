<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMaquinariaServicio extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maquinaria_servicios', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('maquinaria_id');
            $table->unsignedInteger('servicio_id');

            $table->foreign('maquinaria_id')->references('id')->on('maquinarias_y_equipos')->onDelete('cascade');
            $table->foreign('servicio_id')->references('id')->on('servicios')->onDelete('cascade');
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
        Schema::drop('maquinaria_servicios');
    }
}
