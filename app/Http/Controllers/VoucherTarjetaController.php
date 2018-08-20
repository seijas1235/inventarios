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
use App\voucher_tarjeta;
use Illuminate\Support\Facades\Input;

class VoucherTarjetaController extends Controller
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
        return view("vouchers.index");
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
        return view("vouchers.create" , compact( "user","today"));
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
        $data["fecha_corte"]=Carbon::createFromFormat('Y-m-d', $data["fecha_corte"]);

        $voucher = voucher_tarjeta::create($data);

        $action="Voucher de tarjetas creado, código ".$voucher->id;
        $bitacora = HomeController::bitacora($action);

        return Response::json($voucher);
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
    public function edit(voucher_tarjeta $voucher)
    {
        return view('vouchers.edit', compact('voucher'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(voucher_tarjeta $voucher, Request $request)
    {
     Response::json( $this->updateVoucher($voucher , $request->all()));
        return redirect('/vouchers');
    }

    public function updateVoucher(voucher_tarjeta $voucher, array $data )
    {
        $action="Voucher Editado, código ".$voucher->id."; datos anteriores: ".$voucher->no_lote.",".$voucher->total.",".$voucher->observaciones.",".$voucher->fecha_corte.",".$voucher->codigo_corte."; datos nuevos ".$data["no_lote"].", ".$data["total"].", ".$data["observaciones"].", ".$data["fecha_corte"].",".$data["codigo_corte"]."";
        $bitacora = HomeController::bitacora($action);

        $voucher->no_lote = $data["no_lote"];
        $voucher->total = $data["total"];
        $voucher->observaciones = $data["observaciones"];
        $voucher->fecha_corte = $data["fecha_corte"];
        $voucher->codigo_corte = $data["codigo_corte"];
        $voucher->user_id = Auth::user()->id;
        $voucher->save();
        return $voucher;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(voucher_tarjeta $voucher, Request $request)
    {
        $user1= Auth::user()->password;

        if ($request["password_delete"] == "")
        {
            $response["password_delete"]  = "La contraseña es requerida";
            return Response::json( $response  , 422 );
        }
        else if( password_verify( $request["password_delete"] , $user1))
        {
            $action="Voucher Borrado, codigo ".$voucher->id." y datos ".$voucher->no_lote.",".$voucher->total.",".$voucher->observaciones.",".$voucher->codigo_corte.",".$voucher->user_id."";
            $bitacora = HomeController::bitacora($action);

            $voucher->delete();

            $response["response"] = "El registro ha sido borrado";
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
        $columnsMapping = array("id", "fecha_corte", "no_lote", "total", "observaciones");

        // Initialize query (get all)

        $api_logsQueriable = DB::table('voucher_tarjetas');
        $api_Result['recordsTotal'] = $api_logsQueriable->count();

        $query = "SELECT id, DATE_FORMAT(fecha_corte, '%d-%m-%Y') as fecha_corte, no_lote, total, observaciones FROM voucher_tarjetas";

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
