<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChequeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cheque', function (Blueprint $tabla) {
            $tabla->increments('id');
            $tabla->date('fecha_cheque');

            $tabla->integer('no_cuenta_id')->unsigned()->nullable();
            $tabla->foreign('no_cuenta_id')->references('id')->on('cuenta')->onDelete('cascade');
            
            $tabla->integer('no_cheque');

            $tabla->integer('requisicion_id')->unsigned()->nullable();
            $tabla->foreign('requisicion_id')->references('id')->on('requisicion')->onDelete('cascade');
            
            $tabla->string('pagar_a',150);

            $tabla->float('monto');
            $tabla->string('monto_letras',200);
            $tabla->string('referencia',200);

            $tabla->integer('user_crea_id')->unsigned()->nullable();
            $tabla->foreign('user_crea_id')->references('id')->on('users')->onDelete('cascade');
            
            $tabla->datetime('fecha_imprime');

            $tabla->integer('user_imprime_id')->unsigned()->nullable();
            $tabla->foreign('user_imprime_id')->references('id')->on('users')->onDelete('cascade');
            
            $tabla->string('razon_anulacion',200);
            $tabla->datetime('fecha_anulacion');

            $tabla->integer('user_anula_id')->unsigned()->nullable();
            $tabla->foreign('user_anula_id')->references('id')->on('users')->onDelete('cascade');
            
            $tabla->datetime('fecha_cobro');

            $tabla->integer('user_reg_cobro_id')->unsigned()->nullable();
            $tabla->foreign('user_reg_cobro_id')->references('id')->on('users')->onDelete('cascade');
            
            $tabla->integer('estado_cheque_id')->unsigned()->nullable();
            $tabla->foreign('estado_cheque_id')->references('id')->on('estado_cheque')->onDelete('cascade');
            
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
        Schema::drop('cheque');
    }
}
