<?php

use Illuminate\Database\Seeder;
use App\documentos;

class DocumentosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $doc=new documentos();
    	$doc->documento="Factura";
    	$doc->save();

    	$doc=new documentos();
    	$doc->documento="Factura Cambiaria";
    	$doc->save();

    	$doc=new documentos();
    	$doc->documento="Nota de Crédito";
    	$doc->save();

        $doc=new documentos();
        $doc->documento="Nota de Débito";
        $doc->save();

        $doc=new documentos();
        $doc->documento="Cheque";
        $doc->save();

        $doc=new documentos();
        $doc->documento="Depósito Bancario";
        $doc->save();

        $doc=new documentos();
        $doc->documento="Vale";
        $doc->save();

        $doc=new documentos();
        $doc->documento="Recibo de Caja";
        $doc->save();

        $doc=new documentos();
        $doc->documento="Transferencia Bancaria";
        $doc->save();

        $doc=new documentos();
        $doc->documento="Depósito en Linea";
        $doc->save();

        $doc=new documentos();
        $doc->documento="Factura Electrónica";
        $doc->save();
    }
}
