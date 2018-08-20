<?php

use Illuminate\Database\Seeder;
use App\cargo_empleado;

class Cargos_EmpleadoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cargo=new cargo_empleado();
        $cargo->cargo_empleado="Administrador";
        $cargo->save();

        $cargo=new cargo_empleado();
        $cargo->cargo_empleado="Despachador";
        $cargo->save();

        $cargo=new cargo_empleado();
        $cargo->cargo_empleado="Contador";
        $cargo->save();

        $cargo=new cargo_empleado();
        $cargo->cargo_empleado="Supervisor";
        $cargo->save();

        $cargo=new cargo_empleado();
        $cargo->cargo_empleado="Cobrador";
        $cargo->save();

        $cargo=new cargo_empleado();
        $cargo->cargo_empleado="Financiero";
        $cargo->save();

        $cargo=new cargo_empleado();
        $cargo->cargo_empleado="Consulta";
        $cargo->save();
    }
}
