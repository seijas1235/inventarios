<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Camion;
use App\User;

class CamionesController extends Controller
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
        return view("camiones.index");
    }

    public function getJson(Request $params)
    {
        $api_Result = array();
        // Create a mapping of our query fields in the order that will be shown in datatable.
        $columnsMapping = array("id", "nombre", "placa", "estado_id");

        // Initialize query (get all)

        $api_logsQueriable = DB::table('camion');
        $api_Result['recordsTotal'] = $api_logsQueriable->count();

        $query = 'SELECT id, nombre, placa, estado_id from camion ';

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



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user()->id;
        return view("camiones.create" , compact( "user"));
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
        $data["estado_id"] = 1;
        $camion = Camion::create($data);

        $action="Camion ha sido Creado, con código ".$camion->id;
        $bitacora = HomeController::bitacora($action);

        return Response::json($camion);
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
    public function edit(Camion $camion)
    {
        $query = "SELECT * FROM camion WHERE id = ".$camion->id." ";
        $fieldsArray = DB::select($query);
        return view('camiones.edit', compact('camion', 'fieldsArray'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Camion $camion, Request $request)
    {
        Response::json( $this->updateCamion($camion , $request->all()));
        return redirect('/camiones');
    }

    public function updateCamion(Camion $camion, array $data )
    {
        $action="Camion Editado, código ".$camion->id."; datos anteriores: ".$camion->nombre;
        $bitacora = HomeController::bitacora($action);

        $camion->nombre = $data["nombre"];
        $camion->placa = $data["placa"];
        $camion->save();

        return $camion;
    }


    public function destroy(Camion $camion, Request $request)
    {
        $user1= Auth::user()->password;

        if ($request["password_delete"] == "")
        {
            $response["password_delete"]  = "La contraseña es requerida";
            return Response::json( $response  , 422 );
        }
        else if( password_verify( $request["password_delete"] , $user1))
        {
            $action="Camion Borrado, codigo ".$camion->id." y datos ".$camion->nombre.",".$camion->placa."";
            $bitacora = HomeController::bitacora($action);

            $camion->estado_id = 2;
            $camion->save();

            $response["response"] = "El registro ha sido borrado";
            return Response::json( $response );
        }
        else {
            $response["password_delete"] = "La contraseña no coincide";
            return Response::json( $response  , 422 );
        }
    }
}
