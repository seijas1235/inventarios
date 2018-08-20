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
use App\faltante;
use App\cliente;
use Illuminate\Support\Facades\Input;

class FaltantesController extends Controller
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
        return view("faltantes.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $clientes = cliente::all();
    
        return view('faltantes.create', compact('clientes'));
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
        $data["estado"] = 1;
        $data["fecha_corte"]=Carbon::createFromFormat('Y-m-d', $data["fecha_corte"]);

        $faltantes = faltante::create($data);

        $action="Faltante de Efectivo creado, código ".$faltantes->id;
        $bitacora = HomeController::bitacora($action);

        return Response::json($faltantes);
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
    public function edit(faltante $faltante)
    {
        $clientes = cliente::all();

        $query = "SELECT * FROM faltantes WHERE id=".$faltante->id."";
        $fieldsArray = DB::select($query);

        return view('faltantes.edit', compact('faltante', 'clientes', 'fieldsArray' ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(faltante $faltante, Request $request)
    {
        Response::json( $this->updateFaltantes($faltante , $request->all()));
        return redirect('/faltantes');
    }

    public function updateFaltantes(faltante $faltante, array $data )
    {
        $action="Registro de faltante de efectivo Editado, código ".$faltante->id."; datos anteriores: ".$faltante->descripcion.",".$faltante->monto.",".$faltante->fecha_corte.",".$faltante->codigo_corte.",".$faltante->documento.",".$faltante->no_documento."; datos nuevos ".$data["descripcion"].", ".$data["monto"].", ".$data["fecha_corte"].",".$data["codigo_corte"].",".$data["documento"].",".$data["no_documento"]."";
    $bitacora = HomeController::bitacora($action);

        $faltante->fecha_corte = $data['fecha_corte'];
        $faltante->codigo_corte = $data["codigo_corte"];
        $faltante->documento = $data["documento"];
        $faltante->cliente_id = $data["cliente_id"];
        $faltante->no_documento = $data["no_documento"];
        $faltante->descripcion = $data["descripcion"];
        $faltante->monto = $data["monto"];
        $faltante->user_id = Auth::user()->id;
        $faltante->save();

        return $faltante;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(faltante $faltante, Request $request)
    {
        $user1= Auth::user()->password;

        if ($request["password_delete"] == "")
        {
            $response["password_delete"]  = "La contraseña es requerida";
            return Response::json( $response  , 422 );
        }
        else if( password_verify( $request["password_delete"] , $user1))
        {
            $action="Registro de faltante de efectivo Borrado, codigo ".$faltante->id." y datos ".$faltante->fecha_corte.",".$faltante->codigo_corte.",".$faltante->descripcion.",".$faltante->monto.",".$faltante->documento.",".$faltante->no_documento.",".$faltante->user_id."";
            $bitacora = HomeController::bitacora($action);

            $faltante->delete();

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

        $api_logsQueriable = DB::table('faltantes');
        $api_Result['recordsTotal'] = $api_logsQueriable->count();

        $query = "SELECT id, DATE_FORMAT(fecha_corte, '%d-%m-%Y') as fecha, documento, no_documento, monto, descripcion FROM faltantes";

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
