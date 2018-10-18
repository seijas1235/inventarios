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
Use App\DetalleCuentaPorPagar;
Use App\CuentaPorPagar;
Use App\Proveedor;
class CuentasPorPagarController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        return view ("cuentas_por_pagar.index");
    }

    public function notacredito()
    {
        $proveedores = Proveedor::All();
		return view("cuentas_por_pagar.ncredito" , compact('proveedores'));
    }

    public function notadebito()
    {
        $proveedores = Proveedor::All();
		return view("cuentas_por_pagar.ndebito" , compact('proveedores'));
    }


    public function savenotacredito(Request $request)
	{
        $data = $request->all();

        $cuentaporpagar = CuentaPorPagar::where('proveedor_id',$data["proveedor_id"])->first();

            $detalle = array(
                'num_factura' => '',
                'fecha' => Carbon::now(),
                'descripcion' => 'Nota de Credito',
                'cargos' => 0,	
                'abonos' => $data["total"],
                'saldo' => $cuentaporpagar->total - $data["total"]
            );					

            $cuentaporpagar->detalles_cuentas_por_pagar()->create($detalle);
            $newtotal = $detalle['saldo'];
            $cuentaporpagar->update(['total' => $newtotal]);        

		return Response::json($cuentaporpagar);
    }

    public function savenotadebito(Request $request)
	{
		$data = $request->all();

        $cuentaporpagar = CuentaPorPagar::where('proveedor_id',$data["proveedor_id"])->first();

            $detalle = array(
                'num_factura' => '',
                'fecha' => Carbon::now(),
                'descripcion' => 'Nota de Debito',
                'cargos' => $data["total"],	
                'abonos' => 0,
                'saldo' => $cuentaporpagar->total + $data["total"]
            );					

            $cuentaporpagar->detalles_cuentas_por_pagar()->create($detalle);
            $newtotal = $detalle['saldo'];
            $cuentaporpagar->update(['total' => $newtotal]);        

		return Response::json($cuentaporpagar);
	}


    public function show(CuentaPorPagar $cuenta_por_pagar)
    {
        return view('cuentas_por_pagar.show')->with('cuenta_por_pagar', $cuenta_por_pagar);
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
		$columnsMapping = array("dc.id","dc.compra_id", "dc.num_factura");

		// Initialize query (get all)


		$api_logsQueriable = DB::table('detalles_cuentas_por_pagar');
		$api_Result['recordsTotal'] = $api_logsQueriable->count();

		$query = 'SELECT dc.id, if(dc.compra_id is null, 0,dc.compra_id)as compra_id, dc.num_factura, dc.fecha, dc.descripcion, dc.cargos, dc.abonos, dc.saldo
		FROM detalles_cuentas_por_pagar dc
		INNER JOIN cuentas_por_pagar cpp on cpp.id = dc.cuenta_por_pagar_id
		WHERE dc.cuenta_por_pagar_id ='.$detalle.'';

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
