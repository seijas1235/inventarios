<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProveedoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('proveedores', function($tabla)
       {
        $tabla->increments('id');
        $tabla->string('nit',15);
        $tabla->string('nombre_comercial',40);
        $tabla->string('representante',40);
        $tabla->string('telefonos',25);
        $tabla->string('cuentac',50);
        $tabla->string('direccion',50);

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
        Schema::drop('proveedores');
    }
}
