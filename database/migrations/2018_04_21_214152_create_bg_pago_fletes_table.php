<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBgPagoFletesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bg_pago_flete', function (Blueprint $tabla) {

            $tabla->increments('id');

            $tabla->date('fecha_documento');
            $tabla->string('documento');            
            $tabla->integer('no_documento');            

            $tabla->float('cargo');
            $tabla->float('abono');
            $tabla->float('saldo');

            $tabla->string('observaciones');     

            $tabla->integer('estado');   

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
        Schema::drop('bg_pago_flete');
    }
}
