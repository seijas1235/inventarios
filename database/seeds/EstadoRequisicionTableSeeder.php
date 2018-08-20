<?php

use Illuminate\Database\Seeder;
use App\estado_requisicion;

class EstadoRequisicionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ereq=new estado_requisicion();
    	$ereq->estado_requisicion="Creada";
    	$ereq->save();

    	$ereq=new estado_requisicion();
    	$ereq->estado_requisicion="Revisada";
    	$ereq->save();

    	$ereq=new estado_requisicion();
    	$ereq->estado_requisicion="Rechazada";
    	$ereq->save();

    	$ereq=new estado_requisicion();
    	$ereq->estado_requisicion="Autorizada";
    	$ereq->save();

    	$ereq=new estado_requisicion();
    	$ereq->estado_requisicion="Anulada";
    	$ereq->save();

        $ereq=new estado_requisicion();
        $ereq->estado_requisicion="Con Cheque";
        $ereq->save();

    }
}
