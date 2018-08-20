<?php

use Illuminate\Database\Seeder;
use App\estado_flete;

class EstadoFleteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ef=new estado_flete();
    	$ef->estado_flete="Por Pagar";
    	$ef->save();

    	$ef=new estado_flete();
    	$ef->estado_flete="Pagado";
    	$ef->save();
    }
}
