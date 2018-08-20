<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Destino;
use App\User;


class DestinoController extends Controller
{
    public function index()
    {
        return view("destinos.index");
    }

    public function getJson(Request $params)
    {
        $api_Result = array();
        // Create a mapping of our query fields in the order that will be shown in datatable.
        $columnsMapping = array("id", "nombre", "estado_id");

        // Initialize query (get all)

        $api_logsQueriable = DB::table('destino');
        $api_Result['recordsTotal'] = $api_logsQueriable->count();

        $query = 'SELECT id, nombre, estado_id from destino ';

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
        return view("destinos.create" , compact( "user"));
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
        $destino = Destino::create($data);

        $action="Destino ha sido Creado, con código ".$destino->id;
        $bitacora = HomeController::bitacora($action);

        return Response::json($destino);
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
    public function edit(Destino $destino)
    {
        $query = "SELECT * FROM destino WHERE id = ".$destino->id." ";
        $fieldsArray = DB::select($query);
        return view('destinos.edit', compact('destino', 'fieldsArray'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Destino $destino, Request $request)
    {
        Response::json( $this->updateDestino($destino , $request->all()));
        return redirect('/destinos');
    }

    public function updateDestino(Destino $destino, array $data )
    {
        $action="Destino Editado, código ".$destino->id."; datos anteriores: ".$destino->nombre;
        $bitacora = HomeController::bitacora($action);

        $destino->nombre = $data["nombre"];
        $destino->save();

        return $destino;
    }


    public function destroy(Destino $destino, Request $request)
    {
        $user1= Auth::user()->password;

        if ($request["password_delete"] == "")
        {
            $response["password_delete"]  = "La contraseña es requerida";
            return Response::json( $response  , 422 );
        }
        else if( password_verify( $request["password_delete"] , $user1))
        {
            $action="Destino Borrado, codigo ".$destino->id." y datos ".$destino->nombre."";
            $bitacora = HomeController::bitacora($action);

            $destino->estado_id = 2;
            $destino->save();

            $response["response"] = "El registro ha sido borrado";
            return Response::json( $response );
        }
        else {
            $response["password_delete"] = "La contraseña no coincide";
            return Response::json( $response  , 422 );
        }
    }
}
