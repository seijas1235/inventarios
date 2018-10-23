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
use App\Marca;
use App\User;
use App\Transmision;
use App\Cliente;
use App\Traccion;
use App\Tipo_caja;
use App\Combustible;
use App\Direccion;
use App\Linea;
use App\Color;

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
        $query = "SELECT * FROM marcas WHERE tipo_marca_id=".'1'." OR tipo_marca_id='2'";
        $marcas = DB::select($query);

        $tipos_vehiculos = TipoVehiculo::all();
        $tipos_transmision = Transmision::all();
        $clientes = Cliente::all();
        $lineas= Linea::all();
        $colores= Color::all();
        $direcciones= Direccion::all();
        $tipos_caja= Tipo_caja::all();
        $combustibles= Combustible::all();
        $tracciones= Traccion::all();

        return view("vehiculos.create" , compact("colores","lineas","combustibles","tipos_caja","direcciones","tracciones","tipos_vehiculos", "marcas","tipos_transmision", "clientes"));
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
        $vehiculo = Vehiculo::create($data);


        return Response::json($vehiculo);
    }

    public function store2(Request $request)
    {
        $data = $request->all();
        $vehiculo = Vehiculo::create($data);

        return back();
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

        $query2 = "SELECT * FROM marcas WHERE tipo_marca_id=".'1'." OR tipo_marca_id='2'";
        $marcas = DB::select($query2);
        if($vehiculo->transmision_id==1){
            $query4= "SELECT * from tipos_caja limit 2";
        }else{
        $query4= "SELECT * from tipos_caja order by id desc limit 1";
        }

        $tipos_vehiculos = TipoVehiculo::all();
        $tipos_transmision = Transmision::all();
        $clientes = Cliente::all();
        $query3= "SELECT * FROM linea WHERE linea.marca_id=".$vehiculo->marca_id."";
        $lineas = DB::select($query3);
        $colores= Color::all();
        $direcciones= Direccion::all();
        $tipos_caja= DB::select($query4);
        $combustibles= Combustible::all();
        $tracciones= Traccion::all();

        return view('vehiculos.edit', compact('vehiculo', 'fieldsArray', "colores","lineas","combustibles","tipos_caja","direcciones","tracciones","tipos_vehiculos", "marcas","tipos_transmision", "clientes"));
    }

    /**
     * Updata the specified resource in storage.
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
        $vehiculo->placa = $data["placa"];
        $vehiculo->aceite_caja = $data["aceite_caja"];
        $vehiculo->aceite_motor = $data["aceite_motor"];
        $vehiculo->año = $data["año"];
        $vehiculo->color = $data["color"];
        $vehiculo->kilometraje = $data["kilometraje"];
        $vehiculo->linea = $data['linea'];
        $vehiculo->observaciones = $data['observaciones'];
        $vehiculo->tipo_vehiculo_id = $data["tipo_vehiculo_id"];
        $vehiculo->tipo_transmision_id = $data["tipo_transmision_id"];
        $vehiculo->marca_id = $data["marca_id"];
        $vehiculo->cliente_id = $data["cliente_id"];
        $vehiculo->fecha_ultimo_servicio = $data["fecha_ultimo_servicio"];
        $vehiculo->chasis = $data["chasis"];
        $vehiculo->vin = $data["vin"];
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
            $vehiculo->delete();
            
            $response["response"] = "El vehiculo se ha Eliminado";
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

        $api_logsQueriable = DB::table('vehiculos');
        $api_Result['recordsTotal'] = $api_logsQueriable->count();

        $query = "SELECT * FROM vehiculos";

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
