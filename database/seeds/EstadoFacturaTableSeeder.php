<?php

use Illuminate\Database\Seeder;
use App\estado_factura;

class EstadoFacturaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ef=new estado_factura();
    	$ef->estado_factura="Activa";
    	$ef->save();

    	$ef=new estado_factura();
    	$ef->estado_factura="Anulada";
    	$ef->save();
    }
}
