<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoCuentaContableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('tipo_cuenta_contable', function($tabla)
       {
        $tabla->increments('id');
        $tabla->string('tipo_cuenta_contable',20);

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
       Schema::drop('tipo_cuenta_contable');
   }
}
