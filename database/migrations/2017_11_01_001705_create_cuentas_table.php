<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCuentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuenta', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no_cuenta',40);

            $table->integer('banco_id')->unsigned()->nullable();
            $table->foreign('banco_id')->references('id')->on('banco')->onDelete('cascade');

            $table->string('nombre_cuenta',100);

            $table->integer('tipo_cuenta_id')->unsigned()->nullable();
            $table->foreign('tipo_cuenta_id')->references('id')->on('tipo_cuenta')->onDelete('cascade');
            
            $table->integer('user_id')->unsigned()->nullable();
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
        Schema::drop('cuenta');
    }
}
