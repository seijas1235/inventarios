<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use View;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\vale_maestro;
use App\vale_detalle;
use App\cliente;
use App\combustible;
use App\producto;
use App\bomba;
use App\bg_factor;
use App\user;
use App\estado_vale;
use App\precio_combustible;
use App\CuentaCobrarMaestro;
use App\CuentaCobrarDetalle;
use App\Bomba_Combustible;
use App\idp;
use App\tipo_vehiculo;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Input;
use Mail;

class ValesController extends Controller
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

	public function getTipo(bomba $bomba) {

		$combustibles = Bomba_Combustible::where('bomba_id', $bomba->id)->pluck('combustible_id')->toArray();

		$tipos = combustible::whereIn('id', $combustibles)->get();

		return $tipos;
	}


	public function index()
	{
		return view("vales.index");
	}

	public function valeBlanco()
	{
		$clientes = cliente::where("estado_cliente_id", 1)->get();
		return view::make("vales.blanco", compact('clientes'));
	}


	public function rpt_vales()
	{
		$query = "SELECT id, CONCAT(cl_nombres,' ',cl_apellidos) AS cliente FROM clientes WHERE estado_cliente_id =1 ";

		$lst_clientes = DB::select($query);
		return View::make("reportes.listado_vales", compact('lst_clientes'));
	}



	public function Vale_Disponible()
	{
		$dato = Input::get("no_vale");
		$query = vale_maestro::where("no_vale",$dato)->where("estado_vale_id","<",4)->get();
		$contador = count($query);
		if ($contador == 0)
		{
			return 'false';
		}
		else
		{
			return 'true';
		}
	}


	public function getJson_rptvales(Request $params)
	{
		$api_Result = array();
		$today = date("Y/m/d");
		// Create a mapping of our query fields in the order that will be shown in datatable.
		$columnsMapping = array("cod", "fecha", "nombres", "apellidos");

		// Initialize query (get all)

		$api_logsQueriable = DB::table('vale_maestro');
		$api_Result['recordsTotal'] = $api_logsQueriable->count();

		$query = "SELECT vm.id as cod, date(vm.created_at) as fecha, cl.cl_nombres as nombres, cl.cl_apellidos as apellidos,
		ev.estado_vale as estado
		FROM vale_maestro vm 
		INNER JOIN clientes cl ON cl.id=vm.cliente_id
		INNER JOIN estado_vale ev ON vm.estado_vale_id=ev.id ";

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

		$query = $query . $where . $condition;

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


	public function rpt_valestotal()
	{
		return View::make("reportes.vales_porfecha");
	}


	public function destroy(vale_maestro $vale_maestro, Request $request)
	{
		
		$user1= Auth::user()->password;

		if ($request["password_delete"] == "")
		{
			$response["password_delete"]  = "La contraseña es requerida";
			return Response::json( $response  , 422 );
		}
		else if( password_verify( $request["password_delete"] , $user1))
		{
			$id= $vale_maestro->id;
			$vale_maestro->estado_vale_id = 4;

			$action="Vale Borrado, código de Vale ".$vale_maestro->id." con estado ".$vale_maestro->estado_vale_id." a estado 4";
			$bitacora = HomeController::bitacora($action);

			$vale_maestro->save();

			$cuenta_detalle = CuentaCobrarDetalle::where([
				['tipo_transaccion', 1], 
				['documento_id', $vale_maestro->id]
				])->get()->first();

			$cuenta_detalle->estado_cuenta_cobrar_id = 2;
			$cuenta_detalle->save();


			$estado_cuenta_detalle = CuentaCobrarDetalle::where('cuenta_cobrar_maestro_id', $cuenta_detalle->cuenta_cobrar_maestro_id)->orderBy('id', 'desc')->get()->first();

			$cuenta_maestro = CuentaCobrarMaestro::where('id', $cuenta_detalle->cuenta_cobrar_maestro_id)->get()->first();
			
			$detalle_cuenta["tipo_transaccion"] = 4;
			$detalle_cuenta["documento_id"] = $vale_maestro->id;
			$detalle_cuenta["total"] = $vale_maestro->total_vale;
			$detalle_cuenta["fecha_documento"] = $vale_maestro->fecha_corte;
			$detalle_cuenta["saldo"] = $estado_cuenta_detalle->saldo - $vale_maestro->total_vale; 
			$detalle_cuenta["estado_cuenta_cobrar_id"] = 2;
			$detalle_cuenta["user_id"] =  Auth::user()->id;

			$cliente = cliente::where("id", $vale_maestro->cliente_id)->get()->first(); 
			$cliente->cl_saldo = $estado_cuenta_detalle->saldo - $vale_maestro->total_vale; 
			$cliente->fecha_saldo = $vale_maestro->created_at;
			$cliente->save();



			$cuenta_maestro->cuenta_detalle()->create($detalle_cuenta);

			$detalles = vale_detalle::where('vale_maestro_id', $vale_maestro->id)->get();
			$user = Auth::user();


			Mail::send('email.test', ['vale_maestro' => $vale_maestro, 'user' => $user, 'detalles' => $detalles],  function ($m) use ($vale_maestro, $user, $detalles) {

				$m->from('info@vrinfosysgt.com', 'VR InfoSys');

				$m->to("ing.ivargas21314@gmail.com", "Noelia Pazos")->subject('Anulación de Vale');

				$response["response"] = "El registro ha sido borrado";
				return Response::json( $response );
			});

		}
		else {
			$response["password_delete"] = "La contraseña no coincide";
			return Response::json( $response  , 422 );
		}
	}


	public function getJson_rptvalestotal(Request $params)
	{
		$api_Result = array();
		$today = date("Y/m/d");
		// Create a mapping of our query fields in the order that will be shown in datatable.
		$columnsMapping = array("cod", "fecha", "nombres", "apellidos", "tot");

		// Initialize query (get all)

		$api_logsQueriable = DB::table('vale_maestro');
		$api_Result['recordsTotal'] = $api_logsQueriable->count();

		$query = "SELECT date(vm.created_at) as fecha, vm.id as cod, cl.cl_nombres as nombres, cl.cl_apellidos as apellidos, vm.total_vale as tot, ev.estado_vale as estado
		FROM vale_maestro vm 
		INNER JOIN clientes cl ON cl.id=vm.cliente_id
		INNER JOIN estado_vale ev ON vm.estado_vale_id=ev.id ";

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

		$query = $query . $where . $condition;

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


	public function getJson(Request $params)
	{
		$api_Result = array();
        // Create a mapping of our query fields in the order that will be shown in datatable.
		$columnsMapping = array("c.cl_nombres", "c.cl_apellidos", "v.no_vale", "v.created_at", "v.fecha_corte", "e.estado_vale", "us.name", "v.total_vale");

        // Initialize query (get all)

		$api_logsQueriable = DB::table('vale_maestro');
		$api_Result['recordsTotal'] = $api_logsQueriable->count();

		$query = "SELECT v.id AS id, v.no_vale as num, DATE_FORMAT(v.fecha_corte, '%d-%m-%Y') as fecha, v.created_at as created_at, TRUNCATE(v.total_vale,4) AS total_vale, e.estado_vale AS estado_vale, us.name AS name, CONCAT(c.cl_nombres,' ',c.cl_apellidos) as cliente, estado_corte_id
		FROM vale_maestro v
		INNER JOIN clientes c ON v.cliente_id=c.id
		INNER JOIN estado_vale e ON e.id=v.estado_vale_id
		INNER JOIN users us ON us.id=v.user_id
		INNER JOIN estado_corte ec ON ec.id=v.estado_corte_id ";

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

		return Response::json($api_Result);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$user = Auth::user()->id;
		$today = date("Y/m/d");
		$clientes = cliente::where("estado_cliente_id", 1)->get();
		$bombas = bomba::all();
		$combustibles = combustible::all();
		$productos = producto::where("estado_producto_id", 1)->get();
		$tipo_vehiculos = tipo_vehiculo::all();
		return view("vales.create" , compact( "user","today", "clientes", "bombas", "combustibles", "productos", "tipo_vehiculos"));
	}


	public function createauto()
	{
		$user = Auth::user()->id;
		$today = date("Y/m/d");
		$clientes = cliente::where("estado_cliente_id", 1)->get();
		$bombas = bomba::all();
		$combustibles = combustible::all();
		$productos = producto::where("estado_producto_id", 1)->get();
		$tipo_vehiculos = tipo_vehiculo::all();
		$vale = bg_factor::where("id",4)->get()->first();

		return view("vales.createauto" , compact( "user","today", "clientes", "bombas", "combustibles", "productos", "tipo_vehiculos", "vale"));
	}


	public function editVale(vale_maestro $vale) {

		$user = Auth::user()->id;
		$today = date("Y/m/d");
		$bombas = bomba::all();
		$combustibles = combustible::all();
		$productos = producto::where("estado_producto_id", 1)->get();
		return view("vales.edit" , compact( "vale", "user","today", "bombas", "combustibles", "productos"));

	}

	public function getEdit(vale_maestro $vale) {

		$user = Auth::user()->id;
		$today = date("Y/m/d");
		$clientes = cliente::where("estado_cliente_id", 1)->get();
		$tipo_vehiculos = tipo_vehiculo::all();
		return view("vales.edit2" , compact( "vale", "user","today", "clientes", "tipo_vehiculos"));

	}


	public function create2()
	{
		$user = Auth::user()->id;
		$today = date("Y/m/d");
		$clientes = cliente::all();
		$bombas = bomba::all();
		$combustibles = combustible::all();
		$productos = producto::where("estado_producto_id", 1)->get();
		return view("vales.create2" , compact( "user","today", "clientes", "bombas", "combustibles", "productos"));
	}


	public function getDetalle(vale_maestro $vale)
	{
		return view("vales.detalle" , compact( "vale"));
	}


	public function getJsonDetalle(Request $params, $vale)
	{
		$api_Result = array();
		// Create a mapping of our query fields in the order that will be shown in datatable.
		$columnsMapping = array("pr.nombre", "v.id", "vd.cantidad", "vd.precio_compra", "vd.precio_venta", "vd.subtotal");
		// Initialize query (get all)

		$api_logsQueriable = DB::table('vale_detalle');
		$api_Result['recordsTotal'] = $api_logsQueriable->count();

		$query = "SELECT  pr.nombre AS producto, v.id AS vale_id, vd.precio_compra AS precio_compra, vd.precio_venta as precio_venta, vd.cantidad as cantidad, vd.subtotal as subtotal
		FROM vale maestro v
		INNER JOIN vale_detalle vd ON vd.vale_maestro_id=v.id
		INNER JOIN producto pr ON pr.producto_id=pe.id";

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
		$condition = " WHERE pp.producto_id = ".$detalle." ";

		$query = $query . $where . $condition;

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

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$data = $request->all();
		$data["estado_vale_id"] = 1;
		$data["user_id"] = Auth::user()->id;
		$data["total_pagado"] = 0;
		$data["total_por_pagar"] = $data["total_vale"];
		$data["fecha_corte"]=Carbon::createFromFormat('d-m-Y', $data["fecha_corte"]);
		$data["estado_corte_id"] = 1;

		$bomba_c = Bomba_Combustible::where("bomba_id", $data["bomba_id"])->get()->first();
		$combustible_id = combustible::where("id", $bomba_c->combustible_id)->get()->first();

		$data["tipo_servicio"] = $combustible_id->tipo_servicio_id; 

		$vale_maestro = vale_maestro::create($data);

		$idp_diesel = 0;
		$idp_regular = 0;
		$idp_super = 0;
		$idp_total = 0;

		$idp_d = idp::where('combustible_id', 1)->get()->first();
		$idp_s = idp::where('combustible_id', 2)->get()->first();
		$idp_r = idp::where('combustible_id', 3)->get()->first();


		foreach($data['detalle'] as $detalle) 
		{
			$vale_detalle["precio_compra"] = $detalle["precio_compra"];
			$vale_detalle["precio_venta"] = $detalle["precio_venta"];
			$vale_detalle["subtotal"] = $detalle["subtotal"];
			$vale_detalle["cantidad"] = $detalle["cantidad"];
			$vale_detalle["user_id"] = Auth::user()->id;
			$vale_detalle["tipo_producto_id"] = $detalle["tipo"];
			if ($detalle["tipo"] == 1) 
			{
				$vale_detalle["producto_id"] = $detalle["producto_id"];
				$vale_detalle["combustible_id"] = 0;
			}
			else {
				$vale_detalle["combustible_id"] = $detalle["producto_id"];
				$vale_detalle["producto_id"] = 0;
			}

			if ($vale_detalle["combustible_id"] == 1 || $vale_detalle["combustible_id"] == 4) {
				$idp_diesel = $detalle["cantidad"] * $idp_d->costo_idp;
			}
			if ($vale_detalle["combustible_id"] == 2 || $vale_detalle["combustible_id"] == 5) {
				$idp_super = $detalle["cantidad"] * $idp_s->costo_idp;
			}
			if ($vale_detalle["combustible_id"] == 3 || $vale_detalle["combustible_id"] == 6) {
				$idp_regular = $detalle["cantidad"] * $idp_r->costo_idp;
			}

			$vale_maestro->vale_detalle()->create($vale_detalle);
		}

		$vale_maestro->idp_regular = $idp_regular;
		$vale_maestro->idp_super = $idp_super;
		$vale_maestro->idp_diesel = $idp_diesel;
		$idp_total = $idp_diesel + $idp_super + $idp_regular;
		$vale_maestro->idp_total = $idp_total;
		$vale_maestro->save();

		$cliente = cliente::where("id", $data["cliente_id"])->get()->first();


		$estado_cuenta = CuentaCobrarMaestro::where('cliente_id', $data["cliente_id"])->get()->first();

		
		if(count($estado_cuenta) != 0) {
			$estado_cuenta_detalle = CuentaCobrarDetalle::where('cuenta_cobrar_maestro_id', $estado_cuenta->id)->orderBy('id', 'desc')->get()->first();

			$detalle_cuenta["tipo_transaccion"] = 1;
			$detalle_cuenta["documento_id"] = $vale_maestro->id;
			$detalle_cuenta["total"] = $vale_maestro->total_vale;
			$detalle_cuenta["fecha_documento"] = $data["fecha_corte"];
			$detalle_cuenta["saldo"] = $estado_cuenta_detalle->saldo + $vale_maestro->total_vale; 
			$detalle_cuenta["estado_cuenta_cobrar_id"] = 1;
			$detalle_cuenta["user_id"] =  Auth::user()->id;
			$cliente->cl_saldo = $estado_cuenta_detalle->saldo + $vale_maestro->total_vale;
			$cliente->fecha_saldo = $vale_maestro->created_at;
			$cliente->save();

			$estado_cuenta->cuenta_detalle()->create($detalle_cuenta);

		}

		else {

			$new_estado['cliente_id'] = $vale_maestro->cliente_id;
			$new_estado['user_id'] = Auth::user()->id;
			$new_estado['estacion_id'] = 1;
			$new_estado['estado_cuenta_cobrar_id'] = 1;
			$estado_cuenta = CuentaCobrarMaestro::create($new_estado);

			$detalle_cuenta["tipo_transaccion"] = 1;
			$detalle_cuenta["documento_id"] = $vale_maestro->id;
			$detalle_cuenta["total"] = $vale_maestro->total_vale;
			$detalle_cuenta["fecha_documento"] = $data["fecha_corte"];
			$detalle_cuenta["saldo"] = $vale_maestro->total_vale; 
			$detalle_cuenta["estado_cuenta_cobrar_id"] = 1;
			$detalle_cuenta["user_id"] =  Auth::user()->id;
			$cliente->cl_saldo = $vale_maestro->total_vale;
			$cliente->fecha_saldo = $vale_maestro->created_at;
			$cliente->save();

			$estado_cuenta->cuenta_detalle()->create($detalle_cuenta);


		}

		return $vale_maestro;
	}




	public function storeauto(Request $request)
	{
		$data = $request->all();
		$data["estado_vale_id"] = 1;
		$data["user_id"] = Auth::user()->id;
		$data["total_pagado"] = 0;
		$data["total_por_pagar"] = $data["total_vale"];
		$data["fecha_corte"]=Carbon::createFromFormat('d-m-Y', $data["fecha_corte"]);
		$data["estado_corte_id"] = 1;


		$vale = bg_factor::where("id",4)->get()->first();
		$bomba_c = Bomba_Combustible::where("bomba_id", $data["bomba_id"])->get()->first();
		$combustible_id = combustible::where("id", $bomba_c->combustible_id)->get()->first();

		$data["tipo_servicio"] = $combustible_id->tipo_servicio_id; 
		$data["no_vale"] = $vale->indice + 1; 

		$vale->indice = $data["no_vale"];
		$vale->save();

		$vale_maestro = vale_maestro::create($data);

		$idp_diesel = 0;
		$idp_regular = 0;
		$idp_super = 0;
		$idp_total = 0;

		$idp_d = idp::where('combustible_id', 1)->get()->first();
		$idp_s = idp::where('combustible_id', 2)->get()->first();
		$idp_r = idp::where('combustible_id', 3)->get()->first();


		foreach($data['detalle'] as $detalle) 
		{
			$vale_detalle["precio_compra"] = $detalle["precio_compra"];
			$vale_detalle["precio_venta"] = $detalle["precio_venta"];
			$vale_detalle["subtotal"] = $detalle["subtotal"];
			$vale_detalle["cantidad"] = $detalle["cantidad"];
			$vale_detalle["user_id"] = Auth::user()->id;
			$vale_detalle["tipo_producto_id"] = $detalle["tipo"];
			if ($detalle["tipo"] == 1) 
			{
				$vale_detalle["producto_id"] = $detalle["producto_id"];
				$vale_detalle["combustible_id"] = 0;
			}
			else {
				$vale_detalle["combustible_id"] = $detalle["producto_id"];
				$vale_detalle["producto_id"] = 0;
			}

			if ($vale_detalle["combustible_id"] == 1 || $vale_detalle["combustible_id"] == 4) {
				$idp_diesel = $detalle["cantidad"] * $idp_d->costo_idp;
			}
			if ($vale_detalle["combustible_id"] == 2 || $vale_detalle["combustible_id"] == 5) {
				$idp_super = $detalle["cantidad"] * $idp_s->costo_idp;
			}
			if ($vale_detalle["combustible_id"] == 3 || $vale_detalle["combustible_id"] == 6) {
				$idp_regular = $detalle["cantidad"] * $idp_r->costo_idp;
			}

			$vale_maestro->vale_detalle()->create($vale_detalle);
		}

		$vale_maestro->idp_regular = $idp_regular;
		$vale_maestro->idp_super = $idp_super;
		$vale_maestro->idp_diesel = $idp_diesel;
		$idp_total = $idp_diesel + $idp_super + $idp_regular;
		$vale_maestro->idp_total = $idp_total;
		$vale_maestro->save();

		$cliente = cliente::where("id", $data["cliente_id"])->get()->first();


		$estado_cuenta = CuentaCobrarMaestro::where('cliente_id', $data["cliente_id"])->get()->first();

		
		if(count($estado_cuenta) != 0) {
			$estado_cuenta_detalle = CuentaCobrarDetalle::where('cuenta_cobrar_maestro_id', $estado_cuenta->id)->orderBy('id', 'desc')->get()->first();

			$detalle_cuenta["tipo_transaccion"] = 1;
			$detalle_cuenta["documento_id"] = $vale_maestro->id;
			$detalle_cuenta["total"] = $vale_maestro->total_vale;
			$detalle_cuenta["fecha_documento"] = $data["fecha_corte"];
			$detalle_cuenta["saldo"] = $estado_cuenta_detalle->saldo + $vale_maestro->total_vale; 
			$detalle_cuenta["estado_cuenta_cobrar_id"] = 1;
			$detalle_cuenta["user_id"] =  Auth::user()->id;
			$cliente->cl_saldo = $estado_cuenta_detalle->saldo + $vale_maestro->total_vale;
			$cliente->fecha_saldo = $vale_maestro->created_at;
			$cliente->save();

			$estado_cuenta->cuenta_detalle()->create($detalle_cuenta);

		}

		else {

			$new_estado['cliente_id'] = $vale_maestro->cliente_id;
			$new_estado['user_id'] = Auth::user()->id;
			$new_estado['estacion_id'] = 1;
			$new_estado['estado_cuenta_cobrar_id'] = 1;
			$estado_cuenta = CuentaCobrarMaestro::create($new_estado);

			$detalle_cuenta["tipo_transaccion"] = 1;
			$detalle_cuenta["documento_id"] = $vale_maestro->id;
			$detalle_cuenta["total"] = $vale_maestro->total_vale;
			$detalle_cuenta["fecha_documento"] = $data["fecha_corte"];
			$detalle_cuenta["saldo"] = $vale_maestro->total_vale; 
			$detalle_cuenta["estado_cuenta_cobrar_id"] = 1;
			$detalle_cuenta["user_id"] =  Auth::user()->id;
			$cliente->cl_saldo = $vale_maestro->total_vale;
			$cliente->fecha_saldo = $vale_maestro->created_at;
			$cliente->save();

			$estado_cuenta->cuenta_detalle()->create($detalle_cuenta);


		}

		return $vale_maestro;
	}





	public function storeBlanco(Request $request)
	{
		$data = $request->all();
		$data["estado_vale_id"] = 1;
		$data["bomba_id"] = 1;
		$data["total_vale"] = 0;
		$data["user_id"] = Auth::user()->id;


		for ($i = 1; $i <= $data["cantidad"]; $i++) {

			$vale = vale_maestro::create($data);

		}

		return $data;
	}


	

	public function storeEdit2(vale_maestro $vale_maestro, Request $request) {
		$data = $request->all();
		$vale_maestro->user_id = Auth::user()->id;
		$vale_maestro->piloto = $data["piloto"];
		$vale_maestro->placa = $data["placa"];
		$vale_maestro->tipo_vehiculo_id = $data["tipo_vehiculo_id"];
		$vale_maestro->cliente_id = $data["cliente_id"];
		$vale_maestro->no_vale = $data["no_vale"];
		$vale_maestro->fecha_corte = Carbon::createFromFormat('d-m-Y', $data['fecha_corte']);
		$vale_maestro->codigo_corte = $data["codigo_corte"];
		$vale_maestro->total_vale = $data["total_vale"];
		$vale_maestro->total_por_pagar = $data["total_vale"];

		$vale_maestro->save();

		$cuentas_detalle = CuentaCobrarDetalle::where("documento_id",$vale_maestro->id)->where("tipo_transaccion",1)->get()->first();
		$cuentas_maestro = CuentaCobrarMaestro::where("cliente_id",$vale_maestro->cliente_id)->get()->first();
		
		$cuentas_detalle->total = $data["total_vale"];
		$cuentas_detalle->cuenta_cobrar_maestro_id = $cuentas_maestro->id;
		$cuentas_detalle->fecha_documento = Carbon::createFromFormat('d-m-Y', $data["fecha_corte"]);
		$cuentas_detalle->save();

		return $vale_maestro;
	}



	public function storeEdit(vale_maestro $vale_maestro, Request $request)
	{
		$data = $request->all();
		$vale_maestro->user_id = Auth::user()->id;
		$vale_maestro->total_vale = $data["total_vale"];
		$vale_maestro->bomba_id = $data["bomba_id"];
		$vale_maestro->piloto = $data["piloto"];
		$vale_maestro->placa = $data["placa"];
		$vale_maestro->fecha_corte = $data["fecha_corte"];
		$vale_maestro->codigo_corte = $data["codigo_corte"];

		$vale_maestro->save();

		foreach($data['detalle'] as $detalle) 
		{
			$vale_detalle["precio_compra"] = $detalle["precio_compra"];
			$vale_detalle["precio_venta"] = $detalle["precio_venta"];
			$vale_detalle["subtotal"] = $detalle["subtotal"];
			$vale_detalle["cantidad"] = $detalle["cantidad"];
			$vale_detalle["user_id"] = Auth::user()->id;
			$vale_detalle["tipo_producto_id"] = $detalle["tipo"];
			if ($detalle["tipo"] == 1) 
			{
				$vale_detalle["producto_id"] = $detalle["producto_id"];
				$vale_detalle["combustible_id"] = 0;
			}
			else {
				$vale_detalle["combustible_id"] = $detalle["producto_id"];
				$vale_detalle["producto_id"] = 0;
			}
			$vale_maestro->vale_detalle()->create($vale_detalle);
		}


		$estado_cuenta = CuentaCobrarMaestro::where('cliente_id', $data["cliente_id"])->get()->first();

		
		if(count($estado_cuenta) != 0) {
			$estado_cuenta_detalle = CuentaCobrarDetalle::where('cuenta_cobrar_maestro_id', $estado_cuenta->id)->orderBy('id', 'desc')->get()->first();

			$detalle_cuenta["tipo_transaccion"] = 1;
			$detalle_cuenta["documento_id"] = $vale_maestro->id;
			$detalle_cuenta["total"] = $vale_maestro->total_vale;
			$detalle_cuenta["saldo"] = $estado_cuenta_detalle->saldo + $vale_maestro->total_vale; 
			$detalle_cuenta["estado_cuenta_cobrar_id"] = 1;
			$detalle_cuenta["user_id"] =  Auth::user()->id;

			$estado_cuenta->cuenta_detalle()->create($detalle_cuenta);

		}

		else {

			$new_estado['cliente_id'] = $vale_maestro->cliente_id;
			$new_estado['user_id'] = Auth::user()->id;
			$new_estado['estacion_id'] = 1;
			$new_estado['estado_cuenta_cobrar_id'] = 1;
			$estado_cuenta = CuentaCobrarMaestro::create($new_estado);

			$detalle_cuenta["tipo_transaccion"] = 1;
			$detalle_cuenta["documento_id"] = $vale_maestro->id;
			$detalle_cuenta["total"] = $vale_maestro->total_vale;
			$detalle_cuenta["saldo"] = $vale_maestro->total_vale; 
			$detalle_cuenta["estado_cuenta_cobrar_id"] = 1;
			$detalle_cuenta["user_id"] =  Auth::user()->id;

			$estado_cuenta->cuenta_detalle()->create($detalle_cuenta);


		}

		return $vale_maestro;
	}




	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show(vale_maestro $vale_maestro)
	{

		$detalles = vale_detalle::where('vale_maestro_id', $vale_maestro->id)->get();
		$pdf = PDF::loadView('vales.show', compact('vale_maestro', 'detalles'));
		$customPaper = array(0,0,311.81,453.54);
		$pdf->setPaper($customPaper, 'portrait');


		return $pdf->stream('vale', array("Attachment" => 0));
	}


	public function getVale(vale_maestro $vale_maestro)
	{

		$query = "SELECT vm.no_vale as no_vale, vm.created_at as created_at, CONCAT(cl.cl_nombres,' ',cl.cl_apellidos) as cliente, 
		us.name as empleado, vm.piloto as piloto, bm.bomba as bomba, tv.tipo_vehiculo as vehiculo, vm.placa as placa, vm.total_vale as total
		FROM vale_maestro vm
		INNER JOIN clientes cl ON vm.cliente_id=cl.id
		INNER JOIN users us ON vm.user_id=us.id
		INNER JOIN bomba bm ON vm.bomba_id=bm.id
		INNER JOIN tipo_vehiculo tv ON vm.tipo_vehiculo_id=tv.id
		WHERE vm.id= ".$vale_maestro->id." ";
		$valem = DB::select($query);

		$query2 = "SELECT vd.cantidad as cant, IF(vd.combustible_id >0,comb.combustible,prod.nombre) as descripcion, vd.subtotal as valor
		FROM vale_detalle vd
		LEFT JOIN combustible comb ON vd.combustible_id=comb.id
		LEFT JOIN productos prod ON vd.producto_id=prod.id
		WHERE vd.vale_maestro_id = ".$vale_maestro->id." ";
		$detalles = DB::select($query2);

		$view =  \View::make('vales.show', compact('detalles', 'valem'))->render();
		$pdf = \App::make('dompdf.wrapper');
		$pdf->loadHTML($view);
        $customPaper = array(0,0,300,500);
		$pdf->setPaper($customPaper, 'portrait');
		return $pdf->stream('vale', array("Attachment" => 0));
	}


	public function showValeBlanco(vale_maestro $vale_maestro)
	{

		$detalles = vale_detalle::where('vale_maestro_id', $vale_maestro->id)->get();
		$pdf = PDF::loadView('vales.blancoreporte', compact('vale_maestro', 'detalles'));
		$customPaper = array(0,0,300,720);
		$pdf->setPaper($customPaper, 'portrait');


		return $pdf->stream('vale', array("Attachment" => 0));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		//
	}
}
