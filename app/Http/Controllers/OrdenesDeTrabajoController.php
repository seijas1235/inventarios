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
