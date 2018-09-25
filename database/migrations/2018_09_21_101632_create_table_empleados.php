<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEmpleados extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->increments('id');
<<<<<<< HEAD
            $table->string('nombres');
            $table->string('apeliidos');
=======
            $table->string('nombre');
            $table->string('apellido');
>>>>>>> 2392ad32391669dc4fdd376c2a547a1895605fd5
            $table->string('nit',20);
            $table->string('direccion');
            $table->string('telefonos', 30);
            $table->unsignedInteger('puesto_id');

            $table->foreign('puesto_id')->references('id')->on('puestos')->onDelete('cascade');

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
        Schema::drop('empleados');
    }
}