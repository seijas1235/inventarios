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
            $table->date('fecha_ultimo_servicio');
            $table->float('kilometraje');
            $table->string('observaciones');
            $table->string('linea');
            $table->unsignedInteger('tipo_vehiculo_id');
            $table->unsignedInteger('marca_id');
            $table->unsignedInteger('tipo_transmision_id');
            $table->unsignedInteger('cliente_id');

            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
            $table->foreign('tipo_transmision_id')->references('id')->on('tipos_transmision')->onDelete('cascade');
            $table->foreign('tipo_vehiculo_id')->references('id')->on('tipos_vehiculo')->onDelete('cascade');
            $table->foreign('marca_id')->references('id')->on('marcas')->onDelete('cascade');
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
