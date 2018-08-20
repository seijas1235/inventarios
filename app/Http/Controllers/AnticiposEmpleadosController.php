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
use App\anticipo_empleado;
use App\estado_cuenta_empleado;
use App\empleado;
use Illuminate\Support\Facades\Input;

class AnticiposEmpleadosController extends Controller
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
        return view("anticipos.index");
    }

    public function index_abonos()
    {
        return view("anticipos.index_abonos");
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
        $empleados = empleado::all();
        return view("anticipos.create" , compact( "user","today","empleados"));
    }

    public function create_abonos()
    {
        $user = Auth::user()->id;
        $today = date("Y/m/d");
        $empleados = empleado::all();
        return view("anticipos.create_abonos" , compact( "user","today","empleados"));
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
        $data["fecha_corte"]=Carbon::createFromFormat('Y-m-d', $data["fecha_corte"]);
        $data["estado"] = 1;

        $sal = estado_cuenta_empleado::where("estado", 1)->where("empleado_id",$data["empleado_id"])->orderBy('id', 'desc')->get()->first();

        if ($sal){
            $dataec["saldo"] = $sal->saldo + $data["monto"];
        } else {
            $dataec["saldo"] = $data["monto"];
        }

        $dataec["user_id"] = Auth::user()->id;
        $dataec["empleado_id"]=$data["empleado_id"];
        $dataec["fecha_transaccion"]=$data["fecha_corte"];
        $dataec["documento"]=$data["documento"];
        $dataec["no_documento"]=$data["no_documento"];
        $dataec["cargos"] = $data["monto"];
        $dataec["abonos"] = 0;
        $dataec["descripcion"] = "Cargo por Anticipo de Dinero";
        $dataec["estado"] = 1;

        $estado_emp1 = estado_cuenta_empleado::create($dataec);
        $anticipo = anticipo_empleado::create($data);

        $action="Anticipo de empleados creado, código ".$anticipo->id;
        $bitacora = HomeController::bitacora($action);

        $action="Se creo un cargo en cuenta de empleados creado, código ".$estado_emp1->id;
        $bitacora = HomeController::bitacora($action);

        return Response::json($anticipo);
    }


    public function store_abonos(Request $request)
    {

        $data = $request->all();

        $sal = estado_cuenta_empleado::where("estado", 1)->where("empleado_id",$data["empleado_id"])->orderBy('id', 'desc')->get()->first();
        
        $data["user_id"] = Auth::user()->id;
        $data["fecha_transaccion"]=Carbon::createFromFormat('Y-m-d', $data["fecha_transaccion"]);
        $data["cargos"] = 0;
        $data["abonos"] = $data["monto"];
        $data["saldo"] = $sal->saldo - $data["monto"];
        $data["estado"] = 1;

        $estado_emp = estado_cuenta_empleado::create($data);

        $action="Abono a cuenta de empleado creado, código ".$estado_emp->id;
        $bitacora = HomeController::bitacora($action);

        return Response::json($estado_emp);
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
    public function edit(anticipo_empleado $anticipo)
    {
        $query = "SELECT * FROM anticipo_empleados WHERE id=".$anticipo->id."";
        $fieldsArray = DB::select($query);

        $empleados = empleado::all();

        return view('anticipos.edit', compact('fieldsArray', 'empleados', 'anticipo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(anticipo_empleado $anticipo, Request $request)
    {
       Response::json( $this->updateAnticipo($anticipo , $request->all()));
       return redirect('/anticipos');
   }

   public function updateAnticipo(anticipo_empleado $anticipo, array $data )
   {
    $action="Anticipo a empleado Editado, código ".$anticipo->id."; datos anteriores: ".$anticipo->empleado_id.",".$anticipo->monto.",".$anticipo->observaciones.",".$anticipo->fecha_corte.",".$anticipo->codigo_corte."; datos nuevos ".$data["empleado_id"].", ".$data["monto"].", ".$data["observaciones"].", ".$data["fecha_corte"].",".$data["codigo_corte"]."";
    $bitacora = HomeController::bitacora($action);

    $anticipo->empleado_id = $data["empleado_id"];
    $anticipo->monto = $data["monto"];
    $anticipo->observaciones = $data["observaciones"];
    $anticipo->documento = $data["documento"];
    $anticipo->no_documento = $data["no_documento"];
    $anticipo->fecha_corte = $data["fecha_corte"];
    $anticipo->codigo_corte = $data["codigo_corte"];
    $anticipo->user_id = Auth::user()->id;
    $anticipo->save();
    return $anticipo;
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(anticipo_empleado $anticipo, Request $request)
    {
        $user1= Auth::user()->password;

        if ($request["password_delete"] == "")
        {
            $response["password_delete"]  = "La contraseña es requerida";
            return Response::json( $response  , 422 );
        }
        else if( password_verify( $request["password_delete"] , $user1))
        {
            $action="Anticipo a Empleados Borrado, codigo ".$anticipo->id." y datos ".$anticipo->fecha_corte.",".$anticipo->empleado_id.",".$anticipo->monto.",".$anticipo->observaciones.",".$anticipo->user_id."";
            $bitacora = HomeController::bitacora($action);

            $anticipo->delete();

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
        $columnsMapping = array("ae.id", "ae.fecha_corte", "em.emp_nombres", "em.emp_apellidos", "ae.monto", "ae.observaciones");

        // Initialize query (get all)

        $api_logsQueriable = DB::table('anticipo_empleados');
        $api_Result['recordsTotal'] = $api_logsQueriable->count();

        $query = "SELECT ae.id as id, DATE_FORMAT(ae.fecha_corte, '%d-%m-%Y') as fecha, CONCAT(em.emp_nombres,' ',em.emp_apellidos) as empleado, 
        ae.monto as monto, ae.observaciones as obs
        FROM anticipo_empleados ae
        INNER JOIN empleados em ON ae.empleado_id=em.id";

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


    public function getJson_abonos(Request $params)
    {
        $api_Result = array();
        // Create a mapping of our query fields in the order that will be shown in datatable.
        $columnsMapping = array("ece.id", "ece.fecha_transaccion", "emp.emp_nombres", "emp_apellidos", "ece.cargos", "ece.abonos", "ece.saldo");

        // Initialize query (get all)

        $api_logsQueriable = DB::table('estado_cuenta_empleado');
        $api_Result['recordsTotal'] = $api_logsQueriable->count();

        $query = "SELECT ece.id as no, ece.fecha_transaccion as fecha, CONCAT(emp_nombres,' ',emp_apellidos) as empleado, ece.cargos as cargos, ece.abonos as abonos, ece.saldo as saldo  FROM estado_cuenta_empleado ece INNER JOIN empleados emp ON ece.empleado_id=emp.id";

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
        $condition = " WHERE ece.estado = 1 ";
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
