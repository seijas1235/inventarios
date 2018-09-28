<?php

use Illuminate\Database\Seeder;
use App\Estado;

class EstadosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Estado::truncate();

        $estado = new Estado;
        $estado->estado= "Activo";
        $estado->save();
        
        $estado = new Estado;
        $estado->estado= "Finalizado";
        $estado->save();

        $estado = new Estado;
        $estado->estado= "Vencido";
        $estado->save();

    }
}
