<?php

use Illuminate\Database\Seeder;
use App\operacion_bancaria;

class OperacionBancariaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ob=new operacion_bancaria();
    	$ob->fecha_transaccion=0;
    	$ob->cuenta_id=0;
    	$ob->documento_id=1;
    	$ob->no_documento=0;
    	$ob->debitos=0;
    	$ob->creditos=0;
    	$ob->saldo=0;
    	$ob->descripcion=0;
    	$ob->user_id=1;
    	$ob->estado=1;
    	$ob->save();
    }
}
