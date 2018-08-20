<?php

use Illuminate\Database\Seeder;
use App\idp;

class IDPTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$idp=new idp();
    	$idp->combustible_id=1;
    	$idp->costo_idp=1.70;
    	$idp->user_id=1;
    	$idp->save();

    	$idp=new idp();
    	$idp->combustible_id=2;
    	$idp->costo_idp=4.70;
    	$idp->user_id=1;
    	$idp->save();

    	$idp=new idp();
    	$idp->combustible_id=3;
    	$idp->costo_idp=4.60;
    	$idp->user_id=1;
    	$idp->save();
    }
}
