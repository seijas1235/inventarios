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
use App\bg_salario;
use App\empleado;
use Illuminate\Support\Facades\Input;


class BGSalariosController extends Controller
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
        return view("bg_salarios.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $empleados = empleado::all();
        return view("bg_salarios.create" , compact( "empleados"));
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

        $bg_salario = bg_salario::create($data);

        $action="Salario de BG creado, código ".$bg_salario->id;
        $bitacora = HomeController::bitacora($action);

        return Response::json($bg_salario);
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
    public function edit(bg_salario $bg_salario)
    {
        $query = "SELECT * FROM bg_salarios WHERE id=".$bg_salario->id."";
        $fieldsArray = DB::select($query);

        $empleados = empleado::all();

        return view("bg_salarios.edit" , compact( "empleados","bg_salario","fieldsarray"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(bg_salario $bg_salario, Request $request)
    {
        Response::json( $this->updateBGSalario($bg_salario , $request->all()));
        return redirect('/bg_salarios');
    }

    public function updateBGSalario(bg_salario $bg_salario, array $data )
    {
        $action="Registro de gasto de salario Editado, código ".$bg_salario->id."; datos anteriores: ".$bg_salario->conductor_id.",".$bg_salario->monto.",".$bg_salario->observaciones.",".$bg_salario->fecha_corte.",".$bg_salario->codigo_corte.",".$bg_salario->no_vale."; datos nuevos ".$data["conductor_id"].", ".$data["monto"].", ".$data["observaciones"].", ".$data["fecha_corte"].",".$data["codigo_corte"].",".$data["no_vale"]."";
    $bitacora = HomeController::bitacora($action);

        $bg_salario->fecha_corte = $data["fecha_corte"];
        $bg_salario->codigo_corte = $data["codigo_corte"];
        $bg_salario->no_vale = $data["no_vale"];
        $bg_salario->conductor_id = $data["conductor_id"];
        $bg_salario->monto = $data["monto"];
        $bg_salario->observaciones = $data["observaciones"];
        $bg_salario->user_id = Auth::user()->id;
        $bg_salario->save();

        return $bg_salario;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(bg_salario $bg_salario, Request $request)
    {
         $user1= Auth::user()->password;

        if ($request["password_delete"] == "")
        {
            $response["password_delete"]  = "La contraseña es requerida";
            return Response::json( $response  , 422 );
        }
        else if( password_verify( $request["password_delete"] , $user1))
        {
            $action="Registro de salarios para BG Borrado, codigo ".$bg_salario->id." y datos ".$bg_salario->fecha_corte.",".$bg_salario->codigo_corte.",".$bg_salario->monto.",".$bg_salario->observaciones.",".$bg_salario->no_vale.",".$bg_salario->user_id."";
            $bitacora = HomeController::bitacora($action);

            $bg_salario->delete();

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
        $columnsMapping = array("bs.id", "bs.fecha_corte", "bs.no_vale", "emp.emp_nombres", "emp.emp_apellidos", "bs.monto", "bs.observaciones");

        // Initialize query (get all)

        $api_logsQueriable = DB::table('bg_salarios');
        $api_Result['recordsTotal'] = $api_logsQueriable->count();

        $query = "SELECT bs.id as id, bs.fecha_corte as fecha_corte, bs.no_vale as no_vale, 
        CONCAT(emp.emp_nombres,' ',emp.emp_apellidos) as conductor, bs.monto as monto, bs.observaciones as obs
        FROM bg_salarios bs
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
