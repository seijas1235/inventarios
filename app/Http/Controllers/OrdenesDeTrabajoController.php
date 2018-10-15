<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
Use App\Vehiculo;
Use App\Cliente;
Use App\OrdenDeTrabajo;
Use App\TipoCliente;
Use App\TipoVehiculo;
Use App\Marca;
use App\TipoTransmision;
Use App\ComponentesAccesorios;

class OrdenesDeTrabajoController extends Controller
{
    public function new()
    {
        $query = "SELECT * FROM marcas WHERE tipo_marca_id=".'1'." OR tipo_marca_id='2'";
        $marcas = DB::select($query);

        $clientes = Cliente::All();
        $vehiculos = Vehiculo::All();
        $tipos_clientes = TipoCliente::all();
        $tipos_vehiculos = TipoVehiculo::all();
        $tipos_transmision = TipoTransmision::all();
		return view("ordenes_de_trabajo.create" , compact('clientes', 'vehiculos', 'tipos_clientes', 'tipos_vehiculos', 'marcas', 'tipos_transmision'));
    }

    public function create2(OrdenDeTrabajo $orden_de_trabajo)
    {
        $componentesAccesorios = ComponentesAccesorios::All();
		return view("ordenes_de_trabajo.create2", compact('orden_de_trabajo', 'componentesAccesorios'));
        
    }
<<<<<<< HEAD
   
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
=======
    
>>>>>>> 16fdd5275d3a4a51117ccc5f7d6411c172eff837
    public function save2(Request $request)
	{
        $data = $request->all();


        $componentes=ComponentesAccesorios::create($data);
                   

		return Response::json($componentes);
    }
    public function save(Request $request)
	{
        $data = $request->all();
        $orden_de_trabajo = OrdenDeTrabajo::create($data);

        //return Response::json($orden_de_trabajo);
        return redirect()->route('ordenes_de_trabajo.create2', $orden_de_trabajo);
    }
}
