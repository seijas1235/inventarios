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
use App\bg_combustible;
use App\empleado;
use Illuminate\Support\Facades\Input;

class BGCombustibleController extends Controller
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
        return view("bg_combustibles.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $empleados = empleado::all();
        return view("bg_combustibles.create" , compact( "empleados"));
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
        $data["precio_unitario"]= $data["monto"]/$data["galones"];

        $bg_combustible = bg_combustible::create($data);

        $action="Combustible de BG creado, código ".$bg_combustible->id;
        $bitacora = HomeController::bitacora($action);

        return Response::json($bg_combustible);
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
    public function edit(bg_combustible $bg_combustible)
    {
        $query = "SELECT * FROM bg_combustible WHERE id=".$bg_combustible->id."";
        $fieldsArray = DB::select($query);

        $empleados = empleado::all();

        return view("bg_combustibles.edit" , compact( "empleados","bg_combustible","fieldsarray"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function update(bg_combustible $bg_combustible, Request $request)
    {
        Response::json( $this->updateBGCombustible($bg_combustible , $request->all()));
        return redirect('/bg_combustibles');
    }

    public function updateBGCombustible(bg_combustible $bg_combustible, array $data )
    {
        $action="Registro de gasto de salario Editado, código ".$bg_combustible->id."; datos anteriores: ".$bg_combustible->conductor_id.",".$bg_combustible->monto.",".$bg_combustible->observaciones.",".$bg_combustible->fecha_corte.",".$bg_combustible->codigo_corte.",".$bg_combustible->no_vale.", ".$bg_combustible->galones."; datos nuevos ".$data["conductor_id"].", ".$data["monto"].", ".$data["observaciones"].", ".$data["fecha_corte"].",".$data["codigo_corte"].",".$data["no_vale"].",".$data["galones"]."";
    $bitacora = HomeController::bitacora($action);

        $bg_combustible->fecha_corte = $data["fecha_corte"];
        $bg_combustible->codigo_corte = $data["codigo_corte"];
        $bg_combustible->no_vale = $data["no_vale"];
        $bg_combustible->conductor_id = $data["conductor_id"];
        $bg_combustible->monto = $data["monto"];
        $bg_combustible->galones = $data["galones"];
        $bg_combustible->precio_unitario = $data["monto"]/$data["galones"];
        $bg_combustible->observaciones = $data["observaciones"];
        $bg_combustible->user_id = Auth::user()->id;
        $bg_combustible->save();

        return $bg_combustible;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(bg_combustible $bg_combustible, Request $request)
    {
         $user1= Auth::user()->password;

        if ($request["password_delete"] == "")
        {
            $response["password_delete"]  = "La contraseña es requerida";
            return Response::json( $response  , 422 );
        }
        else if( password_verify( $request["password_delete"] , $user1))
        {
            $action="Registro de combustible para BG Borrado, codigo ".$bg_combustible->id." y datos ".$bg_combustible->fecha_corte.",".$bg_combustible->codigo_corte.",".$bg_combustible->monto.",".$bg_combustible->observaciones.",".$bg_combustible->no_vale.",".$bg_combustible->galones.",".$bg_combustible->user_id."";
            $bitacora = HomeController::bitacora($action);

            $bg_combustible->delete();

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
        $columnsMapping = array("bs.id", "bs.fecha_corte", "bs.no_vale", "emp.emp_nombres", "emp.emp_apellidos", "bs.monto", "bs.observaciones", "bs.galones");

        // Initialize query (get all)

        $api_logsQueriable = DB::table('bg_combustible');
        $api_Result['recordsTotal'] = $api_logsQueriable->count();

        $query = "SELECT bs.id as id, bs.fecha_corte as fecha_corte, bs.no_vale as no_vale, 
        CONCAT(emp.emp_nombres,' ',emp.emp_apellidos) as conductor, bs.monto as monto, bs.observaciones as obs, bs.galones as galones
        FROM bg_combustible bs
        INNER JOIN empleados emp ON bs.conductor_id=emp.id";

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
