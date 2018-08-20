<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\medidas_tanques;
use App\empleado;
use App\User;
use Illuminate\Support\Facades\Input;

class MedidasTanquesController extends Controller
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
        return view("medidas.index");
    }


 public function Medida_Disponible()
    {
        $dato = Input::get("fecha_medida");
        $query = medidas_tanques::where("fecha_medida","=",$dato)->get();
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
        $empleados = empleado::all();
        return view("medidas.create" , compact( "empleados"));
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
        $data["estado"] = 1;
        $medidas = medidas_tanques::create($data);

        $action="Medida de tanque Creada, con codigo ".$medidas->id;
        $bitacora = HomeController::bitacora($action);

        return Response::json($medidas);
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
    public function edit(medidas_tanques $medida)
    {
        $query = "SELECT * FROM medidas_tanques WHERE id=".$medida->id."";
        $fieldsArray = DB::select($query);

        $empleados = empleado::all();
        return view("medidas.edit" , compact( "empleados", "medida", "fieldsArray"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(medidas_tanques $medida, Request $request)
    {
        Response::json( $this->updateMedida($medida , $request->all()));
        return redirect('/medidas');
    }

    public function updateMedida(medidas_tanques $medida, array $data )
    {
        $action="Registro de medida de tanque Editado, código ".$medida->id."; datos anteriores: ".$medida->empleado_id.",".$medida->med_regla_super.",".$medida->med_regla_regular.",".$medida->med_regla_diesel.",".$medida->med_tabla_super.",".$medida->med_tabla_regular.",".$medida->med_tabla_diesel."; datos nuevos ".$data["empleado_id"].", ".$data["med_regla_super"].", ".$data["med_regla_regular"].", ".$data["med_regla_diesel"].",".$data["med_tabla_super"].",".$data["med_tabla_regular"].",".$data["med_tabla_diesel"]."";
    $bitacora = HomeController::bitacora($action);

        $medida->empleado_id = $data["empleado_id"];
        $medida->fecha_medida = $data["fecha_medida"];
        $medida->med_regla_super = $data["med_regla_super"];
        $medida->med_regla_regular = $data["med_regla_regular"];
        $medida->med_regla_diesel = $data["med_regla_diesel"];
        $medida->med_tabla_super = $data["med_tabla_super"];
        $medida->med_tabla_regular = $data["med_tabla_regular"];
        $medida->med_tabla_diesel = $data["med_tabla_diesel"];
        $medida->observaciones = $data["observaciones"];
        $medida->user_id = Auth::user()->id;
        $medida->save();

        return $medida;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(medidas_tanques $medida, Request $request)
    {
        $user1= Auth::user()->password;

        if ($request["password_delete"] == "")
        {
            $response["password_delete"]  = "La contraseña es requerida";
            return Response::json( $response  , 422 );
        }
        else if( password_verify( $request["password_delete"] , $user1))
        {
            $action="Registro de medidas de tanques borrado, codigo ".$medida->id." y fecha ".$medida->fecha_medida."";
            $bitacora = HomeController::bitacora($action);

            $medida->delete();

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
        $columnsMapping = array("fecha_medida", "med_regla_super", "med_regla_regular", "med_regla_diesel", "med_tabla_super", "med_tabla_regular", "med_tabla_diesel");

        // Initialize query (get all)

        $api_logsQueriable = DB::table('medidas_tanques');
        $api_Result['recordsTotal'] = $api_logsQueriable->count();

        $query = 'SELECT * FROM medidas_tanques ';

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
        $condition = " WHERE estado = 1 ";
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
