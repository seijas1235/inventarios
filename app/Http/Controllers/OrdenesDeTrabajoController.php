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
Use App\ComponentesAccesorios;

class OrdenesDeTrabajoController extends Controller
{
    public function new()
    {
        $clientes = Cliente::All();
        $vehiculos = Vehiculo::All();
		return view("ordenes_de_trabajo.create" , compact('clientes', 'vehiculos'));
    }

    public function create2()
    {
        $componentesAccesorios = ComponentesAccesorios::All();
      
        return view("ordenes_de_trabajo.create2");
    }
   
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save2(Request $request)
	{
        $data = $request->all();


        $componentes=ComponentesAccesorios::create($data);
                   

		return Response::json($componentes);
    }
    public function save(Request $request)
	{
        $data = $request->all();

        $cuentaporpagar = CuentaPorPagar::where('proveedor_id',$data["proveedor_id"])->first();

            $detalle = array(
                'num_factura' => '',
                'fecha' => Carbon::now(),
                'descripcion' => 'Nota de Credito',
                'cargos' => 0,	
                'abonos' => $data["total"],
                'saldo' => $cuentaporpagar->total - $data["total"]
            );					

            $cuentaporpagar->detalles_cuentas_por_pagar()->create($detalle);
            $newtotal = $detalle['saldo'];
            $cuentaporpagar->update(['total' => $newtotal]);        

		return Response::json($cuentaporpagar);
    }
}
