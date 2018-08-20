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
use App\bg_viatico;
use App\empleado;
use Illuminate\Support\Facades\Input;

class BGViaticosController extends Controller
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
        return view("bg_viaticos.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $empleados = empleado::all();
        return view("bg_viaticos.create" , compact( "empleados"));
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

        $bg_viatico = bg_viatico::create($data);

        $action="Viatico de BG creado, código ".$bg_viatico->id;
        $bitacora = HomeController::bitacora($action);

        return Response::json($bg_viatico);
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
    public function edit(bg_viatico $bg_viatico)
    {
        $query = "SELECT * FROM bg_viaticos WHERE id=".$bg_viatico->id."";
        $fieldsArray = DB::select($query);

        $empleados = empleado::all();

        return view("bg_viaticos.edit" , compact( "empleados","bg_viatico","fieldsarray"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(bg_viatico $bg_viatico, Request $request)
    {
        Response::json( $this->updateBGViatico($bg_viatico , $request->all()));
        return redirect('/bg_viaticos');
    }

    public function updateBGViatico(bg_viatico $bg_viatico, array $data )
    {
        $action="Registro de gasto de viatico Editado, código ".$bg_viatico->id."; datos anteriores: ".$bg_viatico->conductor_id.",".$bg_viatico->monto.",".$bg_viatico->observaciones.",".$bg_viatico->fecha_corte.",".$bg_viatico->codigo_corte.",".$bg_viatico->no_vale."; datos nuevos ".$data["conductor_id"].", ".$data["monto"].", ".$data["observaciones"].", ".$data["fecha_corte"].",".$data["codigo_corte"].",".$data["no_vale"]."";
    $bitacora = HomeController::bitacora($action);

        $bg_viatico->fecha_corte = $data["fecha_corte"];
        $bg_viatico->codigo_corte = $data["codigo_corte"];
        $bg_viatico->no_vale = $data["no_vale"];
        $bg_viatico->conductor_id = $data["conductor_id"];
        $bg_viatico->monto = $data["monto"];
        $bg_viatico->observaciones = $data["observaciones"];
        $bg_viatico->user_id = Auth::user()->id;
        $bg_viatico->save();

        return $bg_viatico;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(bg_viatico $bg_viatico, Request $request)
    {
         $user1= Auth::user()->password;

        if ($request["password_delete"] == "")
        {
            $response["password_delete"]  = "La contraseña es requerida";
            return Response::json( $response  , 422 );
        }
        else if( password_verify( $request["password_delete"] , $user1))
        {
            $action="Registro de viaticos para BG Borrado, codigo ".$bg_viatico->id." y datos ".$bg_viatico->fecha_corte.",".$bg_viatico->codigo_corte.",".$bg_viatico->monto.",".$bg_viatico->observaciones.",".$bg_viatico->no_vale.",".$bg_viatico->user_id."";
            $bitacora = HomeController::bitacora($action);

            $bg_viatico->delete();

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
        $columnsMapping = array("bv.id", "bv.fecha_corte", "bv.no_vale", "emp.emp_nombres", "emp.emp_apellidos", "bv.monto", "bv.observaciones");

        // Initialize query (get all)

        $api_logsQueriable = DB::table('bg_viaticos');
        $api_Result['recordsTotal'] = $api_logsQueriable->count();

        $query = "SELECT bv.id as id, bv.fecha_corte as fecha_corte, bv.no_vale as no_vale, 
        CONCAT(emp.emp_nombres,' ',emp.emp_apellidos) as conductor, bv.monto as monto, bv.observaciones as obs
        FROM bg_viaticos bv
        INNER JOIN empleados emp ON bv.conductor_id=emp.id";

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
