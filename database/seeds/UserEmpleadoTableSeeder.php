<?php

use Illuminate\Database\Seeder;
use App\user_empleado;

class UserEmpleadoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ue=new user_empleado();
        $ue->user_id=1;
        $ue->empleado_id=1;
        $ue->save();
    }
}
