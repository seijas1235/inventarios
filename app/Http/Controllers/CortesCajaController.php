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
Use App\CorteCaja;


class CortesCajaController extends Controller
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
        return view ("cortes_caja.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $user = Auth::user()->id;
       return view("cortes_caja.create" , compact( "user" ));
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
        $corte_caja = CorteCaja::create($data);

        return Response::json($corte_caja);
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
    public function edit(CorteCaja $corte_caja)
    {
        $query = "SELECT * FROM cortes_caja WHERE id=".$corte_caja->id."";
        $fieldsArray = DB::select($query);

        return view('cortes_caja.edit', compact('corte_caja', 'fieldsArray'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CorteCaja $corte_caja, Request $request)
    {
        $this->validate($request,['nit' => 'required|unique:cortes_caja,nit,'.$corte_caja->id
        ]);
        Response::json( $this->updateCorteCaja($corte_caja , $request->all()));
        return redirect('/cortes_caja');
    }

    public function updateCorteCaja(CorteCaja $corte_caja, array $data )
    {
        $id= $corte_caja->id;
        $corte_caja->nit = $data["nit"];
        $corte_caja->nombre = $data["nombre"];
        $corte_caja->telefonos = $data["telefonos"];
        $corte_caja->direccion = $data["direccion"];
        $corte_caja->save();

        return $corte_caja;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(CorteCaja $corte_caja, Request $request)
    {
        $user1= Auth::user()->password;

        if ($request["password_delete"] == "")
        {
            $response["password_delete"]  = "La contraseña es requerida";
            return Response::json( $response  , 422 );
        }
        else if( password_verify( $request["password_delete"] , $user1))
        {
            $id= $corte_caja->id;
            $corte_caja->delete();
            
            $response["response"] = "El tipo corte_caja ha sido eliminado";
            return Response::json( $response );
        }
        else {
            $response["password_delete"] = "La contraseña no coincide";
            return Response::json( $response  , 422 );
        }    
    }

    public function getEfectivo(Request $request)
	{
		$fecha = $request["data"];

		if ($fecha == "")
		{
			$result = "";
			return Response::json( $result);
		}
		else {
			$query = "SELECT if(sum(v.total_venta) is null,0, sum(v.total_venta)) as efectivo FROM ventas_maestro v
            INNER JOIN facturas f on v.id = f.venta_id
            where v.created_at BETWEEN '".$fecha."' AND '".$fecha." 23:59:59'
            AND v.tipo_pago_id = 1 limit 1 ";
				$result = DB::select($query);
				return Response::json( $result);
            }
            
    }
    
    public function getTarjeta(Request $request)
	{
		$fecha = $request["data"];

		if ($fecha == "")
		{
			$result = "";
			return Response::json( $result);
		}
		else {
			$query = "SELECT if(sum(v.total_venta) is null,0, sum(v.total_venta)) as tarjeta FROM ventas_maestro v 
            INNER JOIN facturas f on v.id = f.venta_id
            where v.created_at BETWEEN '".$fecha."' AND '".$fecha." 23:59:59'
            AND v.tipo_pago_id = 2 limit 1 ";
				$result = DB::select($query);
				return Response::json( $result);
            }
            
    }
    
    public function getCredito(Request $request)
	{
		$fecha = $request["data"];

		if ($fecha == "")
		{
			$result = "";
			return Response::json( $result);
		}
		else {
			$query = "SELECT if(sum(v.total_venta) is null,0, sum(v.total_venta)) as credito FROM ventas_maestro v 
            INNER JOIN facturas f on v.id = f.venta_id
            where v.created_at BETWEEN '".$fecha."' AND '".$fecha." 23:59:59'
            AND v.tipo_pago_id = 3 limit 1 ";
				$result = DB::select($query);
				return Response::json( $result);
            }
            
    }
    
    public function getTotal(Request $request)
	{
		$fecha = $request["data"];

		if ($fecha == "")
		{
			$result = "";
			return Response::json( $result);
		}
		else {
			$query = "SELECT if(sum(v.total_venta) is null,0, sum(v.total_venta)) as total FROM ventas_maestro v 
            INNER JOIN facturas f on v.id = f.venta_id
            where v.created_at BETWEEN '".$fecha."' AND '".$fecha." 23:59:59' limit 1 ";
				$result = DB::select($query);
				return Response::json( $result);
            }
            
    }

    public function getEfectivoSF(Request $request)
	{
		$fecha = $request["data"];

		if ($fecha == "")
		{
			$result = "";
			return Response::json( $result);
		}
		else {
			$query = "SELECT if(sum(v.total_venta) is null,0, sum(v.total_venta)) as efectivo FROM ventas_maestro v
            where v.created_at BETWEEN '".$fecha."' AND '".$fecha." 23:59:59'
            AND v.tipo_pago_id = 1 limit 1 ";
				$result = DB::select($query);
				return Response::json( $result);
            }
            
    }
    
    public function getTarjetaSF(Request $request)
	{
		$fecha = $request["data"];

		if ($fecha == "")
		{
			$result = "";
			return Response::json( $result);
		}
		else {
			$query = "SELECT if(sum(v.total_venta) is null,0, sum(v.total_venta)) as tarjeta FROM ventas_maestro v 
            where v.created_at BETWEEN '".$fecha."' AND '".$fecha." 23:59:59'
            AND v.tipo_pago_id = 2 limit 1 ";
				$result = DB::select($query);
				return Response::json( $result);
            }
            
    }
    
    public function getCreditoSF(Request $request)
	{
		$fecha = $request["data"];

		if ($fecha == "")
		{
			$result = "";
			return Response::json( $result);
		}
		else {
			$query = "SELECT if(sum(v.total_venta) is null,0, sum(v.total_venta)) as credito FROM ventas_maestro v 
            where v.created_at BETWEEN '".$fecha."' AND '".$fecha." 23:59:59'
            AND v.tipo_pago_id = 3 limit 1";
				$result = DB::select($query);
				return Response::json( $result);
            }
            
    }
    
    public function getTotalSF(Request $request)
	{
		$fecha = $request["data"];

		if ($fecha == "")
		{
			$result = "";
			return Response::json( $result);
		}
		else {
			$query = "SELECT if(sum(v.total_venta) is null,0, sum(v.total_venta)) as total FROM ventas_maestro v 
            where v.created_at BETWEEN '".$fecha."' AND '".$fecha." 23:59:59' limit 1";
				$result = DB::select($query);
				return Response::json( $result);
            }
            
    }

    public function getFacturas(Request $request)
	{
		$fecha = $request["data"];

		if ($fecha == "")
		{
			$result = "";
			return Response::json( $result);
		}
		else {
			$query = "SELECT MIN(f.numero) as factura_inicial, MAX(f.numero) as factura_final FROM ventas_maestro v 
            INNER JOIN facturas f on v.id = f.venta_id 
            where v.created_at BETWEEN '".$fecha."' AND '".$fecha." 23:59:59' limit 1";
				$result = DB::select($query);
				return Response::json( $result);
            }
            
    }
    
    public function corteUnico()
	{
		$dato = Input::get("fecha");
		$query = CorteCaja::where("fecha", $dato)->get();
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


    public function getJson(Request $params)
    {
        $api_Result = array();
        // Create a mapping of our query fields in the order that will be shown in datatable.
        $columnsMapping = array("id", "fecha", "factura_inicial", "factura_final", "total", "efectivo", "credito", "voucher");

        // Initialize query (get all)

        $api_logsQueriable = DB::table('cortes_caja');
        $api_Result['recordsTotal'] = $api_logsQueriable->count();

        $query = "SELECT * FROM cortes_caja";

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
}
