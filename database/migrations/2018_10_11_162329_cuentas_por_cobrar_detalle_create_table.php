<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CuentasPorCobrarDetalleCreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuentas_por_cobrar_detalle', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('venta_id');
            $table->unsignedInteger('cuenta_por_cobrar_id');
            $table->string('num_factura') ->nullable();
            $table->date('fecha');
            $table->float('cargos')->nullable();
            $table->float('abonos')->nullable();
            $table->float('saldo')->nullable();

            $table->foreign('venta_id')->references('id')->on('ventas_maestro')->onDelete('cascade');
            $table->foreign('cuenta_por_cobrar_id')->references('id')->on('cuentas_por_cobrar')->onDelete('cascade');
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
        Schema::drop('cuentas_por_cobrar_detalle');
    }
}