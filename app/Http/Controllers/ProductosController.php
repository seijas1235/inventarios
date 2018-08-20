<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\producto;
use App\tipo_producto;
use App\estado_producto;
use Illuminate\Support\Facades\Input;
use App\marca;
use App\User;

class ProductosController extends Controller
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
		return view("productos.index");
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$user = Auth::user()->id;
		$tipo_producto = tipo_producto::all();
		$estado_producto = estado_producto::all();
		$marca = marca::all();
		$today = date("Y/m/d");
		return view("productos.create" , compact( "user","today","tipo_producto", "estado_producto","marca"));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$user = Auth::user()->id;
		$today = date("Y/m/d");
		$data = $request->all();
		$data["estado_producto_id"] =1;
		$data["user_id"] = Auth::user()->id;
		$producto = Producto::create($data);

		$prod = Producto::where("id", $producto["id"])->get()->first();

		$action="Producto ha sido Creado, con código ".$producto->id;
		$bitacora = HomeController::bitacora($action);

		return Response::json($producto);


	   /* $action='Crea producto';
	   $bitacora = HomeController::bitacora($action);*/
	}

	public function getPrecio(producto $producto) {

		return Response::json($producto);
	}


	public function store_precios(Producto $producto, Request $request)
	{
		$precios_clientes = $request->all();
		foreach($precios_clientes as $field) 
		{
			$field['user_create_id'] = Auth::user()->id;
			$producto->productotipocliente()->create($field);
		}
		return Response::json(['result' => 'ok']);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Producto $producto)
	{
		$tipo_producto = tipo_producto::all();
		$estado_producto = estado_producto::all();
		$marca = marca::all();
		$query = "SELECT * FROM productos WHERE id=".$producto->id."";

		$fieldsArray = DB::select($query);

		return view('productos.edit', compact('producto', 'fieldsArray', 'tipo_producto','estado_producto','marca','modelo'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Producto $producto, Request $request )
	{
		Response::json( $this->updateProducto($producto , $request->all()));
		return redirect('/productos');
	}

	public function updateProducto( Producto $producto, array $data )
	{
		$action="Prducto Editado, codigo ".$producto->id."; datos anteriores: ".$producto->codigobarra.",".$producto->nombre.",".$producto->marca_id.",".$producto->descripcion.",".$producto->aplicacion.",".$producto->no_serie.",".$producto->tipo_producto_id.",".$producto->precio_venta.",".$producto->precio_compra."; datos nuevos: ".$data["codigobarra"].",".$data["nombre"].",".$data["marca_id"].",".$data["descripcion"].",".$data["aplicacion"].",".$data["no_serie"].",".$data["tipo_producto_id"].",".$data["precio_venta"].",".$data["tipo_producto_id"].",".$data["precio_venta"].",".$data["precio_compra"]."";
		$bitacora = HomeController::bitacora($action);

		$id= $producto->id;
		$producto->codigobarra = $data["codigobarra"];
		$producto->nombre = $data["nombre"];
		$producto->marca_id = $data["marca_id"];
		$producto->descripcion = $data["descripcion"];
		$producto->aplicacion = $data["aplicacion"];
		$producto->no_serie = $data["no_serie"];
		$producto->tipo_producto_id = $data["tipo_producto_id"];
		$producto->precio_venta = $data["precio_venta"];
		$producto->precio_compra = $data["precio_compra"];
		$producto->estado_producto_id = $data["estado_producto_id"];
		$producto->save();

		return $producto;
	}

	/*public function updatePrecios(Producto $producto, Producto_Tipo_cliente $producto_tipo_cliente, array $data)
	{

	}*/

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function Producto_Disponible()
	{
		$dato = Input::get("codigobarra");
		$query = Producto::whereRaw('LOWER(trim(codigobarra)) = ? ', array(strtolower(trim($dato))))->get();
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

	public function Producto_Disponible_Edit()
	{
		$dato = Input::get("codigobarra");
		$id = Input::get("id");
		$query = Producto::whereRaw('LOWER(trim(codigobarra)) = ? and id != ?', array(strtolower(trim($dato)), $id))->get();
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

	public function destroy(Producto $producto, Request $request)
	{
		
		$user1= Auth::user()->password;

		if ($request["password_delete"] == "")
		{
			$response["password_delete"]  = "La contraseña es requerida";
			return Response::json( $response  , 422 );
		}
		else if( password_verify( $request["password_delete"] , $user1))
		{
			$id= $producto->id;
			$producto->estado_producto_id = 2;

			$action="Producto Borrado, código de Producto ".$producto->id." con estado ".$producto->estado_producto_id." a estado 2";
			$bitacora = HomeController::bitacora($action);

			$producto->save();

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
		$columnsMapping = array("pr.id", "pr.codigobarra","pr.nombre","mc.marca", "pr.estado_producto_id", "pr.aplicacion");

		//  Initialize query (get all)

		$api_logsQueriable = DB::table('productos');
		$api_Result['recordsTotal'] = $api_logsQueriable->count();

		$query = 'SELECT pr.id, pr.codigobarra, pr.nombre, mc.marca, pr.estado_producto_id, pr.precio_venta, pr.aplicacion, ep.estado_producto
		FROM productos pr
		INNER JOIN marcas mc ON pr.marca_id=mc.id INNER JOIN estados_producto ep ON ep.id=pr.estado_producto_id ';

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


	public function getDetalle(producto $producto)
	{
		return view("productos.detalle", compact("producto"));
	}


	public function getJsonDetalle(Request $params, $detalle)
	{
		$api_Result = array();
		// Create a mapping of our query fields in the order that will be shown in datatable.
		$columnsMapping = array("pr.codigobarra", "pr.nombre", "pe.nombre_comercial", "pp.preciopromedio");
		// Initialize query (get all)

		$api_logsQueriable = DB::table('productos_proveedores');
		$api_Result['recordsTotal'] = $api_logsQueriable->count();

		$query = "SELECT pr.codigobarra AS codigobarra, pr.nombre AS producto, pe.nombre_comercial AS nombre_comercial, pp.preciopromedio AS preciopromedio
		FROM productos_proveedores pp
		INNER JOIN productos pr ON pp.producto_id=pr.id
		INNER JOIN proveedores pe ON pp.proveedor_id=pe.id ";

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
}