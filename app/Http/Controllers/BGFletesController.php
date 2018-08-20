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
use App\estado_corte;
use App\bg_flete_maestro;
use App\bg_flete_detalle;
use App\bg_flete_compra;
use App\bg_pago_fletes;
use App\bg_seguro;
use App\inventario_combustible;
use App\Proveedor;
use App\Camion;
use App\Destino;
use App\tanque;
use App\combustible;
use Illuminate\Support\Facades\Input;

class BGFletesController extends Controller
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
        return view("bg_fletes.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $proveedores = Proveedor::all();
        $destinos = Destino::all();
        $camiones = Camion::all();
        return view("bg_fletes.create" , compact( "proveedores","camiones","destinos"));
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
     $data["estado_corte_id"] = 1;
     $data["estado"] = 1;
     $data["fecha_corte"] = Carbon::createFromFormat('d-m-Y', $data['fecha_corte']);

     $bg_flete = bg_flete_maestro::create($data);

     $data_fc["bg_flete_maestro_id"]=$bg_flete->id;
     $data_fc["total_galones"]=$data["total_galones"];
     $data_fc["total_flete"]=$data["total_galones"]*0.6;
     $data_fc["estado_flete_id"]=1;
     $data_fc["estado"]=1;

     $bg_fletec = bg_flete_compra::create($data_fc);

     $sal = bg_pago_fletes::where("estado", 1)->orderBy('id', 'desc')->get()->first();

     $data_pago_flete["fecha_documento"] = $data["fecha_corte"];
     $data_pago_flete["documento"]="Factura Compra";
     $data_pago_flete["no_documento"]= $data["no_factura"] ;
     $data_pago_flete["cargo"]=$data["total_galones"]*0.6;
     $data_pago_flete["abono"]=0;
     $data_pago_flete["saldo"]=($data["total_galones"]*0.6)+$sal->saldo;
     $data_pago_flete["observaciones"]=$data["observaciones"];
     $data_pago_flete["estado"]=1;

     $pagos = bg_pago_fletes::create($data_pago_flete);

     if ($data["proveedor_id"] == 1){

         $data_seg["fecha_compra"] = $data["fecha_corte"];
         $data_seg["no_pedido"] = $data["no_pedido"];
         $data_seg["no_carga"] = $data["no_carga"];
         $data_seg["gal_super"] = $data["gal_super"];
         $data_seg["gal_regular"] = $data["gal_regular"];
         $data_seg["gal_diesel"] = $data["gal_diesel"];
         $data_seg["total_galones"] = $data["total_galones"];
         $data_seg["total_seguro"] = $data["total_galones"]*0.056;
         $data_seg["estado_seguro_id"] = 1;
         $data_seg["user_id"] = Auth::user()->id;
         $data_seg["estado"] = 1;

         $seguros = bg_seguro::create($data_seg);
     }


     $sal_comb = inventario_combustible::where("estado", 1)->orderBy('id', 'desc')->get()->first();

     $data_ic["fecha_inventario"] = $data["fecha_corte"];

     $data_ic["gal_sup_entrada"] = $data["gal_super"];;
     $data_ic["gal_sup_salida"] = 0;
     $data_ic["gal_sup_existencia"] =  ($sal_comb->gal_sup_existencia) + $data["gal_super"];

     if($data["gal_super"]>0){
         $data_ic["precio_promedio_sup"] = $data["total_super"]/$data["gal_super"];
         $data_ic["subtotal_entrada_sup"] = $data["total_super"];
         $data_ic["subtotal_salida_sup"] = 0;
         $data_ic["subtotal_exis_sup"] = (($sal_comb->gal_sup_existencia) + $data["gal_super"]) * ($data["total_super"]/$data["gal_super"]);
     }

     $data_ic["gal_reg_entrada"] = $data["gal_regular"];
     $data_ic["gal_reg_salida"] = 0;
     $data_ic["gal_reg_existencia"] = ($sal_comb->gal_reg_existencia) + $data["gal_regular"];

     if($data["gal_regular"]>0){
         $data_ic["precio_promedio_reg"] = $data["total_regular"]/$data["gal_regular"];
         $data_ic["subtotal_entrada_reg"] = $data["total_regular"];
         $data_ic["subtotal_salida_reg"] = 0;
         $data_ic["subtotal_exis_reg"] = (($sal_comb->gal_reg_existencia) + $data["gal_regular"]) * ($data["total_regular"]/$data["gal_regular"]);
     }

     $data_ic["gal_die_entrada"] = $data["gal_diesel"];
     $data_ic["gal_die_salida"] = 0;
     $data_ic["gal_die_existencia"] = ($sal_comb->gal_die_existencia) + $data["gal_diesel"];

     if($data["gal_diesel"]>0){
         $data_ic["precio_promedio_die"] = $data["total_diesel"]/$data["gal_diesel"];
         $data_ic["subtotal_entrada_die"] = $data["total_diesel"];
         $data_ic["subtotal_salida_die"] = 0;
         $data_ic["subtotal_exis_die"] = (($sal_comb->gal_die_existencia) + $data["gal_diesel"]) * ($data["total_diesel"]/$data["gal_diesel"]);
     }
     $data_ic["user_id"] = Auth::user()->id;
     $data_ic["estado"] = 1;

     $inv_combustible = inventario_combustible::create($data_ic);

     foreach($data['detalle'] as $detalle) 
     {
        $flete_detalle["bg_flete_maestro_id"] = $bg_flete->id ;
        $flete_detalle["combustible_id"] = $detalle["combustible_id"];
        $flete_detalle["tanque_id"] = $detalle["tanque_id"];
        $flete_detalle["galones"] = $detalle["galones"];
        $flete_detalle["precio_compra"] = $detalle["precio_compra"];
        $flete_detalle["subtotal"] = $detalle["subtotal"];

        $detalle = bg_flete_detalle::create($flete_detalle);
    }

    return $bg_flete;
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
        $columnsMapping = array("bgf.id", "bgf.fecha_corte", "pro.nombre_comercial", "bgf.no_carga", "bgf.no_pedido", "bgf.total_compra");

        // Initialize query (get all)

        $api_logsQueriable = DB::table('bg_fletes_maestro');
        $api_Result['recordsTotal'] = $api_logsQueriable->count();

        $query = "SELECT bgf.id as id, bgf.fecha_corte as fecha, pro.nombre_comercial as proveedor, bgf.no_carga as no_carga, bgf.no_pedido as no_pedido, bgf.total_compra as total
        FROM bg_fletes_maestro bgf
        INNER JOIN proveedores pro ON bgf.proveedor_id=pro.id";

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
