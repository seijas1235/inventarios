<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Cuenta;
use App\Banco;
use App\User;
use App\Tipo_Cuenta;

class CuentasController extends Controller
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
        return view("cuentas.index");
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
        $tipos_cuenta = Tipo_Cuenta::all();
        $bancos = Banco::where("id",">",1)->get();

        return view("cuentas.create" , compact( "user","today", "tipos_cuenta", "bancos"));
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
        $cuentas = Cuenta::create($data);

        $action="Cuenta bancaria creada, código ".$cuentas->id;
        $bitacora = HomeController::bitacora($action);

        return Response::json($cuentas);
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
    public function edit(Cuenta $cuenta)
    {
        $query = "SELECT * FROM cuenta WHERE id=".$cuenta->id."";
        $fieldsArray = DB::select($query);

        $user = Auth::user()->id;
        $today = date("Y/m/d");
        $tipos_cuenta = Tipo_Cuenta::all();
        $bancos = Banco::where("id",">",1)->get();

        return view('cuentas.edit', compact("user","today", "tipos_cuenta", "bancos", "fieldsArray", "cuenta"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Cuenta $cuenta, Request $request)
    {
        Response::json( $this->updateCuenta($cuenta , $request->all()));
        return redirect('/cuentas');
    }


    public function updateCuenta(Cuenta $cuenta, array $data )
    {
        $action="Cuenta Editada, código ".$cuenta->id."; datos anteriores: ".$cuenta->no_cuenta.",".$cuenta->banco_id.",".$cuenta->tipo_cuenta_id.",".$cuenta->nombre_cuenta." ; datos nuevos: ".$data["no_cuenta"].",".$data["banco_id"].",".$data["tipo_cuenta_id"].",".$data["nombre_cuenta"]."";
        $bitacora = HomeController::bitacora($action);

        $id= $cuenta->id;
        $cuenta->no_cuenta = $data["no_cuenta"];
        $cuenta->nombre_cuenta = $data["nombre_cuenta"];
        $cuenta->banco_id = $data["banco_id"];
        $cuenta->tipo_cuenta_id = $data["tipo_cuenta_id"];
        $cuenta->save();

        return $cuenta;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cuenta $cuenta, Request $request)
    {
        $user1= Auth::user()->password;

        if ($request["password_delete"] == "")
        {
            $response["password_delete"]  = "La contraseña es requerida";
            return Response::json( $response  , 422 );
        }
        else if( password_verify( $request["password_delete"] , $user1))
        {
            $id= $cuenta->id;

            $action="Cuenta Borrada, código ".$cuenta->id."";
            $bitacora = HomeController::bitacora($action);

            $cuenta->delete();
            
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
        $columnsMapping = array("cta.id", "cta.no_cuenta", "ban.nombre", "tc.tipo_cuenta");

        // Initialize query (get all)

        $api_logsQueriable = DB::table('cuenta');
        $api_Result['recordsTotal'] = $api_logsQueriable->count();

        $query = 'SELECT cta.id as id, cta.no_cuenta as no_cuenta, cta.nombre_cuenta as nombre, ban.nombre as bancos, tc.tipo_cuenta as tipocuenta
        FROM cuenta cta
        INNER JOIN banco ban ON cta.banco_id=ban.id
        INNER JOIN tipo_cuenta tc ON tc.id=cta.tipo_cuenta_id ';

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
