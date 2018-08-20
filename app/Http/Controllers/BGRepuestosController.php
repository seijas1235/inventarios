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
use App\estado_corte;
use App\bg_repuesto;
use Illuminate\Support\Facades\Input;

class BGRepuestosController extends Controller
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
        return view("bg_repuestos.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("bg_repuestos.create");
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

        $bgr = bg_repuesto::create($data);

        $action="Repuesto de BG creado, código ".$bgr->id;
        $bitacora = HomeController::bitacora($action);

        return Response::json($bgr);
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
    public function edit(bg_repuesto $bg_repuesto)
    {
        return view('bg_repuestos.edit', compact('bg_repuesto'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(bg_repuesto $bg_repuesto, Request $request)
    {
        Response::json( $this->updateBGRepuesto($bg_repuesto , $request->all()));
        return redirect('/bg_repuestos');
    }

    public function updateBGRepuesto(bg_repuesto $bg_repuesto, array $data )
    {
        $action="Registro de gasto de repuesto Editado, código ".$bg_repuesto->id."; datos anteriores: ".$bg_repuesto->descripcion.",".$bg_repuesto->monto.",".$bg_repuesto->observaciones.",".$bg_repuesto->fecha_corte.",".$bg_repuesto->codigo_corte.",".$bg_repuesto->documento.",".$bg_repuesto->no_documento."; datos nuevos ".$data["descripcion"].", ".$data["monto"].", ".$data["observaciones"].", ".$data["fecha_corte"].",".$data["codigo_corte"].",".$data["documento"].",".$data["no_documento"]."";
    $bitacora = HomeController::bitacora($action);

        $bg_repuesto->fecha_corte =  $data['fecha_corte'];
        $bg_repuesto->codigo_corte = $data["codigo_corte"];
        $bg_repuesto->documento = $data["documento"];
        $bg_repuesto->no_documento = $data["no_documento"];
        $bg_repuesto->descripcion = $data["descripcion"];
        $bg_repuesto->monto = $data["monto"];
        $bg_repuesto->observaciones = $data["observaciones"];
        $bg_repuesto->user_id = Auth::user()->id;
        $bg_repuesto->save();

        return $bg_repuesto;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(bg_repuesto $bg_repuesto, Request $request)
    {
        
        $user1= Auth::user()->password;

        if ($request["password_delete"] == "")
        {
            $response["password_delete"]  = "La contraseña es requerida";
            return Response::json( $response  , 422 );
        }
        else if( password_verify( $request["password_delete"] , $user1))
        {
            $action="Registro de repuestos para BG Borrado, codigo ".$bg_repuesto->id." y datos ".$bg_repuesto->fecha_corte.",".$bg_repuesto->codigo_corte.",".$bg_repuesto->descripcion.",".$bg_repuesto->monto.",".$bg_repuesto->observaciones.",".$bg_repuesto->documento.",".$bg_repuesto->no_documento.",".$bg_repuesto->user_id."";
            $bitacora = HomeController::bitacora($action);

            $bg_repuesto->delete();

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

        $api_logsQueriable = DB::table('bg_repuestos');
        $api_Result['recordsTotal'] = $api_logsQueriable->count();

        $query = "SELECT * FROM bg_repuestos";

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
