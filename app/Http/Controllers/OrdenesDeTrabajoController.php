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
Use App\ComponentesAccesorios;
Use App\Servicio;
Use App\Golpe;
Use App\Rayon;
Use App\ClasificacionCliente;
use App\Transmision;
use App\Traccion;
use App\Tipo_caja;
use App\Combustible;
use App\Direccion;
use App\Linea;
use App\Color;

class OrdenesDeTrabajoController extends Controller
{
    public function index()
    {
        return view ("ordenes_de_trabajo.index");
    }

    public function new()
    {
        $query = "SELECT * FROM marcas WHERE tipo_marca_id=".'1'." OR tipo_marca_id='2'";
        $marcas = DB::select($query);

        $tipos_transmision = Transmision::all();
        $lineas= Linea::all();
        $colores= Color::all();
        $direcciones= Direccion::all();
        $tipos_caja= Tipo_caja::all();
        $combustibles= Combustible::all();
        $tracciones= Traccion::all();

        $clientes = Cliente::all();
        $vehiculos = Vehiculo::all();
        $tipos_clientes = TipoCliente::all();
        $tipos_vehiculos = TipoVehiculo::all();
        $clasificaciones = ClasificacionCliente::all();
		return view("ordenes_de_trabajo.create" , compact('clientes', 'vehiculos', 'tipos_clientes', 'tipos_vehiculos', 'marcas', 'clasificaciones', 'tipos_transmision', 'lineas', 'colores', 'direcciones', 'tipos_caja', 'combustibles', 'tracciones'));
    }

    public function create2(OrdenDeTrabajo $orden_de_trabajo)
    {
        $componentesAccesorios = ComponentesAccesorios::All();
        $id=$orden_de_trabajo->id;
        
        return view("ordenes_de_trabajo.create2", compact('orden_de_trabajo', 'componentesAccesorios'));
        
    }
    public function create3(OrdenDeTrabajo $orden_de_trabajo)
    {
        $id=$orden_de_trabajo->id;
        
        return view("ordenes_de_trabajo.create3", compact('orden_de_trabajo'));
        
    }
    
    public function createServicios(OrdenDeTrabajo $orden_de_trabajo)
    {
        $servicios = Servicio::all();
        
		return view("ordenes_de_trabajo.createServicios", compact('orden_de_trabajo', 'servicios'));
        
    }

    public function updateTotal(OrdenDeTrabajo $orden_de_trabajo, Request $request)
	{
        $data = $request->all();
        $orden_de_trabajo->update(['total' => $request['total']]);
        return $orden_de_trabajo;		
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

        $orden_de_trabajo = $request['orden_id'];
               

		return Response::json($componentes);
    }
    public function golpes(Request $request)
	{
        $data = $request->all();  
        $golpes=Golpe::create($data);
        $orden_de_trabajo = $request['orden_id'];
              

		return Response::json($golpes);
    }
    public function rayones(Request $request)
	{
        $data = $request->all();  
        $rayones=Rayon::create($data);
        $orden_de_trabajo = $request['orden_id'];
              

		return Response::json($rayones);
    }



    public function saveServicios(OrdenDeTrabajo $orden_de_trabajo, Request $request)
	{
        $statsArray = $request->all();
		foreach($statsArray as $stat) {

            $stat['servicio_id'] = $stat['servicio_id'];
            $stat['mano_obra'] = $stat['mano_obra'];
            //$stat["subtotal"] = $stat["subtotal_venta"];
        
            $orden_de_trabajo->orden_trabajo_servicio()->create($stat);
            
		}
		return Response::json(['result' => 'ok']);

    }

    public function save(Request $request)
	{
        $data = $request->all();
        $data['fecha_hora'] = Carbon::createFromFormat('d-m-y h:i:s A', $request['fecha_hora']);
        $orden_de_trabajo = OrdenDeTrabajo::create($data);

        //return Response::json($orden_de_trabajo);
        return redirect()->route('ordenes_de_trabajo.create2', $orden_de_trabajo);
    }

    
    public function getJson(Request $params)
    {
        $api_Result = array();
        // Create a mapping of our query fields in the order that will be shown in datatable.
        $columnsMapping = array("id");

        // Initialize query (get all)

        $api_logsQueriable = DB::table('ordenes_de_trabajo');
        $api_Result['recordsTotal'] = $api_logsQueriable->count();

        $query = "SELECT * FROM ordenes_de_trabajo";

        $where = "";

        if (isset($params->search['value']) && !empty($params->search['value'])){

            foreach ($columnsMapping as $column) {
                if (strlen($where) == 0) {
                    $where .=" and (".$column." like  '%".$params->search['value']."%' ";
                } else {
                    $where .=" or ".$column." like  '%".$params->search['value']."%' ";
                }

            }
            $where .= ') ';
        }
        $condition = " ";
        $query = $query . $condition . $where;

        // Sorting
        $sort = "";
        foreach ($params->order as $order) {
            if (strlen($sort) == 0) {
                $sort .= 'order by ' . $columnsMapping[$order['column']] . ' '. $order['dir']. ' ';
            } else {
                $sort .= ', '. $columnsMapping[$order['column']] . ' '. $order['dir']. ' ';
            }
        }

        $result = DB::select($query);
        $api_Result['recordsFiltered'] = count($result);

        $filter = " limit ".$params->length." offset ".$params->start."";

        $query .= $sort . $filter;

        $result = DB::select($query);
        $api_Result['data'] = $result;

        return Response::json( $api_Result );
    }
}
