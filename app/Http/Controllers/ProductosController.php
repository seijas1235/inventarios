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
		$producto->nombre = $data["codigo_barra"];
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
		$columnsMapping = array("id", "codigo_barra");

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
			$query = "Select nombre, codigo_barra from productos where productos.codigo_barra = '".$producto."' ";
				$result = DB::select($query);
				return Response::json( $result);
			}

		}
}
