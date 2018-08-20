<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Factura;
use App\FacturaCambiariaMaestro;
use App\FacturaCambiariaDetalle;
use App\FacturaDetalle;
use App\vale_maestro;
use App\vale_detalle;
use App\cliente;
use App\serie_factura;
use App\precio_combustible;
use App\series;
use App\idp;
use Barryvdh\DomPDF\Facade as PDF;
use Mail;

class FacturaController extends Controller
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
        return view("factura.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clientes = cliente::all();
        return view("factura.create", compact("clientes"));
    }


    public function create2()
    {
        $series = series::where('estado_serie_id', 1)->where('documento_id', 1)->get();

        $disel = precio_combustible::where("combustible_id", 1)->orderBy('id', 'desc')->get()->first();
        $super = precio_combustible::where("combustible_id", 2)->orderBy('id', 'desc')->get()->first();
        $regular = precio_combustible::where("combustible_id", 3)->orderBy('id', 'desc')->get()->first();


        return view("factura.create2", compact("series","disel","super","regular"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function save(Request $request) {
       $data = $request->all();
       $valores = $data["selected"];
       $valore1= array_map('trim', explode(',', $data["selected"]));

       $facamb=FacturaCambiariaMaestro::whereIN('id',$valore1)->get();

       $cliente = cliente::where('id', $data["cliente_id"])->get()->first();
       $series = series::where('estado_serie_id', 1)->where('documento_id', $data["cliente_id"])->get();
       $user = Auth::user();

       $records = [];
       $total = 0;

       $idp_diesel = 0;
       $idp_regular = 0;
       $idp_super = 0;
       $idp_total = 0;

       $idp_d = idp::where('combustible_id', 1)->get()->first();
       $idp_s = idp::where('combustible_id', 2)->get()->first();
       $idp_r = idp::where('combustible_id', 3)->get()->first();

       foreach($facamb as $facc)
       {
        $vales = vale_maestro::where('factura_cambiaria_id', $facc->id)->get();

        foreach ($vales as $vale) 
        {
            $newData = new FacturaDetalle;

            $vale_detalles = vale_detalle::where('vale_maestro_id', $vale->id)->get();

            foreach ($vale_detalles as $detalle) {
                $newData = new FacturaDetalle;
                $exist = false;

                if ( count($records) >  0)
                {
                    foreach ($records as $record) {
                        if ($detalle->tipo_producto_id == 2) 
                        {
                            if ($record["combustible_id"] == $detalle->combustible_id )
                            {
                                $record["cantidad"] = $record["cantidad"] + $detalle->cantidad;
                                $record["subtotal"] = $record["subtotal"] + $detalle->subtotal;
                                $exist= true;
                            }
                        }
                        else if ($detalle->tipo_producto_id == 1) 
                        {
                            if ($record["producto_id"] == $detalle->producto_id )
                            {
                                $record["cantidad"] = $record["cantidad"] + $detalle->cantidad;
                                $record["subtotal"] = $record["subtotal"] + $detalle->subtotal;
                                $exist= true;
                            }
                        }
                        if ($exist == false ) 
                        {
                            if ($detalle->tipo_producto_id == 2) 
                            {
                                $newData->combustible_id = $detalle->combustible_id;

                            } 
                            else if ($detalle->tipo_producto_id == 1) 
                            {
                                $newData->producto_id = $detalle->producto_id;

                            }

                            $newData->subtotal = $detalle->subtotal;
                            $newData->cantidad = $detalle->cantidad;
                            $newData->tipo_producto_id = $detalle->tipo_producto_id;
                            array_push($records, $newData);
                        }

                    }
                }
                else 
                {
                    if ($detalle->tipo_producto_id == 2) 
                    {
                        $newData->combustible_id = $detalle->combustible_id;
                        $newData->producto_id = 0;

                    } 
                    else if ($detalle->tipo_producto_id == 1) 
                    {
                        $newData->producto_id = $detalle->producto_id;
                        $newData->combustible_id = 0;


                    }

                    $newData->subtotal = $detalle->subtotal;
                    $newData->cantidad = $detalle->cantidad;
                    $newData->tipo_producto_id = $detalle->tipo_producto_id;
                    array_push($records, $newData);
                }

                $total = $total + $detalle->subtotal;

                if ($newData) {


                }
            }       

        }
    }

    $dataF["user_id"] = $user->id;
    $dataF["cliente_id"] =  $data["cliente_id"];
    $dataF["serie_id"] = $data["serie_id"];
    $dataF["estado_id"] = 1;
    $dataF["no_factura"] = $data["no_factura"];
    $dataF["nit"] = $data["nit"];
    $dataF["direccion"] = $data["direccion"];
    $dataF["total"] = $total;
    $dataF["fecha_factura"] = Carbon::createFromFormat('d-m-Y', $data['fecha_factura']);

    $factura = Factura::create($dataF);

    foreach ($records as $record) {
        $datallito = $record["attributes"];

        if ($datallito["combustible_id"] == 1 || $datallito["combustible_id"] == 4) {
            $idp_diesel = $datallito["cantidad"] * $idp_d->costo_idp;
        }
        if ($datallito["combustible_id"] == 2 || $datallito["combustible_id"] == 5) {
            $idp_super = $datallito["cantidad"] * $idp_s->costo_idp;
        }
        if ($datallito["combustible_id"] == 3 || $datallito["combustible_id"] == 6) {
            $idp_regular = $datallito["cantidad"] * $idp_r->costo_idp;
        }
        $datallito["user_id"] = $user->id;
        $factura->factura_detalle()->create($datallito);
    }

    foreach ($facamb as $facc) 
    {
        $facc->estado_id = 4;
        $facc->save();
    }

    $factura->idp_regular = $idp_regular;
    $factura->idp_super = $idp_super;
    $factura->idp_diesel = $idp_diesel;
    $idp_total = $idp_diesel + $idp_super + $idp_regular;
    $factura->idp_total = $idp_total;
    $factura->save();


    return $factura;

}


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    

    public function save2(Request $request) {

        $data = $request->all();
        $data["user_id"] = Auth::user()->id;
        $data["estado_id"] = 1;
        $data["fecha_factura"]=Carbon::createFromFormat('d-m-Y', $data["fecha_factura"]);

        $factura1 = Factura::create($data);

        $idp_diesel = 0;
        $idp_regular = 0;
        $idp_super = 0;
        $idp_total = 0;

        $idp_d = idp::where('combustible_id', 1)->get()->first();
        $idp_s = idp::where('combustible_id', 2)->get()->first();
        $idp_r = idp::where('combustible_id', 3)->get()->first();

        foreach($data['detalle'] as $detalle) 
        {
            $fac_detalle["factura_id"] = $factura1->id ;
            $fac_detalle["producto_id"] = 0;
            $fac_detalle["tipo_producto_id"] = $detalle["tipo_producto_id"];
            $fac_detalle["combustible_id"] = $detalle["combustible_id"];
            $fac_detalle["user_id"] = Auth::user()->id;
            $fac_detalle["cantidad"] = $detalle["cantidad"];
            $fac_detalle["subtotal"] = $detalle["subtotal"];

            if ($fac_detalle["combustible_id"] == 1 || $fac_detalle["combustible_id"] == 4) {
                $idp_diesel = $fac_detalle["cantidad"] * $idp_d->costo_idp;
            }
            if ($fac_detalle["combustible_id"] == 2 || $fac_detalle["combustible_id"] == 5) {
                $idp_super = $fac_detalle["cantidad"] * $idp_s->costo_idp;
            }
            if ($fac_detalle["combustible_id"] == 3 || $fac_detalle["combustible_id"] == 6) {
                $idp_regular = $fac_detalle["cantidad"] * $idp_r->costo_idp;
            }
            
            $detalle = FacturaDetalle::create($fac_detalle);
        }

        $factura1->idp_regular = $idp_regular;
        $factura1->idp_super = $idp_super;
        $factura1->idp_diesel = $idp_diesel;
        $idp_total = $idp_diesel + $idp_super + $idp_regular;
        $factura1->idp_total = $idp_total;
        $factura1->save();

        return $factura1;
    }



    function getFacturas(Request $params,  $cliente) {

        $api_Result = array();
        $today = date("Y/m/d");
        // Create a mapping of our query fields in the order that will be shown in datatable.
        $columnsMapping = array("id", "fec_crea", "total_fac", "cod_cl", "cliente");

        // Initialize query (get all)


        $api_logsQueriable = DB::table('factura');
        $api_Result['recordsTotal'] = $api_logsQueriable->count();

        $query = "SELECT fcm.id as id, fcm.created_at as fec_crea, TRUNCATE(fcm.total, 4) AS total_fac,  
        cl.id as cod_cl, CONCAT(cl.cl_nombres,' ',cl.cl_apellidos) as cliente
        FROM factura_cambiaria_maestro fcm
        INNER JOIN clientes cl ON fcm.cliente_id=cl.id ";

        $where = "  ";

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
        $condition = " WHERE fcm.cliente_id='".$cliente."'";

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


    public function generar(Request $request) {

        $data = $request->all();
        $valores = $data["selected"];
        $valore1= array_map('trim', explode(',', $data["selected"]));

        $facamb=FacturaCambiariaMaestro::whereIN('id',$valore1)->get();

        $cliente = cliente::where('id', $data["cliente_id"])->get()->first();
        $series = series::where('estado_serie_id', 1)->where('documento_id', $data["cliente_id"])->get();
        $user = Auth::user();

        $records = [];
        $total = 0;

        foreach($facamb as $facc)
        {
            $vales = vale_maestro::where('factura_cambiaria_id', $facc->id)->get();

            foreach ($vales as $vale) 
            {
                $newData = new FacturaDetalle;

                $vale_detalles = vale_detalle::where('vale_maestro_id', $vale->id)->get();

                foreach ($vale_detalles as $detalle) {
                    $newData = new FacturaDetalle;
                    $exist = false;

                    if ( count($records) >  0)
                    {
                        foreach ($records as $record) {
                            if ($detalle->tipo_producto_id == 2) 
                            {
                                if ($record["combustible_id"] == $detalle->combustible_id )
                                {
                                    $record["cantidad"] = $record["cantidad"] + $detalle->cantidad;
                                    $record["subtotal"] = $record["subtotal"] + $detalle->subtotal;
                                    $exist= true;
                                }
                            }
                            else if ($detalle->tipo_producto_id == 1) 
                            {
                                if ($record["producto_id"] == $detalle->producto_id )
                                {
                                    $record["cantidad"] = $record["cantidad"] + $detalle->cantidad;
                                    $record["subtotal"] = $record["subtotal"] + $detalle->subtotal;
                                    $exist= true;
                                }
                            }
                            if ($exist == false ) 
                            {
                                if ($detalle->tipo_producto_id == 2) 
                                {
                                    $newData->combustible_id = $detalle->combustible_id;

                                } 
                                else if ($detalle->tipo_producto_id == 1) 
                                {
                                    $newData->producto_id = $detalle->producto_id;

                                }

                                $newData->subtotal = $detalle->subtotal;
                                $newData->cantidad = $detalle->cantidad;
                                $newData->tipo_producto_id = $detalle->tipo_producto_id;
                                array_push($records, $newData);
                            }

                        }
                    }
                    else 
                    {
                        if ($detalle->tipo_producto_id == 2) 
                        {
                            $newData->combustible_id = $detalle->combustible_id;
                            $newData->producto_id = 0;

                        } 
                        else if ($detalle->tipo_producto_id == 1) 
                        {
                            $newData->producto_id = $detalle->producto_id;
                            $newData->combustible_id = 0;


                        }

                        $newData->subtotal = $detalle->subtotal;
                        $newData->cantidad = $detalle->cantidad;
                        $newData->tipo_producto_id = $detalle->tipo_producto_id;
                        array_push($records, $newData);
                    }

                    $total = $total + $detalle->subtotal;

                    if ($newData) {


                    }
                }       

            }
        }

        return view("factura.generar", compact("records", "cliente", "user", "series", "total", "valores"));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }


    public function showFactura(Factura $factura)
    {

        $detalles = FacturaDetalle::where('factura_id', $factura->id)->get();
        $number2 = number_format($factura->total, 2, '.', '');

        $word  = \NumeroALetras::convertir($number2, 'quetzales', 'centavos');

        $pdf = PDF::loadView('factura.show', compact('factura', 'detalles', 'word'));
        $customPaper = array(0,0,400,680);
        $pdf->setPaper($customPaper, 'portrait');

        return $pdf->stream('factura', array("Attachment" => 0));
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function remove(Factura $factura, Request $request)
    {

        $user1= Auth::user()->password;

        if ($request["password_delete"] == "")
        {
            $response["password_delete"]  = "La contraseña es requerida";
            return Response::json( $response  , 422 );
        }
        else if( password_verify( $request["password_delete"] , $user1))
        {
            $id= $factura->id;
            $factura->estado_id = 2;

            $action="Factura Anulada, código de Factura ".$factura->id." con estado ".$factura->estado_id." a estado 2";
            $bitacora = HomeController::bitacora($action);

            $factura->save();

            /*$user = Auth::user();
            $number2 = number_format($factura->total, 2, '.', '');

            $word  = \NumeroALetras::convertir($number2, 'quetzales', 'centavos');
            $detalles = FacturaDetalle::where('factura_id', $factura->id)->get();

            Mail::send('email.facturac', ['factura' => $factura, 'user' => $user, 'detalles' => $detalles, 'word' => $word],  function ($m) use ($factura, $user, $detalles, $word) {

                $m->from('info@vrinfosysgt.com', 'VR InfoSys');

                $m->to("ing.ivargas21314@gmail.com", "Noelia Pazos")->subject('Anulación de Factura');

                $response["response"] = "El registro ha sido anulado";
                return Response::json( $response );
            });*/

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
        $columnsMapping = array("fac.id","ser.serie","fac.fecha_factura","fac.nit","fac.cliente","fac.total");

        // Initialize query (get all)

        $api_logsQueriable = DB::table('factura');
        $api_Result['recordsTotal'] = $api_logsQueriable->count();

        $query = "SELECT fac.id as id, ser.serie as serie, fac.fecha_factura as fecha, fac.nit as nit, fac.cliente as cliente, fac.total as total
        FROM factura fac
        INNER JOIN series ser ON ser.id=fac.serie_id ";

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
        $condition = "";
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
