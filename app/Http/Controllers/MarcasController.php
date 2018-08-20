<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\marca;
use App\User;

class MarcasController extends Controller
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
        return view("marcas.index");
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
        return view("marcas.create" , compact( "user","today"));
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
        $marca = marca::create($data);

        $action="Marca Creada, con código ".$marca->id;
        $bitacora = HomeController::bitacora($action);

        return Response::json($marca);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(marca $marca)
    {
        $query = "SELECT * FROM marcas WHERE id=".$marca->id."";
        $fieldsArray = DB::select($query);
        return view('marcas.edit', compact('marca', 'fieldsArray'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(marca $marca, Request $request)
    {
        Response::json( $this->updateMarca($marca , $request->all()));
        return redirect('/marcas');
    }

    public function updateMarca(marca $marca, array $data )
    {
        $action="Marca editada, codigo ".$marca->id." datos anteriores: ".$marca->marca."; datos nuevos: ".$data["marca"]."";
        $bitacora = HomeController::bitacora($action);

        $id= $marca->id;
        $marca->marca = $data["marca"];
        $marca->save();

        return $marca;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(marca $marca, Request $request)
    {
     $user1= Auth::user()->password;

     if ($request["password_delete"] == "")
     {
        $response["password_delete"]  = "La contraseña es requerida";
        return Response::json( $response  , 422 );
    }
    else if( password_verify( $request["password_delete"] , $user1))
    {
        $action="Marca Borrada, código ".$marca->id." y marca ".$marca->marca."";
        $bitacora = HomeController::bitacora($action);

        $marca->delete();

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
    $columnsMapping = array("m.id", "m.marca","u.name","m.created_at");

        // Initialize query (get all)

    $api_logsQueriable = DB::table('marcas');
    $api_Result['recordsTotal'] = $api_logsQueriable->count();

    $query = 'SELECT m.id, m.marca, u.name, m.created_at FROM marcas m INNER JOIN users u ON u.id=m.user_id ';

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