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
use App\gasto;
use Illuminate\Support\Facades\Input;
class GastosController extends Controller
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
        return view("gastos.index");
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
        return view("gastos.create" , compact( "user","today"));
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
        $data["fecha_corte"]=Carbon::createFromFormat('Y-m-d', $data["fecha_corte"]);
        $data["user_id"] = Auth::user()->id;
        $data["estado_corte_id"] = 1;

        $gasto = gasto::create($data);

        $action="Gasto creado, código ".$gasto->id;
        $bitacora = HomeController::bitacora($action);

        return Response::json($gasto);
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
    public function edit(Gasto $gasto)
    {
        return view('gastos.edit', compact('gasto'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Gasto $gasto, Request $request)
    {
        Response::json( $this->updateGasto($gasto , $request->all()));
        return redirect('/gastos');
    }

    public function updateGasto(Gasto $gasto, array $data )
    {
        $action="Gasto Editado, código ".$gasto->id."; datos anteriores: ".$gasto->documento.",".$gasto->no_documento.",".$gasto->descripcion.",".$gasto->monto.",".$gasto->user_id."";
        $bitacora = HomeController::bitacora($action);

        $gasto->documento = $data["documento"];
        $gasto->no_documento = $data["no_documento"];
        $gasto->descripcion = $data["descripcion"];
        $gasto->monto = $data["monto"];
        $gasto->fecha_corte = $data["fecha_corte"];
        $gasto->codigo_corte = $data["codigo_corte"];
        $gasto->user_id = Auth::user()->id;
        $gasto->save();

        return $gasto;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(gasto $gasto, Request $request)
    {
         $user1= Auth::user()->password;

        if ($request["password_delete"] == "")
        {
            $response["password_delete"]  = "La contraseña es requerida";
            return Response::json( $response  , 422 );
        }
        else if( password_verify( $request["password_delete"] , $user1))
        {
            $action="Gasto Borrado, codigo ".$gasto->id." y datos ".$gasto->documento.",".$gasto->no_documento.",".$gasto->descripcion.",".$gasto->monto.",".$gasto->user_id."";
            $bitacora = HomeController::bitacora($action);

            $gasto->delete();

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
        $columnsMapping = array("id", "fecha_corte", "documento", "no_documento", "descripcion", "monto");

        // Initialize query (get all)

        $api_logsQueriable = DB::table('gastos');
        $api_Result['recordsTotal'] = $api_logsQueriable->count();

        $query = "SELECT id, DATE_FORMAT(fecha_corte, '%d-%m-%Y') as fecha, documento, no_documento, descripcion, monto FROM gastos";

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
