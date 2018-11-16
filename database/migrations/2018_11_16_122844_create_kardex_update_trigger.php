<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKardexUpdateTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        DB::unprepared('
        
        CREATE DEFINER=`root`@`localhost` TRIGGER `kardex_update` BEFORE UPDATE ON `movimientos_productos` FOR EACH ROW BEGIN
        DECLARE existencia float;
        DECLARE salida float;
        DECLARE fecha datetime DEFAULT NOW();
        set existencia = (SELECT IF(SUM(mp.existencias) IS NULL,0,SUM(mp.existencias)) AS existencias FROM movimientos_productos mp where mp.producto_id = old.producto_id);
        set salida = old.existencias - new.existencias;
        
        insert into kardex (fecha, producto_id, ingreso, salida, existencia_anterior, saldo ) 
        values(fecha, old.producto_id, 0, salida, existencia, existencia - salida);
        END

        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
