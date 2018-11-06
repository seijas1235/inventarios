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
Use App\CuentasPorCobrar;
Use App\sDetalle;
Use App\Venta;
Use App\Cliente;

class CuentasPorCobrarController extends Controller
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
        return view ("cuentas_por_cobrar.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function notacredito()
    {
        $clientes = DB::table('clientes')
        ->join('cuentas_por_cobrar', 'clientes.id', '=' ,'cuentas_por_cobrar.cliente_id')
        ->select('clientes.id', 'clientes.nombres')
        ->get();
        
		return view("cuentas_por_cobrar.ncredito" , compact('clientes'));
    }

    public function notadebito()
    {
        $clientes = Cliente::All();
		return view("cuentas_por_cobrar.ndebito" , compact('clientes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function savenotacredito(Request $request)
	{
        $data = $request->all();

        $cuentasporcobrar = CuentasPorCobrar::where('cliente_id',$data["cliente_id"])->first();
        $cuenta_id=$cuentasporcobrar["id"];
        

        if($cuentasporcobrar)
        {
            $detalle = array(
            
                'num_factura' => '',
                'cuentas_por_cobrar_id' => $cuenta_id,
                'fecha' => Carbon::now(),
                'descripcion' => 'Nota de Credito',
                'cargos' => 0,	
                'abonos' => $data["total"],
                'saldo' => $cuentasporcobrar->total - $data["total"]
            );					
    
            $cuenta2 = new sDetalle;
            $cuenta2->create($detalle);
            $newtotal = $detalle['saldo'];
            $cuentasporcobrar->update(['total' => $newtotal]);

            return Response::json($cuentasporcobrar);
        }
        else
        {
            return Response::json($cuentasporcobrar);
        }		

    }
    
    public function savenotadebito(Request $request)
	{
		$data = $request->all();

        $cuentasporcobrar = CuentasPorCobrar::where('cliente_id',$data["cliente_id"])->first();
        $cuenta_id=$cuentasporcobrar["id"];

        if($cuentasporcobrar)
        {
            $detalle = array(
                'num_factura' => '',
                'cuentas_por_cobrar_id' => $cuenta_id,
                'fecha' => Carbon::now(),
                'descripcion' => 'Nota de Debito',
                'cargos' => $data["total"],	
                'abonos' => 0,
                'saldo' => $cuentasporcobrar->total + $data["total"]
            );					
            $cuenta2 = new CuentaPorCobrarDetalle;
            $cuenta2->create($detalle);
            $newtotal = $detalle['saldo'];
            $cuentasporcobrar->update(['total' => $newtotal]);              
        }

        else
        {
            $detalle = array(
                'num_factura' => '',
                'fecha' => Carbon::now(),
                'descripcion' => 'Nota de Debito',
                'cargos' => $data["total"],	
                'abonos' => 0,
                'saldo' => $data["total"]
            );
            
            $cuentasporcobrar = new CuentasPorCobrar;
            $cuentasporcobrar->total = $data["total"];
            $cuentasporcobrar->cliente_id = $data["cliente_id"];
            $cuentasporcobrar->save();

            $cuentasporcobrar->cuentas_por_cobrar_detalle()->create($detalle);

        }

        return Response::json($cuentasporcobrar);
	}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(CuentasPorCobrar $cuenta_por_cobrar)
    {
        return view('cuentas_por_cobrar.show')->with('cuenta_por_cobrar', $cuenta_por_cobrar);
    }

    public function getJson(Request $params)
    {
        $api_Result = array();
        // Create a mapping of our query fields in the order that will be shown in datatable.
        $columnsMapping = array("cpc.id", "cpc.cliente_id","cpc.total", "c.nombres", "c.apellidos");

        // Initialize query (get all)

        $api_logsQueriable = DB::table('precios_producto');
        $api_Result['recordsTotal'] = $api_logsQueriable->count();

        $query = "SELECT cpc.id, cpc.cliente_id, cpc.total, concat( c.nombres,' ', c.apellidos) as nombre FROM cuentas_por_cobrar cpc 
        INNER JOIN clientes c on c.id = cpc.cliente_id";

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
		$columnsMapping = array("dc.id","dc.venta_id", "dc.num_factura", "dc.fecha", "dc.descripcion", "dc.cargos", "dc.abonos", "dc.saldo");

		// Initialize query (get all)


		$api_logsQueriable = DB::table('cuentas_por_cobrar_detalle');
		$api_Result['recordsTotal'] = $api_logsQueriable->count();

		$query = 'SELECT dc.id, if(dc.venta_id is null, 0,dc.venta_id)as cventa_id, dc.num_factura, dc.fecha,dc.descripcion ,dc.cargos, dc.abonos, dc.saldo
		FROM cuentas_por_cobrar_detalle dc
		INNER JOIN cuentas_por_cobrar cpc on cpc.id = dc.cuentas_por_cobrar_id
		WHERE dc.cuentas_por_cobrar_id ='.$detalle.'';

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
