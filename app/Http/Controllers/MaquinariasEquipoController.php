<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\MaquinariaEquipo;
use App\User;

class MaquinariasEquipoController extends Controller
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
        return view("maquinariaequipo.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $maquinariaequipo = MaquinariaEquipo::create($data);

        return Response::json($maquinariaequipo);
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
    public function edit(MaquinariaEquipo $maquinariaequipo)
    {
        $query = "SELECT * FROM maquinarias_y_equipo WHERE id=".$maquinariaequipo->id."";
        $fieldsArray = DB::select($query);
        return view('maquinariaequipo.edit', compact('maquinariaequipo', 'fieldsArray' ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MaquinariaEquipo $maquinariaequipo, Request $request)
    {
        Response::json( $this->updateMaquinariaEquipo($maquinariaequipo , $request->all()));
        return redirect('/maquinarias_equipo');
    }


    public function updateMaquinariaEquipo(MaquinariaEquipo $maquinariaequipo, array $data )
    {
        $id= $maquinariaequipo->id;
        $maquinariaequipo->nombre = $data["nombre"];
        $maquinariaequipo->marca = $data["marca"];
        $maquinariaequipo->labadas_limite= $data["labadas_limite"];
        $maquinariaequipo->fecha_adquisicion = $data["fecha_adquisicion"];
        $maquinariaequipo->precio_coste = $data["precio_coste"];
        $maquinariaequipo->save();

        return $maquinariaequipo;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(MaquinariaEquipo $maquinariaequipo, Request $request)
    {
        $user1= Auth::user()->password;

        if ($request["password_delete"] == "")
        {
            $response["password_delete"]  = "La contraseña es requerida";
            return Response::json( $response  , 422 );
        }
        else if( password_verify( $request["password_delete"] , $user1))
        {
            $id= $maquinariaequipo->id;
            $maquinariaequipo->delete();
            
            $response["response"] = "el equipo se ha dado de baja";
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
        $columnsMapping = array("id", "placa");

        // Initialize query (get all)

        $api_logsQueriable = DB::table('maquinarias_y_equipos');
        $api_Result['recordsTotal'] = $api_logsQueriable->count();

        $query = "SELECT * FROM maquinarias_y_equipos";

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


