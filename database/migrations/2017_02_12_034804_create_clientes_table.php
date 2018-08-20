<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
     Schema::create('clientes', function($tabla)
     {
        $tabla->increments('id');
        $tabla->string('cl_nit',15);
        $tabla->string('cl_nombres',40);
        $tabla->string('cl_apellidos',40);
        $tabla->string('cl_telefonos',25)->nullable();
        $tabla->string('cl_direccion',50)->nullable();
        $tabla->float('cl_montomaximo',10,2);
        $tabla->string('cl_mail',60);
        $tabla->string('cl_cuentac',50);
        $tabla->float('cl_saldo',10,2);
        $tabla->date('fecha_saldo');

        $tabla->integer('tipo_cliente_id')->unsigned()->nullable();
        $tabla->foreign('tipo_cliente_id')->references('id')->on('tipo_cliente')->onDelete('cascade');

        $tabla->integer('estado_cliente_id')->unsigned()->nullable();
        $tabla->foreign('estado_cliente_id')->references('id')->on('estados_cliente')->onDelete('cascade');

        $tabla->integer('user_id')->unsigned()->nullable();
        $tabla->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

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
        Schema::drop('clientes');
    }
}
