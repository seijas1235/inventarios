<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\empleado;
use App\estado_empleado;
use App\cargo_empleado;
use App\user_empleado;
use App\User;
use Illuminate\Support\Facades\Input;

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
        return view("empleados.index");
    }

    
    public function dpiDisponible()
    {
        $dato = Input::get("emp_cui");
        $query = Empleado::whereRaw('LOWER(trim(emp_cui)) = ? ', array(strtolower(trim($dato))))->get();
        $contador = count($query);
        if ($contador == 0)
        {
            return 'false';
        }
        else
        {
            return 'true';
        }
    }

    
    public function dpiDisponibleEdit()
    {
        $dato = Input::get("emp_cui");
        $id = Input::get("id");
        $query = Empleado::whereRaw('LOWER(trim(emp_cui)) = ? and id != ?', array(strtolower(trim($dato)), $id))->get();
        $contador = count($query);
        if ($contador == 0)
        {
            return 'false';
        }
        else
        {
            return 'true';
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user()->id;
        $cargo_empleado = cargo_empleado::all();
        $today = date("Y/m/d");
        $usuario = DB::table('users')
        ->select('users.id','users.email')
        ->leftJoin('users_empleados','users.id','=','users_empleados.user_id')
        ->wherenull('users_empleados.user_id')
        ->get();


        return view("empleados.create" , compact( "user","today","cargo_empleado","tienda","usuario"));
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
        $data["estado_empleado_id"] =1;
        $data["user_id"] = Auth::user()->id;
        $empleado = Empleado::create($data);

        $action="Empleado Creado, codigo ".$empleado->id;
        $bitacora = HomeController::bitacora($action);

        if ($data["asig_usuario_id"] != null)
        {
            $empleado_user["empleado_id"] = $empleado->id;
            $empleado_user["user_id"] = $data["asig_usuario_id"];
            
            user_empleado::create($empleado_user);
        }

        return Response::json($empleado);
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
    public function edit(Empleado $empleado)
    {
        $user = Auth::user()->id;
        $cargo_empleado = cargo_empleado::all();
        $today = date("Y/m/d");
        $query = "SELECT * FROM empleados WHERE id=".$empleado->id."";

        $usuario = DB::table('users')
        ->select('users.id','users.email')
        ->leftJoin('users_empleados','users.id','=','users_empleados.user_id')
        ->wherenull('users_empleados.user_id')
        ->get();

        $fieldsArray = DB::select($query);

        return view('empleados.edit', compact('empleado', 'fieldsArray', 'user','cargo_empleado','today','usuario'));
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
        $action="Empleado Editado, codigo ".$empleado->id."; datos anteriores: ".$empleado->emp_cui.",".$empleado->emp_nombres.",".$empleado->emp_apellidos.",".$empleado->emp_telefonos.",".$empleado->emp_direccion.",".$empleado->emp_cargo_empleado_id."; datos nuevos: ".$data["emp_cui"].",".$data["emp_nombres"].",".$data["emp_apellidos"].",".$data["emp_telefonos"].",".$data["emp_direccion"].",".$data["cargo_empleado_id"]."";
        $bitacora = HomeController::bitacora($action);

        $id= $empleado->id;
        $empleado->emp_cui = $data["emp_cui"];
        $empleado->emp_nombres = $data["emp_nombres"];
        $empleado->emp_apellidos = $data["emp_apellidos"];
        $empleado->emp_telefonos = $data["emp_telefonos"];
        $empleado->emp_direccion = $data["emp_direccion"];
        $empleado->cargo_empleado_id = $data["cargo_empleado_id"];
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
            $empleado->estado_empleado_id = 2;

            $action="Empleado Borrado, c贸digo de Empleado ".$empleado->id." con estado ".$empleado->estado_empleado_id." a estado 2";
            $bitacora = HomeController::bitacora($action);

            $empleado->save();

            $response["response"] = "El registro ha sido borrado";
            return Response::json( $response );
        }
        else {
            $response["password_delete"] = "La contraseña no coincide";
            return Response::json( $response  , 422 );
        }
    }


    public function active(Empleado $empleado, Request $request)
    {
        $user1= Auth::user()->password;

        if ($request["password_delete_a"] == "")
        {
            $response["password_delete_a"]  = "La contraseña es requerida";
            return Response::json( $response  , 422 );
        }
        else if( password_verify( $request["password_delete_a"] , $user1))
        {
            $id= $empleado->id;
            $empleado->estado_empleado_id = 1;

            $action="Empleado Activado, código de cliente ".$empleado->id." con estado ".$empleado->estado_empleado_id." a estado 1";
            $bitacora = HomeController::bitacora($action);

            $empleado->save();
            
            $response["response"] = "El registro ha sido activado";
            return Response::json( $response );
        }
        else {
            $response["password_delete_a"] = "La contraseña no coincide";
            return Response::json( $response  , 422 );
        }    
    }



    public function getJson(Request $params)
    {
        $api_Result = array();
        // Create a mapping of our query fields in the order that will be shown in datatable.
        $columnsMapping = array("emp_cui", "emp_nombres","emp_apellidos","emp_telefonos","emp_direccion","ce.cargo_empleado", "estado_empleado");

        // Initialize query (get all)

        $api_logsQueriable = DB::table('empleados');
        $api_Result['recordsTotal'] = $api_logsQueriable->count();

        $query = 'SELECT emp.id, emp.emp_cui, emp.emp_nombres, emp.emp_apellidos, emp.emp_telefonos, emp.emp_direccion, ce.cargo_empleado, estado_empleado
        FROM empleados emp
        INNER JOIN cargos_empleado ce ON emp.cargo_empleado_id=ce.id inner join estados_empleado ON emp.estado_empleado_id=estados_empleado.id ';

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