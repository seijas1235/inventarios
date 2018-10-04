<?php

namespace App\Http\Controllers;

use App\Compra;
use App\User;
use App\Proveedor;
use App\Producto;
use App\DetalleCompra;
use View;
Use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Kodeine\Acl\Models\Eloquent\Role;
use Kodeine\Acl\Models\Eloquent\Permission;
use Carbon\Carbon;

class ComprasController extends Controller
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
	
	public function prueba(){
		return view('prueba');
	}


    public function index()
    {
        $proveedores = Proveedor::all();
        $productos = Producto::all();
        return view ("compras.index", compact('proveedores', 'productos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$proveedores = Proveedor::all();
		$productos = Producto::all();
		return view("compras.create" , compact("proveedores", "productos") );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {/*
        try{
            DB:beginTransaction();

            //Aqui Compra
            $compra = new Compra();
            $compra->fecha = $request->fecha;

            //Aqui detalle

            $detalles = $request->data;

            foreach($detalles as $ep=>$det)
            {
                $detalle = new DetalleCompra();

                $detalle->producto_id = $det['producto_id'];
                $detalle->compra_id = $compra->id;
                $detalle->cantidad = $det['cantidad'];
                $detalle->precio_costo = $det['precio_costo'];
                $detalle->subtotal = $det['subtotal'];
                $detalle->maquinaria_equipo_id = $det['maquinaria_equipo_id'];
                $detalle->save();
            }

            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
        }       

        $data = $request->all();
        $compra = compra::create($data);

        return Response::json($compra);*/
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
	{
		$data = $request->all();
		$data['fecha'] = Carbon::createFromFormat('d-m-Y', $data['fecha']);
		$compra = Compra::create($data);
		return $compra;
	}


	public function saveDetalle(Request $request, Compra $compra)
	{
		$statsArray = $request->all();
		foreach($statsArray as $stat) {
			$stat["subtotal"] = $stat["subtotal"];
			$stat['producto_id'] = $stat['producto_id'];
			$stat["precio_costo"] = $stat["precio_costo"];
			$stat['fecha'] = Carbon::now();
			$compra->detalles_compras()->create($stat);
			
		}
		return Response::json(['result' => 'ok']);

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */


	public function show(Compra $compra)
	{
		return view('compras.show')->with('compra', $compra);
	}


	public function getName(Compra $compra )
	{
		$date =Carbon::createFromFormat('Y-m-d H:i:s', $compra->fecha)->format('d-m-Y');
		$compra->fecha = $date;
		return Response::json($compra);
	}

	public function getDetalle( DetalleCompra $detallecompra)
	{
		$compras = DetalleCompra::where( "detalles_compras.id" , "=" , $detallecompra->id )
		->select("precio_costo")
		->get()
		->first();
		return Response::json( $compras);
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


	public function update( Compra $compra, Request $request )
	{

		return Response::json( $this->updateIngresoProducto($compra, $request->all())); 
	}



	public function updateIngresoProducto(Compra $compra, array $data )
	{

		$data['fecha'] = Carbon::createFromFormat('d-m-Y', $data['fecha']);
		$compra->fecha = $data["fecha"];
		$compra->proveedor_id = $data["proveedor_id"];
		$compra->save();
		return $compra;
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy( Compra $compra,  Request $request)
	{
		$user1= Auth::user()->password;

		if ($request["password_delete"] == "")
		{
			$response["password_delete"]  = "La contraseña es requerida";
			return Response::json( $response  , 422 );
		}
		else if( password_verify( $request["password_delete"] , $user1))
		{
			$detalles = DetalleCompra::where('compra_id', $compra->id)
			->get();
			/*foreach($detalles as $detalle) 
			{
				$producto = MovimientoProducto::where('id', $detalle["movimiento_producto_id"])
				->get()->first();
				$newExistencias = 0;
				$updateExistencia = MovimientoProducto::where('id', $detalle["movimiento_producto_id"])
				->update(['existencias' => $newExistencias]);
			}*/
			$compra->delete();
			$response["response"] = "El registro ha sido borrado";
			return Response::json( $response );
		}
		else {
			$response["password_delete"] = "La contraseña no coincide";
			return Response::json( $response  , 422 );
		}
	}

	public function destroyDetalle(DetalleCompra $detallecompra,  Request $request)
	{
		$user1= Auth::user()->password;

		if ($request["password_delete"] == "")
		{
			$response["password_delete"]  = "La contraseña es requerida";
			return Response::json( $response  , 422 );
		}
		else if( password_verify( $request["password_delete"] , $user1))
		{
			$producto = MovimientoProducto::where('id', $detallecompra->movimiento_producto_id)
			->get()->first();
			$existencias = $producto->existencias;
			$cantidad = $detallecompra->existencias;
			$newExistencias = $existencias - $cantidad;
			$updateExistencia = MovimientoProducto::where('id', $detallecompra->movimiento_producto_id)
			->update(['existencias' => $newExistencias]);


			$ingresomaestro = Compra::where('id', $detallecompra->compra_id)
			->get()->first();
			$total = $ingresomaestro->total_factura;
			$totalresta = ($detallecompra->precio_costo * $detallecompra->existencias);
			$newTotal = $total - $totalresta;
			$updateTotal = Compra::where('id', $detallecompra->compra_id)
			->update(['total_factura' => $newTotal]);


			$detallecompra->delete();
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
		$columnsMapping = array("id","fecha","total");

		// Initialize query (get all)

		$api_logsQueriable = DB::table("compras");
		$api_Result["recordsTotal"] = $api_logsQueriable->count();

		$query = 'SELECT compras.id, DATE_FORMAT(compras.fecha, "%d-%m-%Y") as fecha, proveedores.nombre, TRUNCATE(compras.total,2) as total FROM compras INNER JOIN proveedores ON proveedores.id=compras.proveedor_id ';

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
		$columnsMapping = array("detalles_compras.compra_id", "productos.codigo_barra", "productos.nombre", "detalles_compras.precio_costo");

		// Initialize query (get all)


		$api_logsQueriable = DB::table('detalles_compras');
		$api_Result['recordsTotal'] = $api_logsQueriable->count();

		$query = 'SELECT detalles_compras.id, detalles_compras.compra_id, productos.codigo_barra, productos.nombre, detalles_compras.precio_costo FROM detalles_compras INNER JOIN productos ON detalles_compras.producto_id=productos.id WHERE detalles_compras.compra_id ='.$detalle.' ';

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