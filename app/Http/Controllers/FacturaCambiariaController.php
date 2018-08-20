<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\FacturaCambiariaMaestro;
use App\FacturaCambiariaDetalle;
use App\vale_maestro;
use App\cliente;
use App\series;
use App\vale_detalle;
use App\idp;
use App\precio_combustible;
use Barryvdh\DomPDF\Facade as PDF;
use Mail;
use Illuminate\Support\Facades\Input;
use Illuminate\Database\Query\Builder;


class FacturaCambiariaController extends Controller
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
		return view("factura_cambiaria.index");
	}


	public function save2(Request $request) {
		$data = $request->all();
		$cliente = cliente::where('id', $data["cliente_id"])->get()->first();
		$user = Auth::user();

		

		$idp_diesel = 0;
		$idp_regular = 0;
		$idp_super = 0;
		$idp_total = 0;

		$idp_d = idp::where('combustible_id', 1)->get()->first();
		$idp_s = idp::where('combustible_id', 2)->get()->first();
		$idp_r = idp::where('combustible_id', 3)->get()->first();


		$records = [];
		$total = 0;


		foreach($data['detalle'] as $detalle) 
		{
			$newData = new FacturaCambiariaDetalle;
			$exist = false;

			if ( count($records) >  0)
			{
				foreach ($records as $record) {
					
					if ($record["combustible_id"] == $detalle["combustible_id"] )
					{
						$record["cantidad"] = $record["cantidad"] + $detalle["cantidad"];
						$record["subtotal"] = $record["subtotal"] + $detalle["subtotal"];
						$exist= true;
					}
					

					if ($exist == false ) 
					{

						$newData->combustible_id = $detalle["combustible_id"];

						$newData->subtotal = $detalle["subtotal"];
						$newData->cantidad = $detalle["cantidad"];
						$newData->tipo_producto_id = 2;
						array_push($records, $newData);
					}

				}
			}
			else 
			{
				$newData->combustible_id = $detalle["combustible_id"];
				$newData->producto_id = 0;
				$newData->subtotal = $detalle["subtotal"];
				$newData->cantidad = $detalle["cantidad"];
				$newData->tipo_producto_id = 2;
				array_push($records, $newData);


			}
			$total = $total + $detalle["subtotal"];
		}

		$dataF["user_id"] = $user->id;
		$dataF["cliente_id"] =  $data["cliente_id"];
		$dataF["serie_id"] = $data["serie_id"];
		$dataF["estado_id"] = 1;
		$dataF["no_factura"] = $data["numero_factura"];
		$dataF["nit"] = $data["nit"];
		$dataF["direccion"] = $data["direccion"];
		$dataF["total"] = $total;
		$dataF["total_por_pagar"] = $total;
		$dataF["fecha_factura"] = Carbon::createFromFormat('d-m-Y', $data['fecha_factura']);

		$factura_cambiaria = FacturaCambiariaMaestro::create($dataF);


		foreach ($records as $record) {
			$datallito = $record["attributes"];
			$datallito["user_id"] = Auth::user()->id;

			if ($datallito["combustible_id"] == 1 || $datallito["combustible_id"] == 4) {
				$idp_diesel = $datallito["cantidad"] * $idp_d->costo_idp;
			}
			if ($datallito["combustible_id"] == 2 || $datallito["combustible_id"] == 5) {
				$idp_super = $datallito["cantidad"] * $idp_s->costo_idp;
			}
			if ($datallito["combustible_id"] == 3 || $datallito["combustible_id"] == 6) {
				$idp_regular = $datallito["cantidad"] * $idp_r->costo_idp;
			}

			$factura_cambiaria->factura_detalle()->create($datallito);

		}        


		$factura_cambiaria->idp_regular = $idp_regular;
		$factura_cambiaria->idp_super = $idp_super;
		$factura_cambiaria->idp_diesel = $idp_diesel;
		$idp_total = $idp_diesel + $idp_super + $idp_regular;
		$factura_cambiaria->idp_total = $idp_total;
		$factura_cambiaria->save();


		return $factura_cambiaria;


	}


	public function save(Request $request) {
		$data = $request->all();
		$valores = $data["selected"];
		$valore= array_map('trim', explode(',', $data["selected"]));
		$vales = vale_maestro::whereIn('id', $valore)->get();
		$cliente = cliente::where('id', $data["cliente_id"])->get()->first();
		$user = Auth::user();

		$idp_diesel = 0;
		$idp_regular = 0;
		$idp_super = 0;
		$idp_total = 0;

		$idp_d = idp::where('combustible_id', 1)->get()->first();
		$idp_s = idp::where('combustible_id', 2)->get()->first();
		$idp_r = idp::where('combustible_id', 3)->get()->first();


		$records = [];
		$total = 0;
		foreach ($vales as $vale) 
		{
			$newData = new FacturaCambiariaDetalle;

			$vale_detalles = vale_detalle::where('vale_maestro_id', $vale->id)->get();


			foreach ($vale_detalles as $detalle) {
				$newData = new FacturaCambiariaDetalle;
				$exist = false;

				if ( count($records) >  0)
				{
					foreach ($records as $record) {
						if ($detalle->tipo_producto_id == 2) 
						{
							if ($record["combustible_id"] == $detalle->combustible_id )
							{
								$record["cantidad"] = $record["cantidad"] + $detalle->cantidad;
								$record["subtotal"] = $record["subtotal"] + $detalle->subtotal;
								$exist= true;
							}
						}
						else if ($detalle->tipo_producto_id == 1) 
						{
							if ($record["producto_id"] == $detalle->producto_id )
							{
								$record["cantidad"] = $record["cantidad"] + $detalle->cantidad;
								$record["subtotal"] = $record["subtotal"] + $detalle->subtotal;
								$exist= true;
							}
						}
						if ($exist == false ) 
						{
							if ($detalle->tipo_producto_id == 2) 
							{
								$newData->combustible_id = $detalle->combustible_id;

							} 
							else if ($detalle->tipo_producto_id == 1) 
							{
								$newData->producto_id = $detalle->producto_id;

							}

							$newData->subtotal = $detalle->subtotal;
							$newData->cantidad = $detalle->cantidad;
							$newData->tipo_producto_id = $detalle->tipo_producto_id;
							array_push($records, $newData);
						}

					}
				}
				else 
				{
					if ($detalle->tipo_producto_id == 2) 
					{
						$newData->combustible_id = $detalle->combustible_id;
						$newData->producto_id = 0;

					} 
					else if ($detalle->tipo_producto_id == 1) 
					{
						$newData->producto_id = $detalle->producto_id;
						$newData->combustible_id = 0;


					}

					$newData->subtotal = $detalle->subtotal;
					$newData->cantidad = $detalle->cantidad;
					$newData->tipo_producto_id = $detalle->tipo_producto_id;

					array_push($records, $newData);
				}

				$total = $total + $detalle->subtotal;

			}		

		}

		$dataF["user_id"] = $user->id;
		$dataF["cliente_id"] =  $data["cliente_id"];
		$dataF["serie_id"] = $data["serie_id"];
		$dataF["estado_id"] = 1;
		$dataF["no_factura"] = $data["numero_factura"];
		$dataF["nit"] = $data["nit"];
		$dataF["direccion"] = $data["direccion"];
		$dataF["total"] = $total;
		$dataF["total_por_pagar"] = $total;
		$dataF["fecha_factura"] = Carbon::createFromFormat('d-m-Y', $data['fecha_factura']);

		$factura_cambiaria = FacturaCambiariaMaestro::create($dataF);



		foreach ($records as $record) {
			$datallito = $record["attributes"];
			$datallito["user_id"] = Auth::user()->id;
			
			if ($datallito["combustible_id"] == 1 || $datallito["combustible_id"] == 4) {
				$idp_diesel = $datallito["cantidad"] * $idp_d->costo_idp;
			}
			if ($datallito["combustible_id"] == 2 || $datallito["combustible_id"] == 5) {
				$idp_super = $datallito["cantidad"] * $idp_s->costo_idp;
			}
			if ($datallito["combustible_id"] == 3 || $datallito["combustible_id"] == 6) {
				$idp_regular = $datallito["cantidad"] * $idp_r->costo_idp;
			}

			$factura_cambiaria->factura_detalle()->create($datallito);

		}

		$factura_cambiaria->idp_regular = $idp_regular;
		$factura_cambiaria->idp_super = $idp_super;
		$factura_cambiaria->idp_diesel = $idp_diesel;
		$idp_total = $idp_diesel + $idp_super + $idp_regular;
		$factura_cambiaria->idp_total = $idp_total;
		$factura_cambiaria->save();

		foreach ($vales as $vale) 
		{

			$vale->factura_cambiaria_id = $factura_cambiaria->id;
			$vale->save();
		}

		return $factura_cambiaria;

	}

	public function unicaFactura()
	{
		$dato = Input::get("numero");
		$dato1 = Input::get("serie");
		$query = FacturaCambiariaMaestro::whereRaw('LOWER(trim(no_factura)) = ? and serie_id= ?', array(strtolower(trim($dato)), strtolower(trim($dato1))))->get();
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



	public function generar(Request $request) {

		$data = $request->all();
		$valores = $data["selected"];
		$valore= array_map('trim', explode(',', $data["selected"]));
		$vales = vale_maestro::whereIn('id', $valore)->get();
		$cliente = cliente::where('id', $data["cliente_id"])->get()->first();
		$series = series::where([
			['estado_serie_id', 1],
			['documento_id', 2]
			])->get();
		$user = Auth::user();

		$records = [];
		$total = 0;
		foreach ($vales as $vale) 
		{
			$newData = new FacturaCambiariaDetalle;

			$vale_detalles = vale_detalle::where('vale_maestro_id', $vale->id)->get();


			foreach ($vale_detalles as $detalle) {
				$newData = new FacturaCambiariaDetalle;
				$exist = false;

				if ( count($records) >  0)
				{
					foreach ($records as $record) {
						if ($detalle->tipo_producto_id == 2) 
						{
							if ($record["combustible_id"] == $detalle->combustible_id )
							{
								$record["cantidad"] = $record["cantidad"] + $detalle->cantidad;
								$record["subtotal"] = $record["subtotal"] + $detalle->subtotal;
								$exist= true;
							}
						}
						else if ($detalle->tipo_producto_id == 1) 
						{
							if ($record["producto_id"] == $detalle->producto_id )
							{
								$record["cantidad"] = $record["cantidad"] + $detalle->cantidad;
								$record["subtotal"] = $record["subtotal"] + $detalle->subtotal;
								$exist= true;
							}
						}
						if ($exist == false ) 
						{
							if ($detalle->tipo_producto_id == 2) 
							{
								$newData->combustible_id = $detalle->combustible_id;

							} 
							else if ($detalle->tipo_producto_id == 1) 
							{
								$newData->producto_id = $detalle->producto_id;

							}

							$newData->subtotal = $detalle->subtotal;
							$newData->cantidad = $detalle->cantidad;
							$newData->tipo_producto_id = $detalle->tipo_producto_id;
							array_push($records, $newData);
						}

					}
				}
				else 
				{
					if ($detalle->tipo_producto_id == 2) 
					{
						$newData->combustible_id = $detalle->combustible_id;
						$newData->producto_id = 0;

					} 
					else if ($detalle->tipo_producto_id == 1) 
					{
						$newData->producto_id = $detalle->producto_id;
						$newData->combustible_id = 0;
					}

					$newData->subtotal = $detalle->subtotal;
					$newData->cantidad = $detalle->cantidad;
					$newData->tipo_producto_id = $detalle->tipo_producto_id;
					array_push($records, $newData);
				}

				$total = $total + $detalle->subtotal;

				if ($newData) {


				}
			}		

		}

		return view("factura_cambiaria.generar", compact("records", "cliente", "user", "series", "total", "valores"));
	}



	public function generar2(Request $request) {

		$data = $request->all();

		$cliente = cliente::where('id', $data["cliente_id"])->get()->first();
		$series = series::where([
			['estado_serie_id', 1],
			['documento_id', 2]
			])->get();
		$user = Auth::user();


		$total = 0;

		$disel = precio_combustible::where("combustible_id", 4)->orderBy('id', 'desc')->get()->first();

		if ($disel) { 
			$precio_disel = $disel->precio_venta;
		}

		else {
			$precio_disel = 0;
		}


		$super = precio_combustible::where("combustible_id", 5)->orderBy('id', 'desc')->get()->first();

		if ($super) { 
			$precio_super = $super->precio_venta;
		}

		else {
			$precio_super = 0;
		}

		$regular = precio_combustible::where("combustible_id", 6)->orderBy('id', 'desc')->get()->first();

		if ($regular) { 
			$precio_regular = $regular->precio_venta;
		}

		else {
			$precio_regular = 0;
		}


		return view("factura_cambiaria.generar2", compact("cliente", "user", "series", "total", "precio_disel", "precio_super", "precio_regular"));
	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{

		$clientes = cliente::all();
		return view("factura_cambiaria.create", compact("clientes"));
	}


	public function create2()
	{

		$clientes = cliente::all();
		return view("factura_cambiaria.create2", compact("clientes"));
	}


	public function showFactura(FacturaCambiariaMaestro $factura)
	{
		$query = "SELECT SUM(fcd.cantidad) as cant,  if(fcd.producto_id > 0,pro.nombre, 
		( if(fcd.combustible_id=1 or fcd.combustible_id=4,'Diesel', ( if(fcd.combustible_id=2 or fcd.combustible_id=5,'Super', ( 
		if(fcd.combustible_id=3 or fcd.combustible_id=6,'Regular',''))))))) as producto, SUM(fcd.subtotal) as total
			FROM factura_cambiaria_detalle fcd
		LEFT JOIN productos pro ON fcd.producto_id=pro.id
		LEFT JOIN combustible comb ON fcd.combustible_id=comb.id
		WHERE fcd.factura_cambiaria_maestro_id = ".$factura->id."
		GROUP BY fcd.combustible_id, fcd.producto_id";
		$detalles = DB::select($query);

		$queryd = "SELECT SUM(cantidad) * 1.3 as Total
		FROM factura_cambiaria_detalle
		WHERE factura_cambiaria_maestro_id = ".$factura->id." and (combustible_id=1 or combustible_id=4)";
		$idp_diesel = DB::select($queryd);

		$querys = "SELECT SUM(cantidad) * 4.7 as Total
		FROM factura_cambiaria_detalle
		WHERE factura_cambiaria_maestro_id = ".$factura->id." and (combustible_id=2 or combustible_id=5)";
		$idp_super = DB::select($querys);

		$queryr = "SELECT SUM(cantidad) * 4.6 as Total
		FROM factura_cambiaria_detalle
		WHERE factura_cambiaria_maestro_id = ".$factura->id." and (combustible_id=3 or combustible_id=6)";
		$idp_regular = DB::select($queryr);

		$Totales = FacturaCambiariaDetalle::where("factura_cambiaria_maestro_id","=",$factura->id)->sum("subtotal");
		$number2 = number_format($Totales, 2, '.', '');
		$word  = \NumeroALetras::convertir($number2, 'quetzales', 'centavos');

		$pdf = PDF::loadView('factura_cambiaria.show', compact('factura', 'detalles', 'word', 'Totales', 'idp_diesel', 'idp_super', 'idp_regular'));
		$customPaper = array(0,0,400,680);
		$pdf->setPaper($customPaper, 'portrait');

		return $pdf->stream('factura_cambiaria', array("Attachment" => 0));
	}



	public function remove(FacturaCambiariaMaestro $factura, Request $request)
	{

		$user1= Auth::user()->password;

		if ($request["password_delete"] == "")
		{
			$response["password_delete"]  = "La contraseña es requerida";
			return Response::json( $response  , 422 );
		}
		else if( password_verify( $request["password_delete"] , $user1))
		{
			$id= $factura->id;
			$factura->estado_id = 2;

			$action="Factura C. Borrada, código de Factura ".$factura->id." con estado ".$factura->estado_id." a estado 2";
			$bitacora = HomeController::bitacora($action);

			$factura->save();
			$user = Auth::user();
			$number2 = number_format($factura->total, 2, '.', '');

			$word  = \NumeroALetras::convertir($number2, 'quetzales', 'centavos');
			$detalles = FacturaCambiariaDetalle::where('factura_cambiaria_maestro_id', $factura->id)->get();

			Mail::send('email.facturac', ['factura' => $factura, 'user' => $user, 'detalles' => $detalles, 'word' => $word],  function ($m) use ($factura, $user, $detalles, $word) {

				$m->from('info@vrinfosysgt.com', 'VR InfoSys');

				$m->to("ing.ivargas21314@gmail.com", "Noelia Pazos")->subject('Anulación de Factura Cambiaria');

				$response["response"] = "El registro ha sido anulado";
				return Response::json( $response );
			});

		}
		else {
			$response["password_delete"] = "La contraseña no coincide";
			return Response::json( $response  , 422 );
		}
	}


	function getVales(Request $params,  $cliente) {

		$api_Result = array();
		$today = date("Y/m/d");
		// Create a mapping of our query fields in the order that will be shown in datatable.
		$columnsMapping = array("v.id", "v.total_vale", "c.cliente", "e.estado_vale", "v.created_at");

		// Initialize query (get all)


		$api_logsQueriable = DB::table('vale_maestro');
		$api_Result['recordsTotal'] = $api_logsQueriable->count();

		$query = "SELECT v.id AS id, fecha_corte as fecha_corte, v.no_vale as no_vale, TRUNCATE(v.total_vale, 2) AS total_vale,  CONCAT(c.cl_nombres,' ',c.cl_apellidos) as cliente, v.created_at as created_at
		FROM vale_maestro v
		INNER JOIN clientes c ON v.cliente_id=c.id ";

		$where = "  ";

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
		$condition = " WHERE  v.cliente_id='".$cliente."' and v.factura_cambiaria_id = 0  and (v.estado_vale_id=1 or v.estado_vale_id=4) ";

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
		$today = date("Y/m/d");
		// Create a mapping of our query fields in the order that will be shown in datatable.
		$columnsMapping = array("f.no_factura", "f.total", "f.estado_id", "c.cliente", "f.fecha_factura");

		// Initialize query (get all)


		$api_logsQueriable = DB::table('factura_cambiaria_maestro');
		$api_Result['recordsTotal'] = $api_logsQueriable->count();

		$query = "SELECT f.no_factura AS no_factura,  TRUNCATE(f.total,4) AS total, f.estado_id AS estado_id,  CONCAT(c.cl_nombres,' ',c.cl_apellidos) as cliente, f.fecha_factura as fecha_factura, f.id as id
		FROM factura_cambiaria_maestro f
		INNER JOIN clientes c ON f.cliente_id=c.id ";

		$where = " ";

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
		$condition = "  ";

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
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
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

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		//
	}
}
