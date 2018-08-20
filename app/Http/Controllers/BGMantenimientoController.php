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
use App\bg_mantenimiento;
use App\empleado;
use Illuminate\Support\Facades\Input;

class BGMantenimientoController extends Controller
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
        return view("bg_mantenimientos.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("bg_mantenimientos.create");
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

        $bg_mantenimiento = bg_mantenimiento::create($data);

        $action="Mantenimiento de BG creado, código ".$bg_mantenimiento->id;
        $bitacora = HomeController::bitacora($action);

        return Response::json($bg_mantenimiento);
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
    public function edit(bg_mantenimiento $bg_mantenimiento)
    {
        return view('bg_mantenimientos.edit', compact('bg_mantenimiento'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   public function update(bg_mantenimiento $bg_mantenimiento, Request $request)
    {
        Response::json( $this->updateBGMantenimiento($bg_mantenimiento , $request->all()));
        return redirect('/bg_mantenimientos');
    }

    public function updateBGMantenimiento(bg_mantenimiento $bg_mantenimiento, array $data )
    {
        $action="Registro de gasto de mantenimiento Editado, código ".$bg_mantenimiento->id."; datos anteriores: ".$bg_mantenimiento->descripcion.",".$bg_mantenimiento->monto.",".$bg_mantenimiento->observaciones.",".$bg_mantenimiento->fecha_corte.",".$bg_mantenimiento->codigo_corte.",".$bg_mantenimiento->documento.",".$bg_mantenimiento->no_documento."; datos nuevos ".$data["descripcion"].", ".$data["monto"].", ".$data["observaciones"].", ".$data["fecha_corte"].",".$data["codigo_corte"].",".$data["documento"].",".$data["no_documento"]."";
    $bitacora = HomeController::bitacora($action);

        $bg_mantenimiento->fecha_corte = $data['fecha_corte'];
        $bg_mantenimiento->codigo_corte = $data["codigo_corte"];
        $bg_mantenimiento->documento = $data["documento"];
        $bg_mantenimiento->no_documento = $data["no_documento"];
        $bg_mantenimiento->descripcion = $data["descripcion"];
        $bg_mantenimiento->monto = $data["monto"];
        $bg_mantenimiento->observaciones = $data["observaciones"];
        $bg_mantenimiento->user_id = Auth::user()->id;
        $bg_mantenimiento->save();

        return $bg_mantenimiento;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(bg_mantenimiento $bg_mantenimiento, Request $request)
    {
        
        $user1= Auth::user()->password;

        if ($request["password_delete"] == "")
        {
            $response["password_delete"]  = "La contraseña es requerida";
            return Response::json( $response  , 422 );
        }
        else if( password_verify( $request["password_delete"] , $user1))
        {
            $action="Registro de mantenimientos para BG Borrado, codigo ".$bg_mantenimiento->id." y datos ".$bg_mantenimiento->fecha_corte.",".$bg_mantenimiento->codigo_corte.",".$bg_mantenimiento->descripcion.",".$bg_mantenimiento->monto.",".$bg_mantenimiento->observaciones.",".$bg_mantenimiento->documento.",".$bg_mantenimiento->no_documento.",".$bg_mantenimiento->user_id."";
            $bitacora = HomeController::bitacora($action);

            $bg_mantenimiento->delete();

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

        $api_logsQueriable = DB::table('bg_mantenimientos');
        $api_Result['recordsTotal'] = $api_logsQueriable->count();

        $query = "SELECT * FROM bg_mantenimientos";

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
