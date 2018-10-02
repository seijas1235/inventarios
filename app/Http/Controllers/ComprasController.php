<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
//use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
Use App\User;
Use App\Compra;
Use App\Proveedor;
use App\DetalleCompra;
use App\Producto;

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
        return view ("compras.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $user = Auth::user()->id;
       $proveedores = Proveedor::all();
       return view("compras.create" , compact( "user", "proveedores"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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

        return Response::json($compra);
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
    public function edit(Compra $compra)
    {
        $query = "SELECT * FROM compras WHERE id=".$compra->id."";
        $fieldsArray = DB::select($query);

        $proveedores = Proveedor::all();
        return view('compras.edit', compact('compra', 'fieldsArray', 'proveedores'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Compra $compra, Request $request)
    {
        Response::json( $this->updateCompra($compra , $request->all()));
        return redirect('/compras');
    }

    public function updateCompra(Compra $compra, array $data )
    {
        $id= $compra->id;
        $compra->fecha = $data["fecha"];
        $compra->proveedor_id = $data["proveedor_id"];
        $compra->total = $data["total"];
        $compra->save();

        return $compra;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Compra $compra, Request $request)
    {
        $user1= Auth::user()->password;

        if ($request["password_delete"] == "")
        {
            $response["password_delete"]  = "La contraseña es requerida";
            return Response::json( $response  , 422 );
        }
        else if( password_verify( $request["password_delete"] , $user1))
        {
            $id= $compra->id;
            $compra->delete();
            
            $response["response"] = "La compra ha sido eliminada";
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
        $columnsMapping = array("id");

        // Initialize query (get all)

        $api_logsQueriable = DB::table('compras');
        $api_Result['recordsTotal'] = $api_logsQueriable->count();

        $query = "SELECT * FROM compras";

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

    public function getBuscar()
    {
        $productos=DB::table('productos')->get();

        $resultado =Input::get('codigo_barra');
        
        return Response::json( array(
            'resultado' => $resultado, 
            'sms' => " Parametro AJAX y JSON", 
            'productos' => $productos, 
            ));
    }

    public function buscarProducto(Request $request)
    {
        if(!$request->ajax())
        {
            return redirect('/');
        }

        else{
            $filtro = $request->filtro;
            $productos = Producto::where('codigo_barra', '=', $filtro)
            ->select('id','nombre')->orderBy('nombre','asc')->take(1)->get();

            return['productos' => $productos];
        }
        
    }

    public function dpiDisponible()
	{
		$dato = Input::get("emp_cui");
		$query = Empleado::where("emp_cui",$dato)->get();
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

}
