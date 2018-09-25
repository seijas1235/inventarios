<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableVehiculos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehiculos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('placa');
            $table->string('aceite_caja');
            $table->string('aceite_motor');
            $table->string('año');
            $table->string('color');
            $table->string('fecha_ultimo_servicio');
            $table->float('kilometraje');
            $table->unsignedInteger('tipo_vehiculo_id');
            $table->unsignedInteger('marca_vehiculo_id');

            $table->foreign('tipo_vehiculo_id')->references('id')->on('tipos_vehiculo')->onDelete('cascade');
            $table->foreign('marca_vehiculo_id')->references('id')->on('marcas_vehiculo')->onDelete('cascade');
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
        Schema::drop('vehiculos');
    }
}
