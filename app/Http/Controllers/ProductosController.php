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
use App\Producto;
use App\User;
use App\UnidadDeMedida;
use App\Marca;
//use Yajra\Datatables\Datatables;

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

	public function existenciasIndex()
	{
		return view('productos.existencias');
	}



	public function existencias(Request $params)
	{
		$api_Result = array();
		// Create a mapping of our query fields in the order that will be shown in datatable.
		$columnsMapping = array("p.id", "p.nombre", "mp.existencias", "p.minimo", "mp.fecha_ingreso");

		// Initialize query (get all)

		$api_logsQueriable = DB::table('productos');
		$api_Result['recordsTotal'] = $api_logsQueriable->count();

		$query = "SELECT p.id, p.nombre, IF(SUM(mp.existencias) IS NULL,0,SUM(mp.existencias)) AS existencias,
		p.minimo, IF(MAX(mp.fecha_ingreso) IS NULL,0,MAX(mp.fecha_ingreso)) as ultimo_ingreso FROM productos p
		LEFT JOIN movimientos_productos mp on p.id = mp.producto_id GROUP BY p.nombre, p.id ";
        
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

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$user = Auth::user()->id;
		$medidas = UnidadDeMedida::All();
		$marcas = Marca::All();
		return view("productos.create" , compact( "user",'medidas','marcas'));
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
		$data["user_id"] = Auth::user()->id;
		$producto = Producto::create($data);

		return Response::json($producto);
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
	public function edit(Producto $producto)
	{
		$query = "SELECT * FROM productos WHERE id=".$producto->id."";
		$fieldsArray = DB::select($query);
		$medidas = UnidadDeMedida::All();
		$marcas = Marca::All();

		return view('productos.edit', compact('producto', 'fieldsArray','medidas','marcas'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Producto $producto, Request $request)
	{
		Response::json( $this->updateProducto($producto , $request->all()));
		return redirect('/productos');
	}


	public function updateProducto(Producto $producto, array $data )
	{
		
		$id= $producto->id;
		$producto->codigo_barra = $data["codigo_barra"];
        $producto->nombre = $data["nombre"];
		$producto->minimo = $data["minimo"];
		$producto->marca_id = $data["marca_id"];
		$producto->medida_id = $data["medida_id"];
		$producto->descripcion = $data["descripcion"];
		$producto->save();

		return $producto;
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
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
			$producto->delete();
			
			$response["response"] = "El producto ha sido eliminado";
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
		$columnsMapping = array("P.codigo_barra", 'P.nombre', 'MR.nombre','U.descripcion', 'P.minimo');

		// Initialize query (get all)

		$api_logsQueriable = DB::table('productos');
		$api_Result['recordsTotal'] = $api_logsQueriable->count();

		$query = "SELECT P.nombre, P.codigo_barra, P.minimo, P.id, P.descripcion, MR.nombre as mrnombre , U.descripcion as udesc
        FROM productos P 
        INNER JOIN marcas MR ON MR.id = P.marca_id 
        INNER JOIN unidades_de_medida u on U.id = P.medida_id";
        
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

	public function getInfo(Request $request)
	{
		$producto = $request["data"];

		if ($producto == "")
		{
			$result = "";
			return Response::json( $result);
		}
		else {
			$query = "Select MP.id as producto_id, if(MP.fecha_ingreso is null,0,MP.fecha_ingreso) as fecha, PR.id as prod_id,
			PR.nombre, if(MP.existencias is null,0,MP.existencias) as existencias, UM.descripcion as medida, UM.cantidad,
			if(MP.precio_compra is null,0,MP.precio_compra) as precio_compra, PR.codigo_barra,
				if(MP.precio_venta is null,0,MP.precio_venta) as precio_venta
					from productos PR
				left join movimientos_productos MP on PR.id=MP.producto_id and (MP.existencias>0)
				Inner join unidades_de_medida UM on UM.id = PR.medida_id
				having PR.codigo_barra = '".$producto."'
				order by MP.fecha_ingreso DESC limit 1";
				$result = DB::select($query);
				return Response::json( $result);
			}

	}

	public function getPrecio(Producto $producto) {

		return Response::json($producto);
	}


	public function getJsonExistencia(Request $params)
	{
		$api_Result = array();
		$columnsMapping = array( "productos.id", "codigo_barra", "nombre", "movimientos_productos.precio_compra", "existencias");


		$api_logsQueriable = DB::table('productos');
		$api_Result['recordsTotal'] = $api_logsQueriable->count();

		$query = 'SELECT productos.id AS Codigo, productos.codigo_barra, productos.nombre, IF(movimientos_productos.precio_compra IS NULL,0,ROUND(movimientos_productos.precio_compra,4)) AS precio_compra, IF(SUM(movimientos_productos.existencias) IS NULL,0,SUM(movimientos_productos.existencias)) AS existencias, IF(SUM(movimientos_productos.existencias) IS NULL,0,ROUND(SUM(movimientos_productos.existencias) * movimientos_productos.precio_compra,4)) AS total_neto FROM productos  LEFT JOIN movimientos_productos ON productos.id=movimientos_productos.producto_id ';

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
		//foreach ($params->order as $order) {
		//	if (strlen($sort) == 0) {
		//		$sort .= ' order by ' . $columnsMapping[$order['column']] . ' '. $order['dir']. ' ';
		//	} else {
		//		$sort .= ' , '. $columnsMapping[$order['column']] . ' '. $order['dir']. ' ';
		//	}
		//}

		$filter = " limit ".$params->length." offset ".$params->start."";
		$group = " GROUP BY productos.id, productos.codigo_barra, movimientos_productos.precio_compra ";
		
					$data =  $query . $sort . $group;
					$result = DB::select($data);

		$api_Result['recordsFiltered'] = count($result);

					$query .= $sort . $group . $filter;

		$result = DB::select($query);

		$api_Result['data'] = $result;

		return Response::json( $api_Result );
	}


	public function getJsonExistenciaProd(Request $params)
	{
		$api_Result = array();
	// Create a mapping of our query fields in the order that will be shown in datatable.
		$columnsMapping = array("productos.codigo_barra", "productos.nombre");

	// Initialize query (get all)

		$api_logsQueriable = DB::table("productos");
		$api_Result["recordsTotal"] = $api_logsQueriable->count();

		$query = 'SELECT productos.id, productos.codigo_barra, productos.nombre, if(Sum(movimientos_productos.existencias) is null,0,Sum(movimientos_productos.existencias)) as existencias FROM productos LEFT JOIN movimientos_productos on productos.id=movimientos_productos.producto_id  ';

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
		//foreach ($params->order as $order) {
		//	if (strlen($sort) == 0) {
		//		$sort .= ' order by ' . $columnsMapping[$order['column']] . ' '. $order['dir']. ' ';
		//	} else {
		//		$sort .= ' , '. $columnsMapping[$order['column']] . ' '. $order['dir']. ' ';
		//	}
		//}

		$filter = " limit ".$params->length." offset ".$params->start."";
		$group = " GROUP BY productos.id, productos.codigo_barra, productos.nombre ";

		
					$data =  $query . $sort . $group;
					$result = DB::select($data);

		$api_Result['recordsFiltered'] = count($result);

					$query .= $sort . $group . $filter;

		$result = DB::select($query);

		$api_Result['data'] = $result;

		return Response::json( $api_Result );
	}



}
