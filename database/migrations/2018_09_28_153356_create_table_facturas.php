<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableFacturas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('numero');
            $table->datetime('fecha');
            $table->decimal('total');
            $table->unsignedInteger('voucher_id')->nullable();
            $table->unsignedInteger('tipo_pago_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('serie_id');

            $table->foreign('voucher_id')->references('id')->on('voucher')->onDelete('cascade');
            $table->foreign('tipo_pago_id')->references('id')->on('tipos_pago')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('serie_id')->references('id')->on('series')->onDelete('cascade');
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
        Schema::drop('facturas');
    }
}
