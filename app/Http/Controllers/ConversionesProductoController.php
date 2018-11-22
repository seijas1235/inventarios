<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\ConversionProducto;
use App\DetalleConversion;
use App\User;
use App\Producto;
use App\MovimientoProducto;
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
use App\Events\ActualizacionProducto;

class ConversionesProductoController extends Controller
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
        $productos = Producto::all();
        return view ("conversiones_productos.index", compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$productos = Producto::all();
		return view("conversiones_productos.create" , compact("back","productos") );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
	{
		try{
			DB::beginTransaction();

            $statsArray = $request->all();

            $conversion_producto = new ConversionProducto;
			$conversion_producto->fecha = Carbon::now();
            $conversion_producto->user_id = Auth::user()->id;
            $conversion_producto->save();

			foreach($statsArray as $stat) {

            $detalle = new DetalleConversion;
            $detalle->producto_id_ingresa = $stat["producto_id"];
            $detalle->producto_id_sale = $stat["producto_id_sale"];
            $detalle->conversion_producto_id = $conversion_producto->id;
			
        //se crea el movimiento de producto   
            $mp = new MovimientoProducto;
            $mp->fecha_ingreso = $conversion_producto->fecha;
            $mp->producto_id = $stat["producto_id"];
            $mp->existencias = $stat["cantidad_ingreso"];
            $mp->precio_compra = $stat["precio_compra"];
			$mp->precio_venta = $stat["precio_venta"];
			
			//kardex
			$existencia_anterior = MovimientoProducto::where( "producto_id" , "=" , $stat["producto_id"] )->sum( "existencias");

			if($existencia_anterior == null){
				$existencia_anterior = 0;
			};

			event(new ActualizacionProducto($stat["producto_id"], 'Conversion Ingreso', $stat["cantidad_ingreso"],0, $existencia_anterior, $existencia_anterior + $stat["cantidad_ingreso"]));

            $mp->save();

            $detalle->movimiento_producto_id = $mp->id;
			$detalle->save();	

        //Se actualiza la salida de producto
            $mps = MovimientoProducto::where('producto_id', $detalle->producto_id_sale)->first();
            $existenciaanterior = $mps->existencias;
            $detalleMps = array(
                'existencias' => $existenciaanterior - $stat["cantidad_sale"],
			);
			
			//kardex
			$existencia_anterior = MovimientoProducto::where( "producto_id" , "=" , $detalle->producto_id_sale )->sum("existencias");

			if($existencia_anterior == null){
				$existencia_anterior = 0;
			};

			event(new ActualizacionProducto($detalle->producto_id_sale, 'Conversion Salida', 0,$stat["cantidad_sale"], $existencia_anterior, $existencia_anterior - $stat["cantidad_sale"]));

            $mps->update($detalleMps);
            				
		}

		DB::commit();
		return Response::json(['result' => 'ok']);
		
		}

		catch(Exception $e)
		{
            DB::rollBack();
		}
			
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit(ConversionProducto $ingreso_producto)
	{
		$query = "SELECT * FROM conversiones_productos WHERE id=".$ingreso_producto->id."";
		$fieldsArray = DB::select($query);
		
        return view ("conversiones_productos.edit", compact('ingreso_producto', 'fieldsArray'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */


	public function update(ConversionProducto $ingreso_producto, Request $request )
	{
		/*Response::json($this->updateConversionProducto($ingreso_producto , $request->all()));
        return redirect('/conversiones_productos');*/
	}

	public function show(ConversionProducto $conversion_producto)
    {
        return view('conversiones_productos.show')->with('conversion_producto', $conversion_producto);
    }

	public function updateConversionProducto(ConversionProducto $ingreso_producto, array $data )
	{

		/*$ingreso_producto->precio_compra = $data["precio_compra"];
		$ingreso_producto->precio_venta = $data["precio_venta"];
		$ingreso_producto->cantidad = $data["cantidad"];
		$ingreso_producto->save();

			$updateExistencia = MovimientoProducto::where('id', $ingreso_producto->movimiento_producto_id)
			->update(
				['existencias' => $data["cantidad"],
				 'precio_compra' => $data["precio_compra"],
				 'precio_venta' => $data["precio_venta"]
				]);

		return $ingreso_producto;*/
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy( ConversionProducto $ingreso_producto,  Request $request)
	{
		$user1= Auth::user()->password;

		if ($request["password_delete"] == "")
		{
			$response["password_delete"]  = "La contraseña es requerida";
			return Response::json( $response  , 422 );
		}
		else if( password_verify( $request["password_delete"] , $user1))
		{

			//$producto = MovimientoProducto::where('id', $ingreso_producto->movimiento_producto_id)->get()->first();
			$newExistencias = 0;
			$updateExistencia = MovimientoProducto::where('id', $ingreso_producto->movimiento_producto_id)
			->update(['existencias' => $newExistencias]);

			$ingreso_producto->delete();
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
		$columnsMapping = array("c.id", "c.fecha", "u.name");

		// Initialize query (get all)

		$api_logsQueriable = DB::table("conversiones_productos");
		$api_Result["recordsTotal"] = $api_logsQueriable->count();

		$query = 'SELECT c.id, DATE_FORMAT(c.fecha, "%d-%m-%Y") as fecha, u.name
		FROM conversiones_productos c 
		INNER JOIN users u on u.id = c.user_id ';

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
		$columnsMapping = array("dc.id", "p1.nombre", "p2.nombre");

		// Initialize query (get all)


		$api_logsQueriable = DB::table('detalles_conversiones');
		$api_Result['recordsTotal'] = $api_logsQueriable->count();

		$query = 'SELECT dc.id, p1.nombre as producto_ingresa, p2.nombre as producto_sale  FROM detalles_conversiones dc
		INNER JOIN productos p1 on p1.id = dc.producto_id_ingresa
		INNER JOIN productos p2 on p2.id = dc.producto_id_sale
		WHERE dc.conversion_producto_id ='.$detalle.'';

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
