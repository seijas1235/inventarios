<?php

use Illuminate\Database\Seeder;
use App\Tipo_Cuenta_Contable;

class TipoCuentaContableTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tcc=new Tipo_Cuenta_Contable();
        $tcc->tipo_cuenta_contable="Debe";
        $tcc->save();

        $tcc=new Tipo_Cuenta_Contable();
        $tcc->tipo_cuenta_contable="Haber";
        $tcc->save();
    }
}
