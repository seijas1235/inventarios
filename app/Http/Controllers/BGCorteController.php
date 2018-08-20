<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\User;
use App\bg_corte_mensual;
use App\bg_combustible;
use App\bg_flete_detalle;
use App\bg_flete_compra;
use App\bg_flete_maestro;
use App\bg_mantenimiento;
use App\bg_repuesto;
use App\bg_salario;
use App\bg_seguro;
use App\bg_viatico;
use App\meses;
use Illuminate\Support\Facades\Input;

class BGCorteController extends Controller
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
        return view("bg_cortes.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create1()
    {
        $meses = meses::all();

        return view("bg_cortes.create1" , compact( "meses"));
    }


    public function create(Request $request)
    {
        $data = $request->all();
        $mes = $data['mes'];

        $querym = "SELECT * FROM meses WHERE id ='".$mes."'";
        $meses = DB::select($querym);

        $user = Auth::user()->id;
        $today = date("Y-m-d");

        $query = "SELECT IF(SUM(total_galones) > 0, SUM(total_galones), 0) as Tot_Gal FROM bg_fletes_maestro WHERE month(fecha_corte) ='".$mes."'";
        $tot_gal = DB::select($query);

        $tot_comb = $tot_gal[0]->Tot_Gal * 0.6;

        $querys = "SELECT IF(SUM(total_seguro) > 0, SUM(total_seguro), 0) as Tot_Seg FROM bg_seguro WHERE month(fecha_compra) ='".$mes."'";
        $tot_seg = DB::select($querys);


        $queryr = "SELECT IF(SUM(monto) > 0, SUM(monto), 0) as Tot_reps FROM bg_repuestos WHERE month(fecha_corte) ='".$mes."'";
        $reps = DB::select($queryr);

        $queryv = "SELECT IF(SUM(monto) > 0, SUM(monto), 0) as Tot_viat FROM bg_viaticos WHERE month(fecha_corte) ='".$mes."'";
        $viaticos = DB::select($queryv);

        $querys = "SELECT IF(SUM(monto) > 0, SUM(monto), 0) as Tot_sal FROM bg_salarios WHERE month(fecha_corte) ='".$mes."'";
        $salarios = DB::select($querys);

        $queryc = "SELECT IF(SUM(monto) > 0, SUM(monto), 0) as Tot_comb FROM bg_combustible WHERE month(fecha_corte) ='".$mes."'";
        $comb = DB::select($queryc);

        $querym = "SELECT IF(SUM(monto) > 0, SUM(monto), 0) as Tot_manto FROM bg_mantenimientos WHERE month(fecha_corte) ='".$mes."'";;
        $mantos = DB::select($querym);


        return view("bg_cortes.create" , compact( "user","today", "mes", "tot_gal", "tot_comb", "meses", "tot_seg", "reps", "viaticos", "salarios", "comb", "mantos"));
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
        $bg_corte = bg_corte_mensual::create($data);

         $action="Corte mensual de BG Creado, código ".$bg_corte->id-" y mes ".$bg_corte->mes_id;
        $bitacora = HomeController::bitacora($action);

        return Response::json($bg_corte);
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
        $columnsMapping = array("bgcm.id", "mes.mes", "bgcm.total_galones", "bgcm.total_ingreso", "bgcm.total_gastos_gb", "bgcm.utilidad");

        // Initialize query (get all)

        $api_logsQueriable = DB::table('bg_corte_mensual');
        $api_Result['recordsTotal'] = $api_logsQueriable->count();

        $query = "SELECT bgcm.id as id, mes.mes as mes, bgcm.total_galones as galones, bgcm.total_ingreso as ingreso, bgcm.total_gastos_bg as gastos, bgcm.utilidad_bg as utilidad FROM bg_corte_mensual bgcm INNER JOIN meses mes ON bgcm.mes_id=mes.id";

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
