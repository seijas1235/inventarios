<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\cuenta_contable;
use App\estacion_servicio;
use App\User;
use App\tipo_cuenta_contable;

class CuentaContableController extends Controller
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
        return view("cuentas_contables.index");
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
        $tipos_cuenta_contable = tipo_cuenta_contable::all();
        $estaciones = estacion_servicio::all();

        return view("cuentas_contables.create" , compact( "user","today", "tipos_cuenta_contable", "estaciones"));
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
        $cuentasc = cuenta_contable::create($data);

        $action="Cuenta contable creada, código ".$cuentasc->id;
        $bitacora = HomeController::bitacora($action);

        return Response::json($cuentasc);
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
    public function edit(cuenta_Contable $cuentac)
    {
        $query = "SELECT * FROM cuenta_contable WHERE id=".$cuentac->id."";
        $fieldsArray = DB::select($query);

        $user = Auth::user()->id;
        $today = date("Y/m/d");
        $tipos_cuenta_contable = tipo_cuenta_contable::all();
        $estaciones = estacion_servicio::all();

        return view('cuentas_contables.edit', compact("user","today", "tipos_cuenta_contable", "fieldsArray", "cuentac", "estaciones"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(cuenta_Contable $cuentac, Request $request)
    {
        Response::json( $this->updateCuentaC($cuentac , $request->all()));
        return redirect('/cuentas_contables');
    }


    public function updateCuentaC(cuenta_contable $cuentac, array $data )
    {
        $action="Cuenta Contable Editada, código ".$cuentac->id."; datos anteriores: ".$cuentac->codigo.",".$cuentac->descripcion.",".$cuentac->tipo_cc_id." ; datos nuevos: ".$data["codigo"].",".$data["descripcion"].",".$data["tipo_cc_id"]."";
        $bitacora = HomeController::bitacora($action);

        $id= $cuentac->id;
        $cuentac->codigo = $data["codigo"];
        $cuentac->descripcion = $data["descripcion"];
        $cuentac->tipo_cc_id = $data["tipo_cc_id"];
        $cuentac->save();

        return $cuentac;
    }


    public function destroy(cuenta_Contable $cuentac, Request $request)
    {
        $user1= Auth::user()->password;

        if ($request["password_delete"] == "")
        {
            $response["password_delete"]  = "La contraseña es requerida";
            return Response::json( $response  , 422 );
        }
        else if( password_verify( $request["password_delete"] , $user1))
        {
            $id= $cuentac->id;

            $action="Cuenta Contable Borrada, código ".$cuentac->id."";
            $bitacora = HomeController::bitacora($action);

            $cuentac->delete();
            
            $response["response"] = "El registro ha sido borrado";
            return Response::json( $response );
        }
        else {
            $response["password_delete"] = "La contraseña no coincide";
            return Response::json( $response  , 422 );
        }    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getJson(Request $params)
    {
        $api_Result = array();
        // Create a mapping of our query fields in the order that will be shown in datatable.
        $columnsMapping = array("cc.id", "cc.codigo", "cc.descipcion", "tipo_cuenta");

        // Initialize query (get all)

        $api_logsQueriable = DB::table('cuenta_contable');
        $api_Result['recordsTotal'] = $api_logsQueriable->count();

        $query = 'SELECT cc.id, cc.codigo, cc.descripcion, tcc.tipo_cuenta_contable as tipo_cuenta
        FROM cuenta_contable cc
        INNER JOIN tipo_cuenta_contable tcc ON cc.tipo_cc_id=tcc.id';

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
        $query = $query . $condition . $where;

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
