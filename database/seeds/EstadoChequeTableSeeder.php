<?php

use Illuminate\Database\Seeder;
use App\estado_cheque;

class EstadoChequeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	
    	$ech=new estado_cheque();
    	$ech->estado_cheque="Creado";
    	$ech->save();

        $ech=new estado_cheque();
        $ech->estado_cheque="Emitido";
        $ech->save();

        $ech=new estado_cheque();
        $ech->estado_cheque="Anulado";
        $ech->save();

        $ech=new estado_cheque();
        $ech->estado_cheque="Cobrado";
        $ech->save();

    }
}
