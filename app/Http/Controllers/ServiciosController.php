<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Servicio;
Use App\User;
Use App\MaquinariaEquipo;
use Illuminate\Http\Request;
use App\TipoServicio;
use App\Producto;
use App\UnidadDeMedida;
use Illuminate\Support\Facades\Input;

class ServiciosController extends Controller
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

        return view ("servicios.index");

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $maquinarias = MaquinariaEquipo::all();
        $tipos_servicio = TipoServicio::all();
        $productos = Producto::all();
        $unidades_de_medida = UnidadDeMedida::all();
        return view("servicios.create", compact('maquinarias', 'tipos_servicio', 'productos', 'unidades_de_medida'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        //$data = $request->all();
        //$servicio = Servicio::create($data);

        /*$servicio = new Servicio;

        $servicio->nombre = $request->get('nombre');
        $servicio->precio = $request->get('precio');
        $servicio->save();
        
        $servicio->maquinarias()->attach($request->get('maquinarias'));

        return Response::json($servicio);*/
    }

    public function save(Request $request)
	{
        $data = $request->all();
    
		$data["user_id"] = Auth::user()->id;
		$maestro = Servicio::create($data);

		return $maestro;
    }
    
    public function saveDetalle(Request $request, Servicio $servicio)
	{
		$statsArray = $request->all();
		foreach($statsArray as $stat) {

			if(empty($stat['producto_id'])){
				$stat['user_id'] = Auth::user()->id;
				$stat['maquinaria_equipo_id'] = $stat['maquinaria_equipo_id'];
				$stat["costo"] = $stat["costo"];
				$stat["subtotal"] = $stat["subtotal_servicio"];
			
				$servicio->detalles_servicios()->create($stat);
			}

			else{
				$stat['user_id'] = Auth::user()->id;
				$stat['producto_id'] = $stat['producto_id'];
				$stat["costo"] = $stat["costo"];
				$stat["subtotal"] = $stat["subtotal_servicio"];
			
				$servicio->detalles_servicios()->create($stat);
			}		
			
		}
		return Response::json(['result' => 'ok']);

	}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Servicio $servicio)
    {
        return view('servicios.show')->with('servicio', $servicio);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Servicio $servicio)
    {
        $query = "SELECT * FROM servicios WHERE id=".$servicio->id."";
        $fieldsArray = DB::select($query);

        return view('servicios.edit', [
            'servicio' => $servicio,
            'maquinarias' => MaquinariaEquipo::all(),
            'tipos_servicio' => TipoServicio::all(),
            'fieldsArray' =>  DB::select($query) 
        ]);
        
        //return view('servicios.edit', compact('servicio', 'fieldsArray', 'maquinarias','maquinarias2'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Servicio $servicio, Request $request)
    {
        Response::json( $this->updateServicio($servicio , $request->all()));
        return redirect('/servicios');
    }

    public function updateServicio(Servicio $servicio, array $data )
    {
        $id= $servicio->id;
        $servicio->nombre = $data["nombre"];
        $servicio->codigo = $data["codigo"];
        $servicio->precio = $data["precio"];
        $servicio->precio_costo = $data["precio_costo"];
        $servicio->tipo_servicio_id = $data["tipo_servicio_id"];
        $servicio->save();

        /*if(empty($data['maquinarias'])){
            $servicio->maquinarias()->detach();
        }
        else{
            $servicio->maquinarias()->sync($data['maquinarias']);
        } */       

        return $servicio;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Servicio $servicio, Request $request)
    {
        $user1= Auth::user()->password;

        if ($request["password_delete"] == "")
        {
            $response["password_delete"]  = "La contraseña es requerida";
            return Response::json( $response  , 422 );
        }
        else if( password_verify( $request["password_delete"] , $user1))
        {
            $id= $servicio->id;
            $servicio->delete();
            
            $response["response"] = "El servicio ha sido eliminado";
            return Response::json( $response );
        }
        else {
            $response["password_delete"] = "La contraseña no coincide";
            return Response::json( $response  , 422 );
        }    
    }
    public function getPrecio(Servicio $servicio) {

		return Response::json($servicio);
	}

    public function getJson(Request $params)
    {
        $api_Result = array();
        // Create a mapping of our query fields in the order that will be shown in datatable.
        $columnsMapping = array("id", "nombre", "codigo", "precio", "precio_costo");

        // Initialize query (get all)

        $api_logsQueriable = DB::table('servicios');
        $api_Result['recordsTotal'] = $api_logsQueriable->count();

        $query = "SELECT * FROM servicios";

        $where = "";

        if (isset($params->search['value']) && !empty($params->search['value'])){

            foreach ($columnsMapping as $column) {
                if (strlen($where) == 0) {
                    $where .=" where (".$column." like  '%".$params->search['value']."%' ";
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


    public function getJsonDetalle(Request $params, $detalle)
	{
		$api_Result = array();
		// Create a mapping of our query fields in the order that will be shown in datatable.
		$columnsMapping = array("ds.id");

		// Initialize query (get all)


		$api_logsQueriable = DB::table('detalles_servicios');
		$api_Result['recordsTotal'] = $api_logsQueriable->count();

		$query = 'SELECT ds.id, if(p.nombre is null,0, p.nombre) as nombre, if(me.nombre_maquina is null,0, me.nombre_maquina) as nombre_maquina, ds.costo, ds.cantidad
		FROM detalles_servicios ds
		INNER JOIN servicios s on s.id = ds.servicio_id
		LEFT JOIN productos p on p.id = ds.producto_id
		LEFT JOIN maquinarias_y_equipos me on me.id = ds.maquinaria_equipo_id
		WHERE  s.id ='.$detalle.'';

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

		$query = $query . $where;

		// Sorting
		$sort = "";
		foreach ($params->order as $order) {
			if (strlen($sort) == 0) {
				$sort .= ' order by ' . $columnsMapping[$order['column']] . ' '. $order['dir']. ' ';
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
    
    /*public function codigoDisponible()
	{
		$dato = Input::get("codigo");
		$query = Servicio::where("codigo",$dato)->get();
		$contador = count($query);
		if ($contador == 0)
		{
			return 'false';
		}
		else
		{
			return 'true';
		}
    }*/
    
    public function codigoDisponible(Request $request)
	{
		$servicio = $request["data"];

		if ($servicio == "")
		{
			$result = "";
			return Response::json( $result);
		}
		else {
			$query = "Select * FROM servicios WHERE servicios.codigo  = '".$servicio."' ";
				$result = DB::select($query);
				return Response::json( $result);
			}

	}

}
