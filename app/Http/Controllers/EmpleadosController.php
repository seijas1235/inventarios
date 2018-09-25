<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
Use App\User;
Use App\Empleado;
Use App\Puesto;

class EmpleadosController extends Controller
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
        return view ("empleados.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $user = Auth::user()->id;
       $puestos = Puesto::all();
       return view("empleados.create" , compact( "user", "puestos"));
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
        $empleado = empleado::create($data);

        return Response::json($empleado);
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
    public function edit(Empleado $empleado)
    {
        $query = "SELECT * FROM empleados WHERE id=".$empleado->id."";
        $fieldsArray = DB::select($query);

        $puestos = Puesto::all();
        return view('empleados.edit', compact('empleado', 'fieldsArray', 'puestos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Empleado $empleado, Request $request)
    {
        Response::json( $this->updateEmpleado($empleado , $request->all()));
        return redirect('/empleados');
    }

    public function updateEmpleado(Empleado $empleado, array $data )
    {
        $id= $empleado->id;
        $empleado->nombre = $data["nombre"];
        $empleado->nit = $data["nit"];
        $empleado->telefono = $data["telefono"];
        $empleado->direccion = $data["direccion"];
        $empleado->puesto_id = $data["puesto_id"];
        $empleado->save();

        return $empleado;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Empleado $empleado, Request $request)
    {
        $user1= Auth::user()->password;

        if ($request["password_delete"] == "")
        {
            $response["password_delete"]  = "La contraseña es requerida";
            return Response::json( $response  , 422 );
        }
        else if( password_verify( $request["password_delete"] , $user1))
        {
            $id= $empleado->id;
            $empleado->delete();
            
            $response["response"] = "el Empleado ha sido eliminado";
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
        $columnsMapping = array("id", "nombre");

        // Initialize query (get all)

        $api_logsQueriable = DB::table('empleados');
        $api_Result['recordsTotal'] = $api_logsQueriable->count();

        $query = "SELECT * FROM empleados";

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