<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use App\Producto;
use App\TipoPago;
use App\Venta;
use App\VentaDetalle;
use App\Servicio;
use App\MovimientoProducto;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Mail;
class VentasController extends Controller
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
		$tipo_pagos = TipoPago::all();
		return view("venta.index", compact("tipo_pagos"));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$back = "producto";
		$today = date("Y/m/d");
		$tipo_pagos = TipoPago::all();
		$servicios = Servicio::all();
		return view("venta.create" , compact( "back", "tipo_pagos", "today",'servicios'));
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
		$data["user_id"] = Auth::user()->id;
		$data["edo_venta_id"] = 1;
		$maestro = Venta::create($data);
		return $maestro;
	}

	public function saveDetalle(Request $request, Venta $venta_maestro)
	{
		$statsArray = $request->all();
		foreach($statsArray as $stat) {
			$producto = MovimientoProducto::where('id', $stat["movimiento_id"])
			->get()->first();
			$stat["precio_compra"] = $stat["precio_compra"];
			$stat["precio_venta"] = $stat["precio_venta"];
			$stat["subtotal"] = $stat["precio_venta"] * $stat["cantidad"];
			$stat["movimiento_producto_id"] = $stat["movimiento_id"];
			$result = $venta_maestro->ventadetalle()->create($stat);
			$total_venta = $venta_maestro->total_venta + $stat["subtotal"];
			$venta_maestro->total_venta = $total_venta;
			$venta_maestro->save();
			$existencias = $producto->existencias;
			$cantidad = $stat["cantidad"];
			$newExistencias = $existencias - $cantidad;
			$updateExistencia = MovimientoProducto::where('id', $stat["movimiento_id"])
			->update(['existencias' => $newExistencias]);
		}
		return Response::json($result);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show(Venta $venta_maestro)
	{
		return view('venta.show')->with('venta_maestro', $venta_maestro);
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
	public function update(Venta $venta_maestro, Request $request)
	{
		$data = $request->all();
		$venta_maestro->tipo_pago_id = $data["tipo_pago_id"];
		$venta_maestro->save();
		return $venta_maestro;	
	}
	
	public function updateTotal(Venta $venta_maestro, Request $request)
	{
		$data = $request->all();
		$venta_maestro->tipo_pago_id = $data["tipo_pago_id"];
		$venta_maestro->save();
		return $venta_maestro;
		
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Venta $venta_maestro, Request $request)
	{

		$user1= Auth::user()->password;

		if ($request["password_delete"] == "")
		{
			$response["password_delete"]  = "La contraseña es requerida";
			return Response::json( $response  , 422 );
		}
		else if( password_verify( $request["password_delete"] , $user1))
		{
			$detalles = VentaDetalle::where('venta_id', $venta_maestro->id)
			->get();
			foreach($detalles as $detalle) 
			{
				$producto = MovimientoProducto::where('id', $detalle["movimiento_producto_id"])
				->get()->first();
				$existencias = $producto->existencias;
				$cantidad = $detalle->cantidad;
				$newExistencias = $existencias + $cantidad;
				$updateExistencia = MovimientoProducto::where('id', $detalle["movimiento_producto_id"])
				->update(['existencias' => $newExistencias]);
			}
			$venta_maestro->delete();
			$response["response"] = "El registro ha sido borrado";
			return Response::json( $response );
		}
		else {
			$response["password_delete"] = "La contraseña no coincide";
			return Response::json( $response  , 422 );
		}
	}



	public function destroyDetalle(VentaDetalle $venta_detalle, Request $request)
	{

		$user1= Auth::user()->password;

		if ($request["password_delete"] == "")
		{
			$response["password_delete"]  = "La contraseña es requerida";
			return Response::json( $response  , 422 );
		}
		else if( password_verify( $request["password_delete"] , $user1))
		{
			$producto = MovimientoProducto::where('id', $venta_detalle->movimiento_producto_id)
			->get()->first();
			$existencias = $producto->existencias;
			$cantidad = $venta_detalle->cantidad;
			$newExistencias = $existencias + $cantidad;
			$updateExistencia = MovimientoProducto::where('id', $venta_detalle->movimiento_producto_id)
			->update(['existencias' => $newExistencias]);

			$ventamaestro = Venta::where('id', $venta_detalle->venta_id)
			->get()->first();
			$total = $ventamaestro->total_venta;
			$totalresta = $venta_detalle->subtotal;
			$newTotal = $total - $totalresta;
			$updateTotal = Venta::where('id', $venta_detalle->venta_id)
			->update(['total_venta' => $newTotal]);

			
			$venta_detalle->delete();
			$response["response"] = "El registro ha sido borrado";
			return Response::json( $response );
		}
		else {
			$response["password_delete"] = "La contraseña no coincide";
			return Response::json( $response  , 422 );
		}
	}

	public function destroyDetalle2(VentaDetalle $venta_detalle, MovimientoProducto $movimiento_producto, Request $request)
	{
		$existencias = $movimiento_producto->existencias;
		$cantidad = $venta_detalle->cantidad;
		$newExistencias = $existencias + $cantidad;
		$updateExistencia = MovimientoProducto::where('id', $movimiento_producto->id)
		->update(['existencias' => $newExistencias]);


		$ventamaestro = Venta::where('id', $venta_detalle->venta_id)
		->get()->first();
		$total = $ventamaestro->total_venta;
		$totalresta = $venta_detalle->subtotal;
		$newTotal = $total - $totalresta;
		$updateTotal = Venta::where('id', $venta_detalle->venta_id)
		->update(['total_venta' => $newTotal]);

		$venta_detalle->delete();
		$response["response"] = "El registro ha sido borrado";
		return Response::json($response);
	}



	public function getTipoPago( Venta $venta_maestro )
	{
		$result = Venta::where( "id" , "=" , $venta_maestro->id )
		->get()
		->first();
		return Response::json( $result);
	}

	public function makeCorte (Request $request)
	{
		$user1= Auth::user()->password;
		if ($request["password_delete"] == "")
		{
			$response["password_delete"]  = "La contraseña es requerida";
			return Response::json( $response  , 422 );
		}
		else if( password_verify( $request["password_delete"] , $user1))
		{

			$user = Auth::user()->name;
			Mail::send('email.test', ['user' => $user], function ($m) use ($user) {
				$data = PdfController::getDataCCresumen();
				$user = Auth::user()->name;
				$today = Carbon::now();

				$efec = "SELECT SUM(VD.subtotal) AS efectivo FROM ventas_maestro VM INNER JOIN ventas_detalle VD ON VM.id = VD.venta_id WHERE VM.edo_venta_id = 1 AND VM.tipo_pago_id=1";
				$efectivo = DB::select($efec);

				$tar = "SELECT SUM(VD.subtotal) AS tarjeta FROM ventas_maestro VM INNER JOIN ventas_detalle VD ON VM.id = VD.venta_id WHERE VM.edo_venta_id = 1 AND VM.tipo_pago_id=2";
				$tarjeta = DB::select($tar);        

				$sub1 = "SELECT SUM(VD.subtotal) AS subtotal1 FROM ventas_maestro VM INNER JOIN ventas_detalle VD ON VM.id = VD.venta_id WHERE VM.edo_venta_id = 1 AND VM.tipo_pago_id=1";
				$subtotal1 = DB::select($sub1); 

				$sub11 = "SELECT SUM(VD.subtotal) + 400 AS subtotal11 FROM ventas_maestro VM INNER JOIN ventas_detalle VD ON VM.id = VD.venta_id WHERE VM.edo_venta_id = 1";
				$subtotal11 = DB::select($sub11); 

				$sub12 = "SELECT (SUM(VD.subtotal) + 400) - (SELECT SUM(VD.subtotal) AS tarjeta FROM ventas_maestro VM INNER JOIN ventas_detalle VD ON VM.id = VD.venta_id WHERE VM.edo_venta_id = 1 AND VM.tipo_pago_id=2) AS subtotal12 FROM ventas_maestro VM INNER JOIN ventas_detalle VD ON VM.id = VD.venta_id WHERE VM.edo_venta_id = 1";
				$subtotal12 = DB::select($sub12); 

				$sub2 = "SELECT SUM(VD.subtotal) - 400 AS subtotal2 FROM ventas_maestro VM INNER JOIN ventas_detalle VD ON VM.id = VD.venta_id WHERE VM.edo_venta_id = 1 AND VM.tipo_pago_id=1";
				$subtotal2 = DB::select($sub2); 

				$view =  \View::make('pdf.pdf_ccresumen', compact('data', 'user', 'today', 'efectivo', 'tarjeta', 'subtotal1', 'subtotal2', 'subtotal11', 'subtotal12'))->render();
				$pdf = \App::make('dompdf.wrapper');
				$pdf->loadHTML($view);


				$data = PdfController::getDataCCdetalle();

				$efec = "SELECT SUM(VD.subtotal) AS efectivo FROM ventas_maestro VM INNER JOIN ventas_detalle VD ON VM.id = VD.venta_id WHERE VM.edo_venta_id = 1 AND VM.tipo_pago_id=1";
				$efectivo1 = DB::select($efec);

				$tar = "SELECT SUM(VD.subtotal) AS tarjeta FROM ventas_maestro VM INNER JOIN ventas_detalle VD ON VM.id = VD.venta_id WHERE VM.edo_venta_id = 1 AND VM.tipo_pago_id=2";
				$tarjeta1 = DB::select($tar);        

				$sub1 = "SELECT SUM(VD.subtotal) AS subtotal1 FROM ventas_maestro VM INNER JOIN ventas_detalle VD ON VM.id = VD.venta_id WHERE VM.edo_venta_id = 1";
				$subtotal1 = DB::select($sub1);

				$view =  \View::make('pdf.pdf_ccdetalle', compact('data', 'user', 'today', 'tarjeta1','subtotal1','efectivo1'))->render();
				$pdf2 = \App::make('dompdf.wrapper');
				$pdf2->loadHTML($view);

				$m->from('info@vrinfosysgt.com', 'VR InfoSys');

				$m->to("carburantesdecalidad@hotmail.com", "Amaris Pazos")->subject('Corte de Caja');

				$m->attachData($pdf->output(), 'corte.pdf');

				$m->attachData($pdf2->output(), 'detalle.pdf');


			});

			$today = Carbon::now();
			$query = "update ventas_maestro set edo_venta_id=4 where edo_venta_id=1";
			$result = DB::select($query);
			return view("home");
		}
		else {
			$response["password_delete"] = "La contraseña no coincide";
			return Response::json( $response  , 422 );
		}

	}

	public function getJson(Request $params)
	{
		$api_Result = array();
		$today = date("Y/m/d");
		// Create a mapping of our query fields in the order that will be shown in datatable.
		$columnsMapping = array("ventas_maestro.id", "ventas_maestro.subtotal_venta", "ventas_maestro.total_venta", "users.name", "estado_ventas.edo_venta", "tipo_pagos.tipo_pago");

		// Initialize query (get all)


		$api_logsQueriable = DB::table('ventas_maestro');
		$api_Result['recordsTotal'] = $api_logsQueriable->count();

		$query = 'Select TRUNCATE(total_venta,4) as total_venta, ventas_maestro.id, 
		tipos_pago.tipo_pago, estado_venta.edo_venta as edo_venta, users.name as name from ventas_maestro inner join 
		tipos_pago on ventas_maestro.tipo_pago_id=tipos_pago.id inner join users on users.id=ventas_maestro.user_id
		inner join estado_venta on ventas_maestro.edo_venta_id=estado_venta.id ';

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
		$condition = " where DATE(ventas_maestro.created_at)='".$today."' ";
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

	public function getJsonDetalle(Request $params, $detalle)
	{
		$api_Result = array();
		// Create a mapping of our query fields in the order that will be shown in datatable.
		$columnsMapping = array("id", "nombre", "cantidad", "subtotal");

		// Initialize query (get all)


		$api_logsQueriable = DB::table('ventas_detalle');
		$api_Result['recordsTotal'] = $api_logsQueriable->count();

		$query = 'SELECT venta_id As No_Venta, TRUNCATE(subtotal,4) as  subtotal, ventas_detalle.id, cantidad, nombre from ventas_detalle  inner join productos on ventas_detalle.producto_id=productos.id where venta_id='.$detalle.' ';

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