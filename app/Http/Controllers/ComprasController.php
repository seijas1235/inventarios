<?php

namespace App\Http\Controllers;

use App\Compra;
use App\MaquinariaEquipo;
use App\IngresoProducto;
use App\User;
use App\Proveedor;
use App\EstadoIngreso;
use App\Producto;
use App\DetalleCompra;
use App\MovimientoProducto;
use App\TipoPago;
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
use App\CuentaPorPagar;
use App\DetalleCuentaPorPagar; 

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
		$maquinarias = MaquinariaEquipo::all();
		$tipos_pago = TipoPago::all();
		return view("compras.create" , compact("back","proveedores", "productos", "maquinarias","tipos_pago") );
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
		$data["user_id"] = Auth::user()->id;
		//$data['fecha_factura'] = Carbon::createFromFormat('d/m/Y', $data['fecha_factura']);
		$data["edo_ingreso_id"] = 1;
		$data["tipo_pago_id"] = $request["tipo_pago_id"];
		$maestro = Compra::create($data);

		if($request["tipo_pago_id"] == 3){

			$existeCuentaProveedor = CuentaPorPagar::where('proveedor_id',$request["proveedor_id"])->first();

			if($existeCuentaProveedor){

				$detalle = array(
					'compra_id' => $maestro->id,
					'num_factura' => $request["num_factura"],
					'fecha' => $data["fecha_factura"],
					'descripcion' => 'Compra',
					'cargos' => $request["total_factura"],	
					'abonos' => 0,
					'saldo' => $existeCuentaProveedor->total + $request["total_factura"]
				);					

				$existeCuentaProveedor->detalles_cuentas_por_pagar()->create($detalle);

				//$total = $existeCuentaProveedor->total;
				//$newtotal = $total + $request["total_factura"];
				$newtotal = $detalle['saldo'];
				$existeCuentaProveedor->update(['total' => $newtotal]);
			}

			else{
				$cuenta = new CuentaPorPagar;
				$cuenta->total = $request["total_factura"];
				$cuenta->proveedor_id = $request["proveedor_id"];
				$cuenta->save();

				$detalle = array(
					'compra_id' => $maestro->id,
					'num_factura' => $request["num_factura"],
					'fecha' => $data["fecha_factura"],
					'descripcion' => 'Compra',
					'cargos' => $request["total_factura"],	
					'abonos' => 0,
					'saldo' => $request["total_factura"]
				);							

				$cuenta->detalles_cuentas_por_pagar()->create($detalle);
			}
			
		}

		return $maestro;
	}

	public function saveDetalle(Request $request, Compra $compra)
	{
		$statsArray = $request->all();
		foreach($statsArray as $stat) {

			if(empty($stat['producto_id'])){
				$stat['user_id'] = Auth::user()->id;
				$stat['maquinaria_equipo_id'] = $stat['maquinaria_equipo_id'];
				$stat["precio_venta"] = 0;
				$stat["subtotal"] = $stat["subtotal_venta"];
				$stat['existencias'] = $stat["cantidad"];
				$stat["precio_compra"] = $stat["precio_compra"];
				$stat['fecha_ingreso'] = Carbon::now();
			
				$detalle = MovimientoProducto::create($stat);
				$stat["movimiento_producto_id"] = $detalle->id;
				$compra->detalles_compras()->create($stat);
			}

			else{
				$stat['user_id'] = Auth::user()->id;
				$stat['producto_id'] = $stat['producto_id'];
				$stat["precio_venta"] = $stat["precio_venta"];
				$stat["subtotal"] = $stat["subtotal_venta"];
				$stat['existencias'] = $stat["cantidad"];
				$stat["precio_compra"] = $stat["precio_compra"];
				$stat['fecha_ingreso'] = Carbon::now();
			
				$detalle = MovimientoProducto::create($stat);
				$stat["movimiento_producto_id"] = $detalle->id;
				$compra->detalles_compras()->create($stat);
			}		
			
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
		$date =Carbon::createFromFormat('Y-m-d H:i:s', $compra->fecha_factura)->format('d-m-Y');
		$compra->fecha_factura = $date;
		return Response::json($compra);
	}

	public function getDetalle( DetalleCompra $detallecompra)
	{
		$ingresoproducto = DetalleCompra::where( "detalles_compras.id" , "=" , $detallecompra->id )
		->select( "existencias", "precio_compra", "precio_venta")
		->get()
		->first();
		return Response::json( $ingresoproducto);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Compra $compra)
	{
		$query = "SELECT * FROM compras WHERE id=".$compra->id."";
		$fieldsArray = DB::select($query);
		
		$proveedores = Proveedor::all();
        return view ("compras.edit", compact('compra', 'fieldsArray','proveedores'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */


	public function update(Compra $compra, Request $request )
	{
		Response::json($this->updateIngresoProducto($compra , $request->all()));
        return redirect('/compras');

		//return Response::json( $this->updateIngresoProducto($compra, $request->all())); 
	}



	public function updateIngresoProducto(Compra $compra, array $data )
	{

		//$data['fecha_factura'] = Carbon::createFromFormat('d-m-Y', $data['fecha_factura']);
		$compra->serie_factura = $data["serie_factura"];
		$compra->num_factura = $data["num_factura"];
		$compra->fecha_factura = $data["fecha_factura"];
		$compra->proveedor_id = $data["proveedor_id"];
		//$compra->tipo_pago_id = $data["tipo_pago_id"];
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
			foreach($detalles as $detalle) 
			{
				$producto = MovimientoProducto::where('id', $detalle["movimiento_producto_id"])
				->get()->first();
				$newExistencias = 0;
				$updateExistencia = MovimientoProducto::where('id', $detalle["movimiento_producto_id"])
				->update(['existencias' => $newExistencias]);
			}

			if($compra->tipo_pago_id == 3 )
			{
				$cuentaporpagar = CuentaPorPagar::where('proveedor_id', $compra->proveedor_id)->first();

				$total = $cuentaporpagar->total;
				$NuevoTotal = $total - $compra->total_factura;

				$detallecuenta = array(
					'num_factura' => $compra->num_factura,
					'fecha' => carbon::now(),
					'descripcion' => 'Se elimino compra',
					'cargos' => 0,	
					'abonos' => $compra->total_factura,
					'saldo' => $NuevoTotal
				);
				
				$cuentaporpagar->detalles_cuentas_por_pagar()->create($detallecuenta);


				$cuentaporpagar->update(['total' => $NuevoTotal]);
				$compra->delete();

			}
			else
			{
				$compra->delete();
			}			

			
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
			$totalresta = ($detallecompra->precio_compra * $detallecompra->existencias);
			$newTotal = $total - $totalresta;
			$updateTotal = Compra::where('id', $detallecompra->compra_id)
			->update(['total_factura' => $newTotal]);

			//Actualiza cuenta por pagar

			if($ingresomaestro->tipo_pago_id == 3)
			{
				$cuentaporpagar = CuentaPorPagar::where('proveedor_id', $ingresomaestro->proveedor_id)->first();

				$totalactual = $cuentaporpagar->total;

				$NuevoTotal = $totalactual - $totalresta;

				$detallecuenta = array(
					'num_factura' => $ingresomaestro->num_factura,
					'fecha' => carbon::now(),
					'descripcion' => 'Se elimino detalle de compra',
					'cargos' => 0,	
					'abonos' => $totalresta,
					'saldo' => $NuevoTotal
				);
				
				$cuentaporpagar->detalles_cuentas_por_pagar()->create($detallecuenta);


				$cuentaporpagar->update(['total' => $NuevoTotal]);
				$detallecompra->delete();

			}

			else
			{
				$detallecompra->delete();
			}
			
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
		$columnsMapping = array("compras.id","compras.serie_factura", "compras.num_factura", "fecha_factura","proveedores.nombre", "compras.total_factura");

		// Initialize query (get all)

		$api_logsQueriable = DB::table("compras");
		$api_Result["recordsTotal"] = $api_logsQueriable->count();

		$query = 'SELECT compras.id, compras.serie_factura, compras.num_factura, DATE_FORMAT(compras.fecha_factura, "%d-%m-%Y") as fecha_factura, proveedores.nombre, TRUNCATE(compras.total_factura,2) as total 
		FROM compras INNER JOIN proveedores ON proveedores.id=compras.proveedor_id ';

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
		$columnsMapping = array("dc.id","dc.compra_id", "p.codigo_barra", "p.nombre", "dc.existencias", "dc.precio_compra", "dc.precio_venta");

		// Initialize query (get all)


		$api_logsQueriable = DB::table('detalles_compras');
		$api_Result['recordsTotal'] = $api_logsQueriable->count();

		//$query = 'SELECT detalles_compras.id, detalles_compras.compra_id, productos.codigo_barra, productos.nombre, detalles_compras.existencias, detalles_compras.precio_compra, detalles_compras.precio_venta FROM detalles_compras INNER JOIN productos ON detalles_compras.producto_id=productos.id WHERE detalles_compras.compra_id ='.$detalle.' ';
		$query = 'SELECT dc.id, dc.compra_id, p.codigo_barra, p.nombre, m.codigo_maquina, m.nombre_maquina, dc.existencias, dc.precio_compra, dc.precio_venta
		FROM detalles_compras dc
		left join productos p on p.id = dc.producto_id
		left join maquinarias_y_equipos m on m.id = dc.maquinaria_equipo_id where dc.compra_id ='.$detalle.'';

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
