<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Requisicion;
use App\Cheque;
use App\User;
use App\Cuenta;
use App\cliente;
use App\estado_cheque;
use Illuminate\Support\Facades\Input;
use Barryvdh\DomPDF\Facade as PDF;

class ChequesController extends Controller
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
        return view("cheques.index");
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clientes = cliente::all();
        $today = date("d/m/Y");
        $cuentas = cuenta::all();
        $user = Auth::user()->name;

        $query = "SELECT * FROM requisicion WHERE estado_requisicion_id = 4";
        $requisiciones = DB::select($query);

        return view("cheques.create" , compact( "user", "today", "clientes", "cuentas", "requisiciones"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $today = date("d/m/Y");
        $user = Auth::user()->id;

        $data = $request->all();
        $data["user_crea_id"] = Auth::user()->id;
        $data["monto_letras"] = \NumeroALetras::convertir($data["monto"], 'quetzales', 'centavos');
        $data["user_imprime_id"] = 1;
        $data["user_anula_id"] = 1;
        $data["user_reg_cobro_id"] = 1;
        $data["estado_cheque_id"] = 1;

        $cheques = Cheque::create($data);

        $requi = Requisicion::where("id",$cheques->requisicion_id)->get()->first();
        $requi->estado_requisicion_id = 6;
        $requi->save();

        $action="El cheque ha sido Creada, con código ".$cheques->id;
        $bitacora = HomeController::bitacora($action);

        return Response::json($cheques);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Cheque $cheque)
    {
        $clientes = cliente::all();
        $today = date("d/m/Y");
        $cuentas = cuenta::all();
        $user = Auth::user()->name;

        $query = "SELECT * FROM requisicion WHERE estado_requisicion_id = 4 or estado_requisicion_id = 6";
        $requisiciones = DB::select($query);

        $query = "SELECT * FROM cheque WHERE id=".$cheque->id."";
        $fieldsArray = DB::select($query);

        return view('cheques.edit', compact( "user", "today", "clientes", "cuentas", "requisiciones", "fieldsArray", "cheque"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Cheque $cheque, Request $request)
    {
        Response::json( $this->updateCheque($cheque , $request->all()));
        return redirect('/cheques');
    }

    public function updateCheque(Cheque $cheque, array $data )
    {
        /*$action="Cheque Editado, codigo ".$cheque->id."; datos anteriores: ".$cheque->no_cuenta_id.",".$cheque->monto.",".$no_cheque->cliente_id.",".$cheque->no_cheque.";".$cheque->requisicion_id.";".$cheque->referencia."; datos nuevos: ".$data["no_cuenta_id"].",".$data["monto"].",".$data["cliente_id"].",".$data["no_cheque"].",".$data["requisicion_id"].",".$data["referencia"]."";
        $bitacora = HomeController::bitacora($action);*/

        $id= $cheque->id;
        $cheque->no_cuenta_id = $data["no_cuenta_id"];
        $cheque->monto = $data["monto"];
        $cheque->monto_letras = \NumeroALetras::convertir($data["monto"], 'quetzales', 'centavos');
        $cheque->no_cheque = $data["no_cheque"];
        $cheque->requisicion_id = $data["requisicion_id"];
        $cheque->referencia = $data["referencia"];
        $cheque->no_cuenta_id = $data["no_cuenta_id"];
        $cheque->pagar_a = $data["pagar_a"];
        $cheque->fecha_cheque = $data["fecha_cheque"];
        $cheque->save();

        return $cheque;
    }



    public function showCheque(Cheque $cheque)
    {
        $id= $cheque->id;
        $cheque->estado_cheque_id = 2;
        $cheque->save();

        $chequelin = Cheque::where("id", $cheque->id)->get()->first();
        $pdf = PDF::loadView('cheques.show', compact('chequelin'));
        $customPaper = array(0,0,400,680);
        $pdf->setPaper($customPaper, 'portrait');

        return $pdf->stream('cheque', array("Attachment" => 0));
    }


    public function reg_cobro(Cheque $cheque, Request $request)
    {
        $id= $cheque->id;
        $cheque->estado_cheque_id = 4;
        $cheque->save();

        return view("cheques.index");
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cheque $cheque, Request $request)
    {
        $user1= Auth::user()->password;

        if ($request["password_delete"] == "")
        {
            $response["password_delete"]  = "La contraseña es requerida";
            return Response::json( $response  , 422 );
        }
        else if( password_verify( $request["password_delete"] , $user1))
        {
            $id= $cheque->id;
            $cheque->estado_cheque_id = 3;

            $action="Cheque Anulado, código de Cheque ".$cheque->id."";
            $bitacora = HomeController::bitacora($action);

            $cheque->save();

            $response["response"] = "El registro ha sido anulado";
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
        $columnsMapping = array("che.id", "cl.cl_nombres", "cl.cl_apellidos",
            "req.id", "che.monto", "ech.estado_cheque");

        // Initialize query (get all)

        $api_logsQueriable = DB::table('requisicion');
        $api_Result['recordsTotal'] = $api_logsQueriable->count();

        $query = "SELECT che.id as id, che.no_cheque as cheque, DATE_FORMAT(che.created_at, '%d-%m-%Y') as fecha, che.pagar_a as pagar_a,
        req.id as requi, che.monto as monto, ech.estado_cheque as estado
        FROM cheque che 
        INNER JOIN requisicion req ON req.id=che.requisicion_id
        INNER JOIN estado_cheque ech ON che.estado_cheque_id=ech.id ";

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
