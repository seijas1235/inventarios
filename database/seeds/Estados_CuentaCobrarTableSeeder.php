<?php

use Illuminate\Database\Seeder;
use App\estado_cuenta;

class Estados_CuentaCobrarTableSeeder extends Seeder
{
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $eemp=new estado_cuenta();
    	$eemp->estado_cuenta_cobrar="Activo";
    	$eemp->save();

    	$eemp=new estado_cuenta();
    	$eemp->estado_cuenta_cobrar="Inactivo";
    	$eemp->save();
    }
}
