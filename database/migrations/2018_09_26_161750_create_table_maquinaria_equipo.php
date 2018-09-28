<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMaquinariaEquipo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maquinarias_y_equipos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');

            $table->unsignedInteger('marca');
            $table->foreign('marca')->references('id')->on('tipos_marca')->onDelete('cascade');

            $table->integer('labadas_limite');
            $table->date('fecha_adquisicion');
            $table->double('precio_costo');
            $table->text('descripcion');
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
        Schema::drop('Maquinarias_y_equipos');
    }
}