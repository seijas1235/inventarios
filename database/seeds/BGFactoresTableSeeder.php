<?php

use Illuminate\Database\Seeder;
use App\bg_factor;

class BGFactoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bgf=new bg_factor();
    	$bgf->factor_calc="Activación BG Diario";
    	$bgf->indice=1;
    	$bgf->save();

    	$bgf=new bg_factor();
    	$bgf->factor_calc="Galon x Operacion";
    	$bgf->indice=0.6;
    	$bgf->save();

    	$bgf=new bg_factor();
    	$bgf->factor_calc="Galon x Seguro";
    	$bgf->indice=0.056;
    	$bgf->save();
    }
}
