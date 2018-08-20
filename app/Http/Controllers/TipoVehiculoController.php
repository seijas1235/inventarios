<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\tipo_vehiculo;
use App\User;

class TipoVehiculoController extends Controller
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
        return view("tipo_vehiculo.index");
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
        return view("tipo_vehiculo.create" , compact( "user","today"));
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
        $tv = tipo_vehiculo::create($data);

        $action="Tipo de Vehículo Creado, con código ".$tv->id;
        $bitacora = HomeController::bitacora($action);

        return Response::json($tv);
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
    public function edit(tipo_vehiculo $tipov)
    {
        $query = "SELECT * FROM tipo_vehiculo WHERE id=".$tipov->id."";
        $fieldsArray = DB::select($query);
        return view('tipo_vehiculo.edit', compact('tipov', 'fieldsArray'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(tipo_vehiculo $tipov, Request $request)
    {
     Response::json( $this->updateTV($tipov , $request->all()));
     return redirect('/tipo_vehiculo');
 }

 public function updateTV(tipo_vehiculo $tipov, array $data )
 {
    $action="Tipo Vehiculo editado, codigo ".$tipov->id." datos anteriores: ".$tipov->tipo_vehiculo."; datos nuevos: ".$data["tipo_vehiculo"]."";
    $bitacora = HomeController::bitacora($action);

    $id= $tipov->id;
    $tipov->tipo_vehiculo = $data["tipo_vehiculo"];
    $tipov->save();

    return $tipov;
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(tipo_vehiculo $tipov, Request $request)
    {
        $user1= Auth::user()->password;

        if ($request["password_delete"] == "")
        {
            $response["password_delete"]  = "La contraseña es requerida";
            return Response::json( $response  , 422 );
        }
        else if( password_verify( $request["password_delete"] , $user1))
        {
            $action="Tipo de Vehiculo Borrado, código ".$tipov->id." y marca ".$tipov->tipo_vehiculo."";
            $bitacora = HomeController::bitacora($action);

            $tipov->delete();

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
        $columnsMapping = array("tv.id", "tv.tipo_vehiculo","u.name","tv.created_at");

        // Initialize query (get all)

        $api_logsQueriable = DB::table('tipo_vehiculo');
        $api_Result['recordsTotal'] = $api_logsQueriable->count();

        $query = 'SELECT tv.id, tv.tipo_vehiculo, u.name, tv.created_at FROM tipo_vehiculo tv INNER JOIN users u ON u.id=tv.user_id ';

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
