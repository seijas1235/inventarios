<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\cliente;
use App\estado_cliente;
use App\User;
use App\Tipo_Cliente;

class ClientesController extends Controller
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
        return view("clientes.index");
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
        $tipos_clientes = Tipo_Cliente::all();
        return view("clientes.create" , compact( "user","today", "tipos_clientes"));
    }


    public function bloquearCliente(cliente $cliente, Request $request) {

     $id= $cliente->id;
     $cliente->estado_cliente_id = 4;

     $action="Cliente Deshabilitado, código de cliente ".$cliente->id." con estado ".$cliente->estado_cliente_id." a estado 2";
     $bitacora = HomeController::bitacora($action);

     $cliente->save(); 

     return view("clientes.index");
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
        $data["estado_cliente_id"] =1;
        $data["user_id"] = Auth::user()->id;
        $cliente = cliente::create($data);

        $action="Cliente Creado, código ".$cliente->id;
        $bitacora = HomeController::bitacora($action);

        return Response::json($cliente);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(cliente $cliente)
    {
        $query = "SELECT * FROM clientes WHERE id=".$cliente->id."";
        $fieldsArray = DB::select($query);
        $tipos_clientes = Tipo_Cliente::all();
        return view('clientes.edit', compact('cliente', 'fieldsArray', "tipos_clientes"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(cliente $cliente, Request $request)
    {
        Response::json( $this->updateCliente($cliente , $request->all()));
        return redirect('/clientes');
    }


    public function updateCliente(cliente $cliente, array $data )
    {
        $action="Cliente Editado, código ".$cliente->id."; datos anteriores: ".$cliente->cl_nit.",".$cliente->cl_nombres.",".$cliente->cl_apellidos.",".$cliente->telefonos.",".$cliente->direccion.",".$cliente->montomaximo.",".$cliente->mail.",".$cliente->cuentac." ; datos nuevos: ".$data["cl_nit"].",".$data["cl_nombres"].",".$data["cl_apellidos"].",".$data["cl_telefonos"].",".$data["cl_montomaximo"].",".$data["cl_direccion"].",".$data["cl_mail"].",".$data["cl_cuentac"]."";
        $bitacora = HomeController::bitacora($action);

        $id= $cliente->id;
        $cliente->cl_nit = $data["cl_nit"];
        $cliente->cl_nombres = $data["cl_nombres"];
        $cliente->cl_apellidos = $data["cl_apellidos"];
        $cliente->cl_telefonos = $data["cl_telefonos"];
        $cliente->cl_direccion = $data["cl_direccion"];
        $cliente->cl_mail = $data["cl_mail"];
        $cliente->cl_cuentac = $data["cl_cuentac"];
        $cliente->cl_montomaximo = $data["cl_montomaximo"];
        $cliente->tipo_cliente_id = $data["tipo_cliente_id"];
        $cliente->save();

        return $cliente;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(cliente $cliente, Request $request)
    {
        $user1= Auth::user()->password;

        if ($request["password_delete"] == "")
        {
            $response["password_delete"]  = "La contraseña es requerida";
            return Response::json( $response  , 422 );
        }
        else if( password_verify( $request["password_delete"] , $user1))
        {
            $id= $cliente->id;
            $cliente->estado_cliente_id = 2;

            $action="Cliente Borrado, código de cliente ".$cliente->id." con estado ".$cliente->estado_cliente_id." a estado 2";
            $bitacora = HomeController::bitacora($action);

            $cliente->save();
            
            $response["response"] = "El cliente ha sido inhabilitado";
            return Response::json( $response );
        }
        else {
            $response["password_delete"] = "La contraseña no coincide";
            return Response::json( $response  , 422 );
        }    
    }




    public function active(cliente $cliente, Request $request)
    {
        $user2= Auth::user()->password;

        if ($request["password_active"] == "")
        {
            $response["password_active"]  = "La contraseña es requerida";
            return Response::json( $response  , 422 );
        }
        else if( password_verify( $request["password_active"] , $user2))
        {
            $id= $cliente->id;
            $cliente->estado_cliente_id = 1;

            $action="Cliente Activado o Desbloqueado, código de cliente ".$cliente->id." con estado ".$cliente->estado_cliente_id." a estado 1";
            $bitacora = HomeController::bitacora($action);

            $cliente->save();
            
            $response["response"] = "El cliente ha sido activado o desbloqueado de forma exitosa";
            return Response::json( $response );
        }
        else {
            $response["password_active"] = "La contraseña no coincide";
            return Response::json( $response  , 422 );
        }    
    }




    public function bloquear(cliente $cliente, Request $request)
    {
        $user1= Auth::user()->password;

        if ($request["password_bloq"] == "")
        {
            $response["password_bloq"]  = "La contraseña es requerida";
            return Response::json( $response  , 422 );
        }
        else if( password_verify( $request["password_bloq"] , $user1))
        {
            $id= $cliente->id;
            $cliente->estado_cliente_id = 4;

            $action="Cliente Bloqueado, código de cliente ".$cliente->id." con estado ".$cliente->estado_cliente_id." a estado 4";
            $bitacora = HomeController::bitacora($action);

            $cliente->save();
            
            $response["response"] = "El cliente ha sido bloqueado";
            return Response::json( $response );
        }
        else {
            $response["password_bloq"] = "La contraseña no coincide";
            return Response::json( $response  , 422 );
        }    
    }



    public function getJson(Request $params)
    {
        $api_Result = array();
        // Create a mapping of our query fields in the order that will be shown in datatable.
        $columnsMapping = array("cl_nit", "cl_nombres","cl_apellidos","cl_telefonos","cl_direccion", "estado_cliente");

        // Initialize query (get all)

        $api_logsQueriable = DB::table('clientes');
        $api_Result['recordsTotal'] = $api_logsQueriable->count();

        $query = 'SELECT clientes.id as id, cl_nit as nit, cl_nombres as nombres, cl_apellidos as apellidos, cl_telefonos as telefonos, cl_direccion as direccion, tipo_cliente, cl_montomaximo as montomax, estado_cliente FROM clientes inner join tipo_cliente ON clientes.tipo_cliente_id=tipo_cliente.id inner join estados_cliente ON estados_cliente.id=clientes.estado_cliente_id ';

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