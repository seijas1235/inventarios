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
use App\corte_caja;
use App\precio_combustible;
use App\inventario_combustible;
use Illuminate\Support\Facades\Input;
use Barryvdh\DomPDF\Facade as PDF;

class CorteCajaController extends Controller
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
        return view("corte_caja.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function create()
    {
        return view("corte_caja.create1");
    }

    public function create1(Request $request)
    {
        $user = Auth::user()->id;
        $today = date("Y-m-d");

        $disel_a = precio_combustible::where("combustible_id", 1)->orderBy('id', 'desc')->get()->first();
        $super_a = precio_combustible::where("combustible_id", 2)->orderBy('id', 'desc')->get()->first();
        $regular_a = precio_combustible::where("combustible_id", 3)->orderBy('id', 'desc')->get()->first();
        $disel_sc = precio_combustible::where("combustible_id", 4)->orderBy('id', 'desc')->get()->first();
        $super_sc = precio_combustible::where("combustible_id", 5)->orderBy('id', 'desc')->get()->first();
        $regular_sc = precio_combustible::where("combustible_id",6)->orderBy('id', 'desc')->get()->first();


        $data = $request->all();
        $cod = $data['codigo'];
        
        $query = "SELECT IF(SUM(monto) > 0, SUM(monto), 0) as Tot_Gasto FROM gastos WHERE codigo_corte ='".$cod."'";
        $gastos = DB::select($query);

        $query2 = "SELECT IF(SUM(total_vale) >0, SUM(total_vale), 0) as Tot_Vale FROM vale_maestro WHERE codigo_corte ='".$cod."' AND estado_vale_id < 4";
        $vales = DB::select($query2);

        $query3 = "SELECT IF(SUM(total) > 0, SUM(total), 0) as Tot_Voucher FROM voucher_tarjetas WHERE codigo_corte ='".$cod."'";
        $vouchers = DB::select($query3);

        $query4 = "SELECT IF(SUM(monto) > 0, SUM(monto), 0) as Tot_anti FROM anticipo_empleados WHERE codigo_corte ='".$cod."'";
        $anticipos = DB::select($query4);


        $queryr = "SELECT IF(SUM(monto) > 0, SUM(monto), 0) as Tot_reps FROM bg_repuestos WHERE codigo_corte ='".$cod."'";
        $reps = DB::select($queryr);

        $queryv = "SELECT IF(SUM(monto) > 0, SUM(monto), 0) as Tot_viat FROM bg_viaticos WHERE codigo_corte ='".$cod."'";
        $viaticos = DB::select($queryv);

        $querys = "SELECT IF(SUM(monto) > 0, SUM(monto), 0) as Tot_sal FROM bg_salarios WHERE codigo_corte ='".$cod."'";
        $salarios = DB::select($querys);

        $queryc = "SELECT IF(SUM(monto) > 0, SUM(monto), 0) as Tot_comb FROM bg_combustible WHERE codigo_corte ='".$cod."'";
        $comb = DB::select($queryc);

        $querym = "SELECT IF(SUM(monto) > 0, SUM(monto), 0) as Tot_manto FROM bg_mantenimientos WHERE codigo_corte ='".$cod."'";
        $mantos = DB::select($querym);

        $queryf = "SELECT IF(SUM(monto) > 0, SUM(monto), 0) as Tot_falta FROM faltantes WHERE codigo_corte ='".$cod."'";
        $faltantes = DB::select($queryf);

        $querycup = "SELECT IF(SUM(monto) > 0, SUM(monto), 0) as Tot_cup FROM cupones WHERE codigo_corte ='".$cod."'";
        $cupones = DB::select($querycup);


        $total_gastos_bg = $reps[0]->Tot_reps + $viaticos[0]->Tot_viat + $salarios[0]->Tot_sal + $comb[0]->Tot_comb + $mantos[0]->Tot_manto;

        $total_venta = $gastos[0]->Tot_Gasto + $vales[0]->Tot_Vale + $vouchers[0]->Tot_Voucher + $anticipos[0]->Tot_anti + $total_gastos_bg + $faltantes[0]->Tot_falta + $cupones[0]->Tot_cup;
        

        return view("corte_caja.create" , compact( "user","today","disel_a","super_a","regular_a","disel_sc", "super_sc", "regular_sc", "vales", "gastos", "total_venta", "vouchers", "anticipos", "total_gastos_bg", "faltantes", "cod", "cupones"));
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
        $data["fecha_corte"]=Carbon::createFromFormat('Y-m-d', $data["fecha_corte"]);
        $cortecaja = corte_caja::create($data);

        $sal_comb = inventario_combustible::where("estado", 1)->orderBy('id', 'desc')->get()->first();

        $data_ic["fecha_inventario"]=Carbon::createFromFormat('Y-m-d', $data["fecha_inventario"]);
        $data_ic["gal_sup_entrada"] = 0;
        $data_ic["gal_sup_salida"] = $data["gal_super"];
        $data_ic["gal_sup_existencia"] = $sal_comb->gal_sup_existencia - $data["gal_super"];
        $data_ic["precio_promedio_sup"] = $data["total_super"]/$data["gal_super"];
        $data_ic["subtotal_entrada_sup"] = 0;;
        $data_ic["subtotal_salida_sup"] = $data["total_super"];
        $data_ic["subtotal_exis_sup"] = ($sal_comb->gal_sup_existencia - $data["gal_super"]) * ($data["total_super"]/$data["gal_super"]) ;

        $data_ic["gal_reg_entrada"] = 0;
        $data_ic["gal_reg_salida"] =$data["gal_regular"];
        $data_ic["gal_reg_existencia"] = $sal_comb->gal_reg_existencia - $data["gal_regular"];
        $data_ic["precio_promedio_reg"] = $data["total_regular"]/$data["gal_regular"];
        $data_ic["subtotal_entrada_reg"] = 0;
        $data_ic["subtotal_salida_reg"] = $data["total_regular"];
        $data_ic["subtotal_exis_reg"] = ($sal_comb->gal_reg_existencia - $data["gal_regular"]) * ($data["total_regular"]/$data["gal_regular"]) ;

        $data_ic["gal_die_entrada"] = 0;
        $data_ic["gal_die_salida"] = $data["gal_diesel"];
        $data_ic["gal_die_existencia"] = $sal_comb->gal_die_existencia - $data["gal_diesel"];
        $data_ic["precio_promedio_die"] = $data["total_diesel"]/$data["gal_diesel"];
        $data_ic["subtotal_entrada_die"] = 0;
        $data_ic["subtotal_salida_die"] = $data["total_diesel"];
        $data_ic["subtotal_exis_die"] = ($sal_comb->gal_die_existencia - $data["gal_diesel"]) * ($data["total_diesel"]/$data["gal_diesel"]);

        $data_ic["user_id"] = Auth::user()->id;
        $data_ic["estado"] = 1;

        $inv_combustible = inventario_combustible::create($data_ic);

        $action="Corte de Caja Diario Creado, código ".$cortecaja->id-" y fecha ".$cortecaja->fecha_corte;
        $bitacora = HomeController::bitacora($action);

        return Response::json($cortecaja);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showCorte(corte_caja $cortec)
    {
        $corte = corte_caja::where('id', $cortec->id)->get();

        $pdf = PDF::loadView('corte_caja.show', compact('cortec','corte'));
        $customPaper = array(0,0,595,841);
        $pdf->setPaper($customPaper, 'portrait');

        return $pdf->stream('corte_caja', array("Attachment" => 0));
    }


    public function showCorte2(corte_caja $cortec)
    {
        $corte = corte_caja::where('id', $cortec->id)->get();

        $pdf = PDF::loadView('corte_caja.show2', compact('cortec','corte'));
        $customPaper = array(0,0,595,841);
        $pdf->setPaper($customPaper, 'portrait');

        return $pdf->stream('corte_caja_resumen', array("Attachment" => 0));
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
        $columnsMapping = array("id", "fecha_corte","total_ventas", "total_ventas_turno", "resultado_turno", "resultado_q");

        // Initialize query (get all)

        $api_logsQueriable = DB::table('corte_caja');
        $api_Result['recordsTotal'] = $api_logsQueriable->count();

        $query = "SELECT id, DATE_FORMAT(fecha_corte, '%d-%m-%Y') as fecha_corte, total_ventas, total_ventas_turno, resultado_turno, resultado_q FROM corte_caja";

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



    public function Corte_Disponible()
    {
        $dato = Input::get("codigocorte");
        $query = corte_caja::where("codigo_corte","=",$dato)->get();
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
