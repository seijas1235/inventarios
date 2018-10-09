<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use App\Planilla;
use App\User;
use App\Empleado;
use App\DetallePlanilla;
use View;
Use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Kodeine\Acl\Models\Eloquent\Role;
use Kodeine\Acl\Models\Eloquent\Permission;
use Carbon\Carbon;

class PlanillasController extends Controller
{
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
	}
	

    public function index()
    {
        $empleados = Empleado::all();
        return view ("planillas.index", compact('empleados'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$empleados = Empleado::all();
		return view("planillas.create" , compact("empleados") );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
	{
		$data = $request->all();
		$data["user_id"] = Auth::user()->id;
		$data['fecha_factura'] = Carbon::createFromFormat('d-m-Y', $data['fecha_factura']);
		$maestro = Planilla::create($data);
		return $maestro;
	}

	public function saveDetalle(Request $request, Planilla $planilla)
	{
		$statsArray = $request->all();
		foreach($statsArray as $stat) {

			$stat['user_id'] = Auth::user()->id;
			$stat['producto_id'] = $stat['producto_id'];
			$stat["precio_venta"] = $stat["precio_venta"];
			$stat["subtotal"] = $stat["subtotal_venta"];
			$stat['existencias'] = $stat["cantidad"];
			$stat["precio_planilla"] = $stat["precio_planilla"];
			$stat['fecha_ingreso'] = Carbon::now();
		
			$detalle = MovimientoEmpleado::create($stat);
			$stat["movimiento_producto_id"] = $detalle->id;
			$planilla->detalles_planillas()->create($stat);
	
			
		}
		return Response::json(['result' => 'ok']);

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */


	public function show(Planilla $planilla)
	{
		return view('planillas.show')->with('planilla', $planilla);
	}


	public function getName(Planilla $planilla )
	{
		$date =Carbon::createFromFormat('Y-m-d H:i:s', $planilla->fecha_factura)->format('d-m-Y');
		$planilla->fecha_factura = $date;
		return Response::json($planilla);
	}

	public function getDetalle( DetallePlanilla $detalleplanilla)
	{
		$ingresoplanilla = DetallePlanilla::where( "detalles_planillas.id" , "=" , $detalleplanilla->id )
		->select( "existencias", "precio_planilla", "precio_venta")
		->get()
		->first();
		return Response::json( $ingresoplanilla);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Planilla $planilla)
	{
		$query = "SELECT * FROM planillas WHERE id=".$planilla->id."";
		$fieldsArray = DB::select($query);
		
        return view ("planillas.edit", compact('planilla', 'fieldsArray'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */


	public function update(Planilla $planilla, Request $request )
	{
		Response::json($this->updateIngresoEmpleado($planilla , $request->all()));
        return redirect('/planillas');

	}

	public function updateIngresoEmpleado(Planilla $planilla, array $data )
	{

		//$data['fecha_factura'] = Carbon::createFromFormat('d-m-Y', $data['fecha_factura']);
		$planilla->serie_factura = $data["serie_factura"];
		$planilla->num_factura = $data["num_factura"];
		$planilla->fecha_factura = $data["fecha_factura"];
		$planilla->proveedor_id = $data["proveedor_id"];
		$planilla->save();
		return $planilla;
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy( Planilla $planilla,  Request $request)
	{
		$user1= Auth::user()->password;

		if ($request["password_delete"] == "")
		{
			$response["password_delete"]  = "La contraseña es requerida";
			return Response::json( $response  , 422 );
		}
		else if( password_verify( $request["password_delete"] , $user1))
		{
			$detalles = DetallePlanilla::where('planilla_id', $planilla->id)
			->get();
			foreach($detalles as $detalle) 
			{
				$producto = MovimientoEmpleado::where('id', $detalle["movimiento_producto_id"])
				->get()->first();
				$newExistencias = 0;
				$updateExistencia = MovimientoEmpleado::where('id', $detalle["movimiento_producto_id"])
				->update(['existencias' => $newExistencias]);
			}
			$planilla->delete();
			$response["response"] = "El registro ha sido borrado";
			return Response::json( $response );
		}
		else {
			$response["password_delete"] = "La contraseña no coincide";
			return Response::json( $response  , 422 );
		}
	}

	public function destroyDetalle(DetallePlanilla $detalleplanilla,  Request $request)
	{
		$user1= Auth::user()->password;

		if ($request["password_delete"] == "")
		{
			$response["password_delete"]  = "La contraseña es requerida";
			return Response::json( $response  , 422 );
		}
		else if( password_verify( $request["password_delete"] , $user1))
		{
			$producto = MovimientoEmpleado::where('id', $detalleplanilla->movimiento_producto_id)
			->get()->first();
			$existencias = $producto->existencias;
			$cantidad = $detalleplanilla->existencias;
			$newExistencias = $existencias - $cantidad;
			$updateExistencia = MovimientoEmpleado::where('id', $detalleplanilla->movimiento_producto_id)
			->update(['existencias' => $newExistencias]);


			$ingresomaestro = Planilla::where('id', $detalleplanilla->planilla_id)
			->get()->first();
			$total = $ingresomaestro->total_factura;
			$totalresta = ($detalleplanilla->precio_planilla * $detalleplanilla->existencias);
			$newTotal = $total - $totalresta;
			$updateTotal = Planilla::where('id', $detalleplanilla->planilla_id)
			->update(['total_factura' => $newTotal]);


			$detalleplanilla->delete();
			$response["response"] = "El registro ha sido borrado";
			return Response::json( $response );
		}
		else {
			$response["password_delete"] = "La contraseña no coincide";
			return Response::json( $response  , 422 );
		}
	}

	public function getJson(Request $params)

	{
		$api_Result = array();
		// Create a mapping of our query fields in the order that will be shown in datatable.
		$columnsMapping = array("serie_factura", "num_factura","fecha_factura", "nombre_comercial","total_factura");

		// Initialize query (get all)

		$api_logsQueriable = DB::table("planillas");
		$api_Result["recordsTotal"] = $api_logsQueriable->count();

		$query = 'SELECT planillas.id, planillas.serie_factura, planillas.num_factura, DATE_FORMAT(planillas.fecha_factura, "%d-%m-%Y") as fecha_factura, proveedores.nombre, TRUNCATE(planillas.total_factura,2) as total FROM planillas INNER JOIN proveedores ON proveedores.id=planillas.proveedor_id ';

		$where = "";

		if (isset($params->search['value']) && !empty($params->search['value'])){

			foreach ($columnsMapping as $column) {
				if (strlen($where) == 0) {
					$where .=" where (".$column." like  '%".$params->search['value']."%' ";
				} else {
					$where .=" or ".$column." like  '%".$params->search['value']."%' ";
				}

			}
			$where .= ') ';
		}

		$query = $query . $where;

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



	public function getJsonDetalle(Request $params, $detalle)
	{
		$api_Result = array();
		// Create a mapping of our query fields in the order that will be shown in datatable.
		$columnsMapping = array("dc.planilla_id", "p.codigo_barra", "p.nombre", "dc.existencias", "dc.precio_planilla", "dc.precio_venta");

		// Initialize query (get all)


		$api_logsQueriable = DB::table('detalles_planillas');
		$api_Result['recordsTotal'] = $api_logsQueriable->count();

		//$query = 'SELECT detalles_planillas.id, detalles_planillas.planilla_id, empleados.codigo_barra, empleados.nombre, detalles_planillas.existencias, detalles_planillas.precio_planilla, detalles_planillas.precio_venta FROM detalles_planillas INNER JOIN empleados ON detalles_planillas.producto_id=empleados.id WHERE detalles_planillas.planilla_id ='.$detalle.' ';
		$query = 'SELECT dc.id, dc.planilla_id, p.codigo_barra, p.nombre, m.codigo_maquina, m.nombre_maquina, dc.existencias, dc.precio_planilla, dc.precio_venta
		FROM detalles_planillas dc
		left join empleados p on p.id = dc.producto_id
		left join maquinarias_y_equipos m on m.id = dc.maquinaria_equipo_id where dc.planilla_id ='.$detalle.'';

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

		$query = $query . $where;

		// Sorting
		$sort = "";
		foreach ($params->order as $order) {
			if (strlen($sort) == 0) {
				$sort .= ' order by ' . $columnsMapping[$order['column']] . ' '. $order['dir']. ' ';
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
