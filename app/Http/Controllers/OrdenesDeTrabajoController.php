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

    public function createCarroceria(OrdenDeTrabajo $orden_de_trabajo)
    {
        
		return view("ordenes_de_trabajo.createCarroceria", compact('orden_de_trabajo'));
        
    }
    
    public function save2(Request $request)
	{
        $data = $request->all();

        
            $detalle = array(

                'emblemas' => $data["emblemas"],
                'encendedor' => $data["encendedor"],
                'espejos' => $data["espejos"],
                'antena' => $data["antena"],
                'radio' => $data["radio"],
                'llavero' => $data["llavero"],
                'placas' => $data["placas"],
                'platos' => $data["platos"],
                'tampon_combustible' => $data["tapon_combustible"],
                'soporte_bateria' => $data["soporte_bateria"],
                'papeles' => $data["papeles"],
                'alfombras' => $data["alfombras"],
                'control_alarma' => $data["control_alarma"],
                'extinguido' => $data["extinguidor"],
                'triangulo' => $data["triangulo"],
                'vidrios_electricos' => $data["vidrios_electricos"],
                'conos' => $data["conos"],
                'nebline' => $data["neblinera"],
                'luces' => $data["lices"],
                'llanta_repusto' => $data["llanta_repuesto"],
                'llave_ruedas' => $data["llave_ruedas"],
                'tricket' => $data["tricket"],
                'descripcion' => $data["descripcion"],
                'orden_id'=>$data["orden_id"]
                
            );					

        $componentes->componentes_accesorios()->create($detalle);
                   

		return Response::json($componentes);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
	{
        $data = $request->all();
        $orden_de_trabajo = OrdenDeTrabajo::create($data);

        //return Response::json($orden_de_trabajo);
        return redirect()->route('ordenes_de_trabajo.create2', $orden_de_trabajo);
    }
}
