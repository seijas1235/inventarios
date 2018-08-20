<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\saldos_clientes;
use App\cliente;
use App\meses;
use App\User;


class SaldosClientesController extends Controller
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
        return view("saldo_cliente.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $meses = meses::all();
        $clientes = cliente::all();

        return view("saldo_cliente.create" , compact( "meses","clientes"));
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
        $data["estado"] = 1;
        $data["anio"] = 2018;
        $saldos_clientes = saldos_clientes::create($data);

        $action="Registro de Saldo Creada, con código ".$saldos_clientes->id;
        $bitacora = HomeController::bitacora($action);

        return Response::json($saldos_clientes);
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
    public function edit(saldos_clientes $saldo_cliente)
    {
        $meses = meses::all();
        $clientes = cliente::all();

        $query = "SELECT * FROM saldos_clientes WHERE id = ".$saldo_cliente->id." ";
        $fieldsArray = DB::select($query);

        return view('saldo_cliente.edit', compact('meses', 'clientes', 'saldo_cliente', 'fieldsArray'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(saldos_clientes $saldo_cliente, Request $request)
    {
     Response::json( $this->updateSaldoCliente($saldo_cliente , $request->all()));
        return redirect('/saldos_clientes');
    }

    public function updateSaldoCliente(saldos_clientes $saldo_cliente, array $data )
    {
        $action="Saldo de Cliente Editado, código ".$saldo_cliente->id."; datos anteriores: ".$saldo_cliente->mes_id.",".$saldo_cliente->cliente_id.",".$saldo_cliente->saldo."; datos nuevos ".$data["mes_id"].", ".$data["cliente_id"].", ".$data["saldo"]."";
        $bitacora = HomeController::bitacora($action);

        $saldo_cliente->mes_id = $data["mes_id"];
        $saldo_cliente->cliente_id = $data["cliente_id"];
        $saldo_cliente->saldo = $data["saldo"];
        $saldo_cliente->user_id = Auth::user()->id;
        $saldo_cliente->save();

        return $saldo_cliente;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(saldos_clientes $saldo_cliente, Request $request) {
        $user1= Auth::user()->password;

        if ($request["password_delete"] == "")
        {
            $response["password_delete"]  = "La contraseña es requerida";
            return Response::json( $response  , 422 );
        }
        else if( password_verify( $request["password_delete"] , $user1))
        {
            $id= $saldo_cliente->id;
            $saldo_cliente->estado = 2;

            $action="Saldo de Cliente Borrado, código ".$saldo_cliente->id." mes ".$saldo_cliente->mes_id." cliente ".$saldo_cliente->cliente_id." saldo " .$saldo_cliente->saldo."";
            $bitacora = HomeController::bitacora($action);

            $saldo_cliente->save();
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
        $columnsMapping = array("id", "serie", "resolucion", "fecha_vencimiento", "num_inferior", "num_superior", "documento");

        // Initialize query (get all)

        $api_logsQueriable = DB::table('series');
        $api_Result['recordsTotal'] = $api_logsQueriable->count();

        $query = "SELECT sc.id as id, mes.mes as mes, sc.anio as anio, CONCAT(cl.cl_nombres,' ',cl.cl_apellidos) as cliente, sc.saldo as saldo
FROM saldos_clientes sc 
INNER JOIN clientes cl ON sc.cliente_id=cl.id
INNER JOIN meses mes ON sc.mes_id=mes.id ";

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
        $condition = " WHERE sc.estado = 1 ";
        $query = $query . $condition . $where ;

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
