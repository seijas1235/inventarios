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
        Schema::create('maquinarias_y_eqipos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('marca');
            $table->int('labadas_limite');
            $table->date('fecha_adquisicion');
            $table->double('precio_costo');
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
        Schema::drop('Maquinarias_y_eqipos');
    }
}
