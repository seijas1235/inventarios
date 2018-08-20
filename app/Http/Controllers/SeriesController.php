<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\series;
use App\documentos;
use App\User;

class SeriesController extends Controller
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
        return view("series2.index");
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
        $doctos = documentos::where("id","<",4)->get();

        return view("series2.create" , compact( "user","today","doctos"));
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
        $data["estado_serie_id"] =1;
        $data["user_id"] = Auth::user()->id;
        $serie = series::create($data);

      /*  $action="Serie de Factura ha sido Creado, con c贸digo ".$serie_factura->id;
        $bitacora = HomeController::bitacora($action);*/

        return Response::json($serie);
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
    public function edit(Series $serie)
    {
         $user = Auth::user()->id;
        $today = date("Y/m/d");
        $doctos = documentos::where("id","<",4)->get();
        
        $query = "SELECT * FROM series WHERE id = ".$serie->id."";
        $fieldsArray = DB::select($query);

        return view('series2.edit', compact( 'fieldsArray', 'user', 'today', 'serie', 'doctos' ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function update(Series $serie, Request $request)
    {
        Response::json( $this->updateSeries($serie, $request->all()));
        return redirect('/series2');
    }

    public function updateSeries(Series $serie, array $data )
    {
        /*$action="Series de Factura editado, codigo ".$serie_factura->id." datos anteriores: ".$serie_factura->serie_factura.",".$serie_factura->no_factura.",".$serie_factura->rango_numeracion.",".$serie_factura->tienda_id."; datos nuevos: ".$data["serie_factura"].",".$data["no_factura"].",".$data["rango_numeracion"];
        $bitacora = HomeController::bitacora($action);*/

        $id= $serie->id;
        $serie->serie = $data["serie"];
        $serie->resolucion = $data["resolucion"];
        $serie->fecha_resolucion = $data["fecha_resolucion"];
        $serie->num_inferior = $data["num_inferior"];
        $serie->num_superior = $data["num_superior"];
        $serie->fecha_vencimiento = $data["fecha_vencimiento"];
        $serie->num_actual = $data["num_actual"];
        $serie->documento_id = $data["documento_id"];
        $serie->save();

        return $serie;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getJson(Request $params)
    {
        $api_Result = array();
        // Create a mapping of our query fields in the order that will be shown in datatable.
        $columnsMapping = array("id", "serie", "resolucion", "fecha_vencimiento", "num_inferior", "num_superior", "documento");

        // Initialize query (get all)

        $api_logsQueriable = DB::table('series');
        $api_Result['recordsTotal'] = $api_logsQueriable->count();

        $query = 'SELECT ser.id, ser.serie, ser.resolucion, ser.num_inferior, ser.num_superior, ser.fecha_vencimiento, doc.documento
        FROM series ser 
        INNER JOIN documentos doc ON ser.documento_id=doc.id ';

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
        $condition = " WHERE estado_serie_id=1 ";
        $query = $query . $condition . $where ;

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
