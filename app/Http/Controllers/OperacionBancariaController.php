<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use App\operacion_bancaria;
use App\documentos;
use App\cuenta;
use App\User;

class OperacionBancariaController extends Controller
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
        return view("operaciones.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user()->id;
        $today = date("Y/m/d");
        $dd = [3, 4, 5, 6];
        $doctos = documentos::whereIn("id",$dd)->get();
        $cuentas = cuenta::all();

        return view("operaciones.create" , compact( "user","today","doctos","cuentas"));
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

        $sal = operacion_bancaria::where("estado", 1)->orderBy('id', 'desc')->get()->first();

        if ($data["transaccion_id"] == 1){
            $data["debitos"] = $data["monto"];
            $data["creditos"] = 0;
            $data["saldo"] = $sal->saldo - $data["monto"];
        }else if ($data["transaccion_id"] == 2){
            $data["debitos"] = 0;
            $data["creditos"] = $data["monto"];
            $data["saldo"] = $sal->saldo + $data["monto"];
        }

        $op_ba = operacion_bancaria::create($data);

        $action="Operacion Bancaria creada, código ".$op_ba->id;
        $bitacora = HomeController::bitacora($action);

        return Response::json($op_ba);
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function getJson(Request $params)
    {
        $api_Result = array();
        // Create a mapping of our query fields in the order that will be shown in datatable.
        $columnsMapping = array("ob.id", "ob.fecha_transaccion", "doc.documento", "ob.no_documento", "ob.debitos", "ob.creditos", "ob.saldo", "ob.descripcion");

        //  Initialize query (get all)

        $api_logsQueriable = DB::table('operacion_bancaria');
        $api_Result['recordsTotal'] = $api_logsQueriable->count();

        $query = "SELECT ob.id as id, ob.fecha_transaccion as fecha, CONCAT(doc.documento,' ',ob.no_documento) as docto, ob.debitos as debitos, ob.creditos as creditos, ob.saldo as saldo, ob.descripcion as descripcion  FROM operacion_bancaria ob INNER JOIN cuenta cta ON ob.cuenta_id=cta.id INNER JOIN documentos doc ON ob.documento_id=doc.id";

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
        $condition = " WHERE ob.estado = 1 ";
        $query = $query . $where . $condition;

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
