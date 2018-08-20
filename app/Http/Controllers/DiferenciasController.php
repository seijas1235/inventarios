<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\diferencia;
use App\combustible;
use App\galones_mes;
use App\meses;
use App\User;
use Illuminate\Support\Facades\Input;

class DiferenciasController extends Controller
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
        return view("diferencias.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $combustibles = combustible::whereIn("id",[4,5,6])->get();

        return view("diferencias.create" , compact( "combustibles"));
    }


    public function getInventario(combustible $combustible) {

        $sal_comb = diferencia::where("estado", 1)->where("combustible_id", $combustible->id)->orderBy('id', 'desc')->get()->first();
        return Response::json($sal_comb);
    }


public function Diferencia_Disponible()
    {
        $fec = Input::get("fecha");
        $comb = Input::get("comb");


        $query = diferencia::whereRaw('LOWER(trim(fecha)) = ? and combustible_id= ?', array(strtolower(trim($fec)), strtolower(trim($comb))))->get();
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


$day = substr($data["fecha"], 8, 2);
        
        if ($day == "01"){
            $data["dif_acumulada_mes"] = $data["dif_dia"];            
        } else {
            $data["dif_acumulada_mes"] = $data["dif_acumulada_mes"] + $data["dif_dia"];    
        }

        $diferencias = diferencia::create($data);

        $action="Diferencias de Combustible Creado, con código ".$diferencias->id;
        $bitacora = HomeController::bitacora($action);

        return Response::json($diferencias);
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
        $columnsMapping = array("dc.id", "dc.fecha", "comb.combustible", "dc.gal_venta_dia", "dc.gal_sistema_comb", "dc.saldo_gals", "dc.dif_dia");

        // Initialize query (get all)

        $api_logsQueriable = DB::table('diferencias_combustible');
        $api_Result['recordsTotal'] = $api_logsQueriable->count();

        $query = 'SELECT dc.id as id, dc.fecha as fecha, comb.combustible as combustible, dc.gal_venta_dia as venta, dc.gal_sistema_comb as sistema, dc.saldo_gals as saldo, dc.dif_dia as dif FROM diferencias_combustible dc INNER JOIN combustible comb ON dc.combustible_id=comb.id  ';

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
        $condition = " WHERE dc.estado = 1 ";
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
