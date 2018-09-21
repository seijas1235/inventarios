<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableClientes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('nit',20);
            $table->string('direccion');
            $table->string('telefono',20);
            $table->float('descuento');
            $table->integer('record_compra');
            $table->unsignedInteger('tipo_cliente_id');
            $table->unsignedInteger('user_id');

            $table->foreign('tipo_cliente_id')->references('id')->on('tipo_clientes')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');


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
        Schema::drop('clientes');
    }
}
