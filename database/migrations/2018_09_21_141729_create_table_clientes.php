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
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('nit',20)->unique();
            $table->string('direccion')->nullable();
            $table->string('telefonos',30)->nullable();
            $table->string('email')->nullable();
            $table->integer('record_compra');
            $table->unsignedInteger('tipo_cliente_id');
            $table->unsignedInteger('user_id');

            $table->foreign('tipo_cliente_id')->references('id')->on('tipos_cliente')->onDelete('cascade');
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
