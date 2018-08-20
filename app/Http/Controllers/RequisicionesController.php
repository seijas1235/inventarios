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
use App\empleado;
use App\user_empleado;
use App\User;
use App\cliente;
use App\cuenta_contable;
use App\estado_requisicion;
use Illuminate\Support\Facades\Input;

class RequisicionesController extends Controller
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
        return view("requisiciones.index");
    }

 public function getInfo(Requisicion $requisicion) {

        return $requisicion;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $today = Carbon::now();

        $user = Auth::user()->id;
        $emp1 = user_empleado::where("user_id", $user)->get()->first();
        $empleado = empleado::where("id", $emp1->empleado_id)->get()->first();

        $cuentasc = cuenta_contable::whereIN("estacion_servicio_id", [1,3])->get();

        return view("requisiciones.create" , compact( "user", "today", "empleado", "cuentasc"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user()->id;
        $emp1 = user_empleado::where("user_id", $user)->get()->first();
        $empleado = empleado::where("id", $emp1->empleado_id)->get()->first();

        $data = $request->all();
        $data["empleado_solicita_id"] = $empleado->id;
        $data["user_crea_id"] = Auth::user()->id;
        $data["user_rechaza_id"] = 1;
        $data["user_autoriza_id"] = 1;
        $data["user_anula_id"] = 1;
        $data["estado_requisicion_id"] = 1;

        $requis = Requisicion::create($data);

        $action="La Requisicion ha sido Creada, con código ".$requis->id;
        $bitacora = HomeController::bitacora($action);

        return Response::json($requis);
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
    public function edit(Requisicion $requisicion)
    {
        $clientes = cliente::all();
        $today = date("d/m/Y");

        $user = Auth::user()->id;
        $emp1 = user_empleado::where("user_id", $user)->get()->first();
        $empleado = empleado::where("id", $emp1->empleado_id)->get()->first();
        $cuentasc = cuenta_contable::whereIN("estacion_servicio_id", [1,3])->get();

        $query = "SELECT * FROM requisicion WHERE id=".$requisicion->id."";
        $fieldsArray = DB::select($query);

        return view('requisiciones.edit', compact( "user", "today", "clientes", "cuentasc", "empleado", "fieldsArray", "requisicion"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requisicion $requisicion, Request $request)
    {
        Response::json( $this->updateRequisicion($requisicion , $request->all()));
        return redirect('/requisiciones');
    }

    public function updateRequisicion(Requisicion $requisicion, array $data )
    {
        $action="Requisicion Editada, codigo ".$requisicion->id."; datos anteriores: ".$requisicion->fecha_requisicion.",".$requisicion->monto.",".$requisicion->concepto."; datos nuevos: ".$data["fecha_requisicion"].",".$data["monto"].",".$data["concepto"]."";
        $bitacora = HomeController::bitacora($action);

        $id= $requisicion->id;
        $requisicion->fecha_requisicion = $data["fecha_requisicion"];
        $requisicion->no_requisicion = $data["no_requisicion"];
        $requisicion->monto = $data["monto"];
        $requisicion->pagar_a = $data["pagar_a"];
        $requisicion->concepto = $data["concepto"];
        $requisicion->cuenta_contable_id = $data["cuenta_contable_id"];
        $requisicion->save();

        return $requisicion;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Requisicion $requisicion, Request $request)
    {
        $user1= Auth::user()->password;

        if ($request["password_delete"] == "")
        {
            $response["password_delete"]  = "La contraseña es requerida";
            return Response::json( $response  , 422 );
        }
        else if( password_verify( $request["password_delete"] , $user1))
        {
            $id= $requisicion->id;
            $requisicion->estado_requisicion_id = 5;

            $action="Requisicion Anulada, código de Requisicion ".$requisicion->id."";
            $bitacora = HomeController::bitacora($action);

            $requisicion->save();

            $response["response"] = "El registro ha sido anulado";
            return Response::json( $response );
        }
        else {
            $response["password_delete"] = "La contraseña no coincide";
            return Response::json( $response  , 422 );
        }
    }



    public function rechaza(Requisicion $requisicion, Request $request)
    {
        $user1= Auth::user()->password;

        if ($request["password_delete"] == "")
        {
            $response["password_delete"]  = "La contraseña es requerida";
            return Response::json( $response  , 422 );
        }
        else if( password_verify( $request["password_delete"] , $user1))
        {
            $id= $requisicion->id;
            $requisicion->estado_requisicion_id = 3;
            $requisicion->user_anula_id = Auth::user()->id;
            $requisicion->razon_anula = "X";
            $requisicion->fecha_anula = date("d/m/Y");

            $action="Requisicion Rechazada, código de Requisicion ".$requisicion->id." con estado ".$requisicion->estado_requisicion_id." a estado 3";
            $bitacora = HomeController::bitacora($action);

            $requisicion->save();

            $response["response"] = "El registro ha sido rechazado";
            return Response::json( $response );
        }
        else {
            $response["password_delete"] = "La contraseña no coincide";
            return Response::json( $response  , 422 );
        }
    }



    public function autoriza(Requisicion $requisicion, Request $request)
    {
        $id= $requisicion->id;
        $requisicion->estado_requisicion_id = 4;
        $requisicion->save();

        return view("requisiciones.index");
    }



    public function getJson(Request $params)
    {
        $api_Result = array();
        // Create a mapping of our query fields in the order that will be shown in datatable.
        $columnsMapping = array("req.fecha_requisicion", "emp.emp_nombres", "emp.emp_apellidos",
            "req.monto", "erq.estado_requisicion");

        // Initialize query (get all)

        $api_logsQueriable = DB::table('requisicion');
        $api_Result['recordsTotal'] = $api_logsQueriable->count();

        $query = "SELECT req.id as id, req.no_requisicion as no_requisicion, DATE_FORMAT(req.fecha_requisicion, '%d-%m-%Y') as fecha, CONCAT(emp.emp_nombres,' ',emp.emp_apellidos) as empleado, req.pagar_a as pagar_a,
        req.monto as monto, erq.estado_requisicion as estado
        FROM requisicion req 
        INNER JOIN empleados emp ON req.empleado_solicita_id=emp.id
        INNER JOIN estado_requisicion erq ON req.estado_requisicion_id=erq.id ";

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
