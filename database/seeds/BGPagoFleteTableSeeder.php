<?php

use Illuminate\Database\Seeder;
use App\bg_pago_fletes;

class BGPagoFleteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bgpf=new bg_pago_fletes();
    	$bgpf->fecha_documento=0;
    	$bgpf->documento=0;
    	$bgpf->no_documento=0;
    	$bgpf->cargo=0;
    	$bgpf->abono=0;
    	$bgpf->saldo=0;
    	$bgpf->observaciones=0;
    	$bgpf->estado=1;
    	$bgpf->save();
    }
}
