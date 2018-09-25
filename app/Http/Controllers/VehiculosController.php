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
use App\Vehiculo;
use App\TipoVehiculo;
use App\User;

class VehiculosController extends Controller
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
        return view("vehiculos.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user()->id;
        $tipos_vehiculos = TipoVehiculo::all();
        $marcas_vehiculos = MarcaVehiculo::all();

        return view("vehiculos.create" , compact( "user", "tipos_vehiculos", "marcas_vehiculos"));
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
        $data["estado_vehiculo_id"] =1;
        $data["user_id"] = Auth::user()->id;
        $vehiculo = Vehiculo::create($data);

        return Response::json($vehiculo);
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
    public function edit(Vehiculo $vehiculo)
    {
        $query = "SELECT * FROM vehiculos WHERE id=".$vehiculo->id."";
        $fieldsArray = DB::select($query);

        $tipos_vehiculos = TipoVehiculo::all();
        $marcas_vehiculos = MarcaVehiculo::all();
        return view('vehiculos.edit', compact('vehiculo', 'fieldsArray', "tipos_vehiculos", "marcas_vehiculos"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Vehiculo $vehiculo, Request $request)
    {
        Response::json( $this->updateVehiculo($vehiculo , $request->all()));
        return redirect('/vehiculos');
    }


    public function updateVehiculo(Vehiculo $vehiculo, array $data )
    {
        $id= $vehiculo->id;
        $vehiculo->no_placa = $data["no_placa"];
        $vehiculo->caracteristicas = $data["caracteristicas"];
        $vehiculo->marca_vehiculo_id = $data["marca_vehiculo_id"];
        $vehiculo->linea = $data["linea"];
        $vehiculo->anio = $data["anio"];
        $vehiculo->ultimo_km_observado = $data["ultimo_km_observado"];
        $vehiculo->ultimo_servicio_realizado = $data["ultimo_servicio_realizado"];
        $vehiculo->tipo_vehiculo_id = $data["tipo_vehiculo_id"];
        $vehiculo->save();

        return $vehiculo;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vehiculo $vehiculo, Request $request)
    {
        $user1= Auth::user()->password;

        if ($request["password_delete"] == "")
        {
            $response["password_delete"]  = "La contraseña es requerida";
            return Response::json( $response  , 422 );
        }
        else if( password_verify( $request["password_delete"] , $user1))
        {
            $id= $vehiculo->id;
            $vehiculo->estado_vehiculo_id = 4;

            $vehiculo->save();
            
            $response["response"] = "El vehiculo se ha dado de baja";
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
        $columnsMapping = array("id", "placa", "tipo", "marca", "linea", "anio", "estado");

        // Initialize query (get all)

        $api_logsQueriable = DB::table('vehiculos');
        $api_Result['recordsTotal'] = $api_logsQueriable->count();

        $query = "SELECT veh.id as id, veh.no_placa as placa, tv.tipo_vehiculo as tipo, mv.marca_vehiculo as marca, veh.linea as linea, veh.anio as anio, ev.estado_vehiculo as estado
        FROM vehiculos veh
        INNER JOIN tipo_vehiculo tv ON veh.tipo_vehiculo_id=tv.id
        INNER JOIN marca_vehiculos mv ON veh.marca_vehiculo_id=mv.id
        INNER JOIN estado_vehiculo ev ON veh.estado_vehiculo_id=ev.id ";

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
