<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVoucherTarjetasTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('voucher_tarjetas', function (Blueprint $tabla) {

			$tabla->increments('id');

			$tabla->date('fecha_corte');
			$tabla->string('codigo_corte',12);

			$tabla->string('no_lote',20);
			$tabla->float('total');
			$tabla->string('observaciones',100);

			$tabla->integer('estado_corte_id')->unsigned()->nullable();
            $tabla->foreign('estado_corte_id')->references('id')->on('estado_corte')->onDelete('cascade');

			$tabla->integer('user_id')->unsigned()->nullable();
			$tabla->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

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
		Schema::drop('voucher_tarjetas');
	}
}
