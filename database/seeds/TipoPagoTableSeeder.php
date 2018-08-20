<?php

use Illuminate\Database\Seeder;
use App\Tipo_Pago;

class TipoPagoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$tp=new Tipo_Pago();
    	$tp->tipo_pago="Efectivo";
    	$tp->save();

    	$tp=new Tipo_Pago();
    	$tp->tipo_pago="Cheque";
    	$tp->save();

    	$tp=new Tipo_Pago();
    	$tp->tipo_pago="Transferencia";
    	$tp->save();

    	$tp=new Tipo_Pago();
    	$tp->tipo_pago="Depósito";
    	$tp->save();

    	$tp=new Tipo_Pago();
    	$tp->tipo_pago="Tarjeta Credito/Debito";
    	$tp->save();
    }
}
