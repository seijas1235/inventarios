<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCortesCaja extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cortes_caja', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha');
            $table->string('factura_inicial');
            $table->string('factura_final');
            $table->float('total');
            $table->float('efectivo');
            $table->float('credito');
            $table->float('voucher');
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
        Schema::drop('cortes_caja');
    }
}
