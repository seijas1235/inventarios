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
Use App\User;
Use App\PrecioProducto;
Use App\Producto;
class CuentasPorPagarController extends Controller
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
        return view ("cuentas_por_pagar.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $user = Auth::user()->id;
       $productos = Producto::all();
       $fecha= Carbon::now();
       return view("precios_producto.create" , compact( "user", "productos", "fecha"));
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
        $precio_producto = PrecioProducto::create($data);

        return Response::json($precio_producto);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('compras.show')->with('compra', $compra);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(PrecioProducto $precio_producto)
    {
        $query = "SELECT * FROM precios_producto WHERE id=".$precio_producto->id."";
        $fieldsArray = DB::select($query);

        $productos = Producto::all();
        return view('precios_producto.edit', compact('precio_producto', 'fieldsArray', 'productos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PrecioProducto $precio_producto, Request $request)
    {
        Response::json( $this->updatePrecioProducto($precio_producto , $request->all()));
        return redirect('/precios_producto');
    }

    public function updatePrecioProducto(PrecioProducto $precio_producto, array $data )
    {
        $id= $precio_producto->id;
        $precio_producto->precio_venta = $data["precio_venta"];
        $precio_producto->producto_id = $data["producto_id"];
        $precio_producto->save();

        return $precio_producto;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(PrecioProducto $precio_producto, Request $request)
    {
        $user1= Auth::user()->password;

        if ($request["password_delete"] == "")
        {
            $response["password_delete"]  = "La contraseña es requerida";
            return Response::json( $response  , 422 );
        }
        else if( password_verify( $request["password_delete"] , $user1))
        {
            $id= $precio_producto->id;
            $precio_producto->delete();
            
            $response["response"] = "El tipo precio_producto ha sido eliminado";
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
        $columnsMapping = array("cpp.id", "p.nombre");

        // Initialize query (get all)

        $api_logsQueriable = DB::table('precios_producto');
        $api_Result['recordsTotal'] = $api_logsQueriable->count();

        $query = "SELECT cpp.id, cpp.proveedor_id, cpp.total, p.nombre FROM cuentas_por_pagar cpp 
        INNER JOIN proveedores p on p.id = cpp.proveedor_id";

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

    public function getJsonDetalle(Request $params, $detalle)
	{
		$api_Result = array();
		// Create a mapping of our query fields in the order that will be shown in datatable.
		$columnsMapping = array("dc.compra_id", "p.codigo_barra", "p.nombre", "dc.existencias", "dc.precio_compra", "dc.precio_venta");

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
