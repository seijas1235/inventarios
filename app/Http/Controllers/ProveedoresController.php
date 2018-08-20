<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Proveedor;
use App\User;

class ProveedoresController extends Controller
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
        return view("proveedores.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user()->id;
        return view("proveedores.create" , compact( "user"));
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
        $proveedor = Proveedor::create($data);

        $action="Proveedor ha sido Creado, con código ".$proveedor->id;
        $bitacora = HomeController::bitacora($action);

        return Response::json($proveedor);
    }


    public function edit(Proveedor $proveedor)
    {
        $query = "SELECT * FROM proveedores WHERE id = ".$proveedor->id." ";
        $fieldsArray = DB::select($query);
        return view('proveedores.edit', compact('proveedor', 'fieldsArray'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Proveedor $proveedor, Request $request)
    {
        Response::json( $this->updateProveedor($proveedor , $request->all()));
        return redirect('/proveedores');
    }

    public function updateProveedor(Proveedor $proveedor, array $data )
    {
        $action="Proveedor Editado, codigo ".$proveedor->id."; datos anteriores: ".$proveedor->nit.",".$proveedor->nombre_comercial.",".$proveedor->representante.",".$proveedor->telefonos.",".$proveedor->direccion."; datos nuevos: ".$data["nit"].",".$data["nombre_comercial"].",".$data["representante"].",".$data["telefonos"].",".$data["direccion"]."";
        $bitacora = HomeController::bitacora($action);

        $id= $proveedor->id;
        $proveedor->nit = $data["nit"];
        $proveedor->nombre_comercial = $data["nombre_comercial"];
        $proveedor->representante = $data["representante"];
        $proveedor->telefonos = $data["telefonos"];
        $proveedor->cuentac = $data["cuentac"];
        $proveedor->direccion = $data["direccion"];
        $proveedor->save();

        return $proveedor;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Proveedor $proveedor, Request $request)
    {
        $user1= Auth::user()->password;

        if ($request["password_delete"] == "")
        {
            $response["password_delete"]  = "La contraseña es requerida";
            return Response::json( $response  , 422 );
        }
        else if( password_verify( $request["password_delete"] , $user1))
        {
            $action="Proveedor Borrado, codigo ".$proveedor->id." y datos ".$proveedor->nit.",".$proveedor->nombre_comercial.",".$proveedor->representante.",".$proveedor->telefonos.",".$proveedor->direccion."";
            $bitacora = HomeController::bitacora($action);

            $proveedor->delete();

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
        $columnsMapping = array("nit", "nombre_comercial", "representante", "telefonos", "direccion");

        // Initialize query (get all)

        $api_logsQueriable = DB::table('proveedores');
        $api_Result['recordsTotal'] = $api_logsQueriable->count();

        $query = 'SELECT * FROM proveedores ';

        $where = "";

        if (isset($params->search['value']) && !empty($params->search['value'])){

            foreach ($columnsMapping as $column) {
                if (strlen($where) == 0) {
                    $where .=" where (".$column." like  '%".$params->search['value']."%' ";
                } else {
                    $where .=" or ".$column." like  '%".$params->search['value']."%' ";
                }

            }
            $where .= ') ';
        }

        $query = $query . $where;

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