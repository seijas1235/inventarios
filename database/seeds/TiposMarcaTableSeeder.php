<?php

use Illuminate\Database\Seeder;
use App\TipoMarca;

class TiposMarcaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoMarca::truncate();

        $tipo = new TipoMarca;
        $tipo->nombre= "General";
        $tipo->save();

        $tipo = new TipoMarca;
        $tipo->nombre= "Vehiculo";
        $tipo->save();

        $tipo = new TipoMarca;
        $tipo->nombre= "Producto";
        $tipo->save();
        
         $tipo = new TipoMarca;
        $tipo->nombre= "Maquinaria";
        $tipo->save();
    }
}
