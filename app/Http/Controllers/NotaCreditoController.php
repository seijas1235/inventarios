<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use View;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\NotaCreditoMaestro;
use App\NotaCreditoDetalle;
use App\cliente;
use App\combustible;
use App\producto;
use App\bomba;
use App\user;
use App\estado_vale;
use App\precio_combustible;
use App\vale_maestro;
use App\vale_detalle;
use App\FacturaCambiariaMaestro;
use App\FacturaCambiariaDetalle;
use App\nota_facturas;
use App\idp;
use Barryvdh\DomPDF\Facade as PDF;
use Mail;

class NotaCreditoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("notac.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $clientes = cliente::all();
        return view(" notac.create", compact("clientes"));
    }


    public function generarRef(Request $request) {

        $data = $request->all();
        $valores = $data["selected"];
        $valore= array_map('trim', explode(',', $data["selected"]));
        $facturas = FacturaCambiariaMaestro::whereIn('id', $valore)->get();
        $cliente = cliente::where('id', $data["cliente_id"])->get()->first();
        $user = Auth::user();
        $total = $data["total"];

        $records = [];
        $diesel = 0;
        $diesel_a = 0;
        $cantidad_disel = 0;
        $cantidad_regular = 0;
        $cantidad_super = 0;
        $cantidad_disel_a = 0;
        $cantidad_regular_a = 0;
        $cantidad_super_a = 0;
        $regular = 0;
        $super = 0;
        $regular_a = 0;
        $super_a = 0;

        foreach ($facturas as $factura) {

            $detalles = FacturaCambiariaDetalle::where('factura_cambiaria_maestro_id', $factura->id)->get();

            foreach ($detalles as $detalle) {

                if ($detalle->combustible_id == 1) {

                    $diesel_a = $diesel_a + $detalle->subtotal;
                    $cantidad_disel_a = $cantidad_disel_a + $detalle->cantidad;

                }
                if ($detalle->combustible_id == 2) {
                    $super_a = $super_a + $detalle->subtotal;
                    $cantidad_super_a = $cantidad_super_a + $detalle->cantidad;

                }
                if ($detalle->combustible_id == 3) {
                    $regular_a = $regular_a + $detalle->subtotal;
                    $cantidad_regular_a = $cantidad_regular_a + $detalle->cantidad;

                }
                if ($detalle->combustible_id == 4) {
                    $diesel = $diesel + $detalle->subtotal;
                    $cantidad_disel = $cantidad_disel + $detalle->cantidad;

                }
                if ($detalle->combustible_id == 5) {
                    $super = $super + $detalle->subtotal;
                    $cantidad_super = $cantidad_super + $detalle->cantidad;

                }
                if ($detalle->combustible_id == 6) {
                    $regular = $regular + $detalle->subtotal;
                    $cantidad_regular = $cantidad_regular + $detalle->cantidad;

                }
            }
            
        }

        if ($cantidad_disel_a > 0) {
            $object = new FacturaCambiariaDetalle;
            $object->cantidad = $cantidad_disel_a;
            $object->combustible_id = 1;
            $object->subtotal = $diesel_a;
            $records[0] =  $object;
        }

        if ($cantidad_super_a > 0) {
            $object = new FacturaCambiariaDetalle;
            $object->cantidad = $cantidad_super_a;
            $object->combustible_id = 2;
            $object->subtotal = $super_a;
            $records[1] =  $object;
        }

        if ($cantidad_regular_a > 0) {
            $object = new FacturaCambiariaDetalle;
            $object->cantidad = $cantidad_regular_a;
            $object->combustible_id = 3;
            $object->subtotal = $regular_a;
            $records[2] =  $object;

        }
        if ($cantidad_disel > 0) {

            $object = new FacturaCambiariaDetalle;
            $object->cantidad = $cantidad_disel;
            $object->combustible_id = 4;
            $object->subtotal = $diesel;
            $records[3] =  $object;
        }
        if ($cantidad_super > 0) {
            $object = new FacturaCambiariaDetalle;
            $object->cantidad = $cantidad_super;
            $object->combustible_id = 5;
            $object->subtotal = $super;
            $records[4] =  $object;
        }

        if ($cantidad_regular > 0) {
            $object = new FacturaCambiariaDetalle;
            $object->cantidad = $cantidad_regular;
            $object->combustible_id = 6;
            $object->subtotal = $regular;
            $records[5] =  $object;
        }

        return view("notac.saveRef", compact("records", "cliente", "user", "total", "valores"));
    }

    public function storeRef(Request $request) {
        $data = $request->all();
        $data["user_id"] = Auth::user()->id;
        $data["fecha"] = date("Y/m/d");
        $data["tipo_id"] = 3;
        $data["concepto_id"] = 3;
        $data["estado_id"] = 1;

        $nota_credito = NotaCreditoMaestro::create($data);


        $valore= array_map('trim', explode(',', $data["detalle"]));
        $facturas = FacturaCambiariaMaestro::whereIn('id', $valore)->get();


        $records = [];
        $diesel = 0;
        $diesel_a = 0;
        $cantidad_disel = 0;
        $cantidad_regular = 0;
        $cantidad_super = 0;
        $cantidad_disel_a = 0;
        $cantidad_regular_a = 0;
        $cantidad_super_a = 0;
        $regular = 0;
        $super = 0;
        $regular_a = 0;
        $super_a = 0;

        foreach ($facturas as $factura) {

            $nota_factura = new nota_facturas;
            $nota_factura->nota_credito_id = $nota_credito->id;
            $nota_factura->factura_cambiaria_id = $factura->id;

            nota_facturas::create($nota_factura["attributes"]);

            $detalles = FacturaCambiariaDetalle::where('factura_cambiaria_maestro_id', $factura->id)->get();

            foreach ($detalles as $detalle) {

                if ($detalle->combustible_id == 1) {

                    $diesel_a = $diesel_a + $detalle->subtotal;
                    $cantidad_disel_a = $cantidad_disel_a + $detalle->cantidad;

                }
                if ($detalle->combustible_id == 2) {
                    $super_a = $super_a + $detalle->subtotal;
                    $cantidad_super_a = $cantidad_super_a + $detalle->cantidad;

                }
                if ($detalle->combustible_id == 3) {
                    $regular_a = $regular_a + $detalle->subtotal;
                    $cantidad_regular_a = $cantidad_regular_a + $detalle->cantidad;

                }
                if ($detalle->combustible_id == 4) {
                    $diesel = $diesel + $detalle->subtotal;
                    $cantidad_disel = $cantidad_disel + $detalle->cantidad;

                }
                if ($detalle->combustible_id == 5) {
                    $super = $super + $detalle->subtotal;
                    $cantidad_super = $cantidad_super + $detalle->cantidad;

                }
                if ($detalle->combustible_id == 6) {
                    $regular = $regular + $detalle->subtotal;
                    $cantidad_regular = $cantidad_regular + $detalle->cantidad;

                }
            }
            
        }

        if ($cantidad_disel_a > 0) {
            $object = new FacturaCambiariaDetalle;
            $object->cantidad = $cantidad_disel_a;
            $object->combustible_id = 1;
            $object->subtotal = $diesel_a;
            $records[0] =  $object;
        }

        if ($cantidad_super_a > 0) {
            $object = new FacturaCambiariaDetalle;
            $object->cantidad = $cantidad_super_a;
            $object->combustible_id = 2;
            $object->subtotal = $super_a;
            $records[1] =  $object;
        }

        if ($cantidad_regular_a > 0) {
            $object = new FacturaCambiariaDetalle;
            $object->cantidad = $cantidad_regular_a;
            $object->combustible_id = 3;
            $object->subtotal = $regular_a;
            $records[2] =  $object;

        }
        if ($cantidad_disel > 0) {

            $object = new FacturaCambiariaDetalle;
            $object->cantidad = $cantidad_disel;
            $object->combustible_id = 4;
            $object->subtotal = $diesel;
            $records[3] =  $object;
        }
        if ($cantidad_super > 0) {
            $object = new FacturaCambiariaDetalle;
            $object->cantidad = $cantidad_super;
            $object->combustible_id = 5;
            $object->subtotal = $super;
            $records[4] =  $object;
        }

        if ($cantidad_regular > 0) {
            $object = new FacturaCambiariaDetalle;
            $object->cantidad = $cantidad_regular;
            $object->combustible_id = 6;
            $object->subtotal = $regular;
            $records[5] =  $object;
        }


        $idp_diesel = 0;
        $idp_regular = 0;
        $idp_super = 0;
        $idp_total = 0;

        $idp_d = idp::where('combustible_id', 1)->get()->first();
        $idp_s = idp::where('combustible_id', 2)->get()->first();
        $idp_r = idp::where('combustible_id', 3)->get()->first();

        foreach($records as $record) 
        {
            $nota_detalle["combustible_id"] = $record->combustible_id;
            $nota_detalle["producto_id"] = 0;
            $nota_detalle["cantidad"] = $record->cantidad;
            $nota_detalle["user_id"] = Auth::user()->id;
            $nota_detalle["subtotal"] = $record->subtotal;
            $nota_detalle["tipo_producto_id"] = 2;

            if ($nota_detalle["combustible_id"] == 1 || $nota_detalle["combustible_id"] == 4) {
                $idp_diesel = $nota_detalle["cantidad"] * $idp_d->costo_idp;
            }
            if ($nota_detalle["combustible_id"] == 2 || $nota_detalle["combustible_id"] == 5) {
                $idp_super = $nota_detalle["cantidad"] * $idp_s->costo_idp;
            }
            if ($nota_detalle["combustible_id"] == 3 || $nota_detalle["combustible_id"] == 6) {
                $idp_regular = $nota_detalle["cantidad"] * $idp_r->costo_idp;
            }
            
            $nota_credito->nota_detalle()->create($nota_detalle);
        }

        $nota_credito->idp_regular = $idp_regular;
        $nota_credito->idp_super = $idp_super;
        $nota_credito->idp_diesel = $idp_diesel;
        $idp_total = $idp_diesel + $idp_super + $idp_regular;
        $nota_credito->idp_total = $idp_total;
        $nota_credito->save();


        return $nota_credito;

    }

    public function storeDescuento(Request $request) {
        $data = $request->all();
        $data["user_id"] = Auth::user()->id;
        $data["fecha"] = date("Y/m/d");
        $data["tipo_id"] = 1;
        $data["concepto_id"] = 1;
        $data["estado_id"] = 1;
        $monto = 0;

        if  ($data["mantener"] = 'on' ) {

        }

        else {
            foreach($data['detalle'] as $detalle) 
            {

                $nota_detalle["subtotal"] = $detalle["cantidad"] * $data["tasa"];
                $monto = $monto + $nota_detalle["subtotal"];
            }
            $data->monto = $monto;
        }

        $nota_credito = NotaCreditoMaestro::create($data);
        $records = [];

        foreach($data['detalle'] as $detalle) 
        {
            $newData = new NotaCreditoDetalle;

            if ( count($records) >  0)
            {
                foreach ($records as $record) {

                    $record["cantidad"] = $record["cantidad"] + $detalle["cantidad"];
                    $record["subtotal"] = $record["subtotal"] + $detalle["subtotal"];

                }
            }
            else 
            {
                $newData->combustible_id = 1;
                $newData->producto_id = 0;                
                $newData->subtotal =  $detalle["subtotal"];
                $newData->cantidad =  $detalle["cantidad"];
                $newData->tipo_producto_id = 2;
                $newData->user_id = Auth::user()->id;
                array_push($records, $newData);
            }          
        }

        $idp_diesel = 0;
        $idp_regular = 0;
        $idp_super = 0;
        $idp_total = 0;

        $idp_d = idp::where('combustible_id', 1)->get()->first();
        $idp_s = idp::where('combustible_id', 2)->get()->first();
        $idp_r = idp::where('combustible_id', 3)->get()->first();

        foreach ($records as $record) {
            $datallito = $record["attributes"];
            $datallito["user_id"] = Auth::user()->id;

            if ($datallito["combustible_id"] == 1 || $datallito["combustible_id"] == 4) {
                $idp_diesel = $datallito["cantidad"] * $idp_d->costo_idp;
            }
            if ($datallito["combustible_id"] == 2 || $datallito["combustible_id"] == 5) {
                $idp_super = $datallito["cantidad"] * $idp_s->costo_idp;
            }
            if ($datallito["combustible_id"] == 3 || $datallito["combustible_id"] == 6) {
                $idp_regular = $datallito["cantidad"] * $idp_r->costo_idp;
            }

            $factura_cambiaria->factura_detalle()->create($datallito);

        }        


        $nota_credito->idp_regular = $idp_regular;
        $nota_credito->idp_super = $idp_super;
        $nota_credito->idp_diesel = $idp_diesel;
        $idp_total = $idp_diesel + $idp_super + $idp_regular;
        $nota_credito->idp_total = $idp_total;
        $nota_credito->save();

        
        return $nota_credito;
    }

    public function storePronto(Request $request) {
        $data = $request->all();
        $data["user_id"] = Auth::user()->id;
        $data["fecha"] = date("Y/m/d");
        $data["tipo_id"] = 2;
        $data["concepto_id"] = 2;
        $data["estado_id"] = 1;

        $idp_diesel = 0;
        $idp_regular = 0;
        $idp_super = 0;
        $idp_total = 0;

        $idp_d = idp::where('combustible_id', 1)->get()->first();
        $idp_s = idp::where('combustible_id', 2)->get()->first();
        $idp_r = idp::where('combustible_id', 3)->get()->first();


        $nota_credito = NotaCreditoMaestro::create($data);

        foreach($data['detalle'] as $detalle) 
        {
            $nota_detalle["combustible_id"] = $detalle["combustible_id"];
            $nota_detalle["producto_id"] = 0;
            $nota_detalle["cantidad"] = $detalle["cantidad"];
            $nota_detalle["user_id"] = Auth::user()->id;
            $nota_detalle["subtotal"] = $detalle["subtotal"];
            $nota_detalle["tipo_producto_id"] = 2;

            if ($detalle["combustible_id"] == 1 || $detalle["combustible_id"] == 4) {
                $idp_diesel = $detalle["cantidad"] * $idp_d->costo_idp;
            }
            if ($detalle["combustible_id"] == 2 || $detalle["combustible_id"] == 5) {
                $idp_super = $detalle["cantidad"] * $idp_s->costo_idp;
            }
            if ($detalle["combustible_id"] == 3 || $detalle["combustible_id"] == 6) {
                $idp_regular = $detalle["cantidad"] * $idp_r->costo_idp;
            }
            
            $nota_credito->nota_detalle()->create($nota_detalle);
        }

        $nota_credito->idp_regular = $idp_regular;
        $nota_credito->idp_super = $idp_super;
        $nota_credito->idp_diesel = $idp_diesel;
        $idp_total = $idp_diesel + $idp_super + $idp_regular;
        $nota_credito->idp_total = $idp_total;
        $nota_credito->save();
        return $nota_credito;

    }


    public function crearNotaDescuento($tipo, cliente $cliente)
    {

        $vales_vencidos = vale_maestro::where("estado_vale_id", 4)->get();

        $vales_activos = vale_maestro::where("estado_vale_id", 1)->get();

        $sum_vv = vale_maestro::where("estado_vale_id", 4)->sum('total_vale');
        $sum_va = vale_maestro::where("estado_vale_id", 1)->sum('total_vale');

        foreach($vales_vencidos as $vv)  {

            $suma_g = 0;
            $detalles = vale_detalle::where('vale_maestro_id', $vv->id)->get();

            foreach ($detalles as $detalle) {
                if( $detalle->combustible_id != 0 )  {
                    $suma_g = $suma_g + $detalle->cantidad;
                }
            }
            $vv->suma_galones = $suma_g;

        }


        foreach($vales_activos as $va)  {

            $suma_ga = 0;
            $detalles_va = vale_detalle::where('vale_maestro_id', $va->id)->get();

            foreach ($detalles_va as $detalle_va) {
                if( $detalle_va->combustible_id != 0 )  {
                    $suma_ga = $suma_ga + $detalle_va->cantidad;
                }
            }
            $va->suma_galones = $suma_ga;

        }

        if ($cliente->tipo_cliente_id == 1) {
            $tasa = 0.75;
            $tasa1 = 0.35;
        }
        else {
            $tasa = 0.35;
            $tasa1 = 0;
        }


        $suma_gav = $vales_vencidos->sum('suma_galones');
        $suma_gaa = $vales_activos->sum('suma_galones');


        return view(" notac.crearNotaDescuento", compact("cliente", "vales_vencidos", "vales_activos", "sum_vv", "sum_va", "suma_gav", "suma_gaa", "tasa", "tasa1"));
    }


    public function crearNotaDescuentoPP($tipo, cliente $cliente)
    {

        $vales_vencidos = vale_maestro::where("estado_vale_id", 4)->get();

        $vales_activos = vale_maestro::where("estado_vale_id", 1)->get();

        $sum_vv = vale_maestro::where("estado_vale_id", 4)->sum('total_vale');
        $sum_va = vale_maestro::where("estado_vale_id", 1)->sum('total_vale');

        foreach($vales_vencidos as $vv)  {

            $suma_g = 0;
            $detalles = vale_detalle::where('vale_maestro_id', $vv->id)->get();

            foreach ($detalles as $detalle) {
                if( $detalle->combustible_id != 0 )  {
                    $suma_g = $suma_g + $detalle->cantidad;
                }
            }
            $vv->suma_galones = $suma_g;

        }


        foreach($vales_activos as $va)  {

            $suma_ga = 0;
            $detalles_va = vale_detalle::where('vale_maestro_id', $va->id)->get();

            foreach ($detalles_va as $detalle_va) {
                if( $detalle_va->combustible_id != 0 )  {
                    $suma_ga = $suma_ga + $detalle_va->cantidad;
                }
            }
            $va->suma_galones = $suma_ga;

        }

        if ($sum_vv == null) {
            $sum_vv = 0;
        }
        

        if ($vales_vencidos != null) {
            $suma_gav = $vales_vencidos->sum('suma_galones');            
        }
        else 
        {
            $suma_gav = 0;
        }

        if ($vales_activos != null) {

            $suma_gaa = $vales_activos->sum('suma_galones');   
        }
        else {
            $suma_gaa = 0;
        }

        $disel = precio_combustible::where("combustible_id", 4)->orderBy('id', 'desc')->get()->first();

        if ($disel) { 
            $precio_disel = $disel->precio_venta;
        }

        else {
            $precio_disel = 0;
        }


        $super = precio_combustible::where("combustible_id", 5)->orderBy('id', 'desc')->get()->first();

        if ($super) { 
            $precio_super = $super->precio_venta;
        }

        else {
            $precio_super = 0;
        }

        $regular = precio_combustible::where("combustible_id", 6)->orderBy('id', 'desc')->get()->first();

        if ($regular) { 
            $precio_regular = $regular->precio_venta;
        }

        else {
            $precio_regular = 0;
        }


        return view(" notac.crearNotaDescuento2", compact("cliente", "vales_vencidos", "vales_activos", "sum_vv", "sum_va", "suma_gav", "suma_gaa", "precio_disel", "precio_super", "precio_regular"));
    }


    public function crearNotaDescuentoRef($tipo, cliente $cliente)
    {

        $facturas = FacturaCambiariaMaestro::where(
            [
            ["estado_id", 1], 
            ["cliente_id", $cliente->id] 
            ])->get();


        return view(" notac.crearNotaDescuento3", compact("cliente", "facturas"));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

    public function getJson(Request $params)
    {

        $api_Result = array();
        $today = date("Y/m/d");
        // Create a mapping of our query fields in the order that will be shown in datatable.
        $columnsMapping = array("n.id", "n.monto", "n.estado_id", "c.cliente", "n.fecha", "n.tipo");

        // Initialize query (get all)


        $api_logsQueriable = DB::table('nota_credito_maestro');
        $api_Result['recordsTotal'] = $api_logsQueriable->count();

        $query = "SELECT n.id AS no_nota,  TRUNCATE(n.monto,4) AS monto, n.estado_id AS estado_id,  CONCAT(c.cl_nombres,' ',c.cl_apellidos) as cliente, n.fecha as fecha, n.tipo_id as tipo
        FROM nota_credito_maestro n
        INNER JOIN clientes c ON n.cliente_id=c.id ";

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
        $condition = "  ";

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

    public function showNotaCredito(NotaCreditoMaestro $nota)
    {

        $detalles = NotaCreditoDetalle::where('nota_credito_maestro_id', $nota->id)->get();

        $facturas = nota_facturas::where("nota_credito_id", $nota->id)->get();

        $count = nota_facturas::where("nota_credito_id", $nota->id)->count();

        $number2 = number_format($nota->monto, 2, '.', '');

        $word  = \NumeroALetras::convertir($number2, 'quetzales', 'centavos');



        $pdf = PDF::loadView('notac.show', compact('nota', 'detalles', 'word', 'facturas', 'count'));
        $customPaper = array(0,0,550,720);
        $pdf->setPaper($customPaper, 'portrait');

        return $pdf->stream('nota_credito', array("Attachment" => 0));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function remove(NotaCreditoMaestro $nota, Request $request)
    {

        $user1= Auth::user()->password;

        if ($request["password_delete"] == "")
        {
            $response["password_delete"]  = "La contraseña es requerida";
            return Response::json( $response  , 422 );
        }
        else if( password_verify( $request["password_delete"] , $user1))
        {
            $id= $nota->id;
            $nota->estado_id = 2;

            $action="Nota C. Borrada, código de Nota ".$nota->id." con estado ".$nota->estado_id." a estado 2";
            $bitacora = HomeController::bitacora($action);

            $nota->save();
            $user = Auth::user();
            $number2 = number_format($nota->monto, 2, '.', '');

            $word  = \NumeroALetras::convertir($number2, 'quetzales', 'centavos');
            $detalles = NotaCreditoDetalle::where('nota_credito_maestro_id', $nota->id)->get();

            Mail::send('email.notac', ['nota' => $nota, 'user' => $user, 'detalles' => $detalles, 'word' => $word],  function ($m) use ($nota, $user, $detalles, $word) {

                $m->from('info@vrinfosysgt.com', 'VR InfoSys');

                $m->to("ing.ivargas21314@gmail.com", "Noelia Pazos")->subject('Anulación de Nota C.');

                $response["response"] = "El registro ha sido anulado";
                return Response::json( $response );
            });

        }
        else {
            $response["password_delete"] = "La contraseña no coincide";
            return Response::json( $response  , 422 );
        }
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

    public function rpt_nc()
    {
        $query = "SELECT id, CONCAT(cl_nombres,' ',cl_apellidos) AS cliente FROM clientes WHERE estado_cliente_id =1 ";

        $lst_clientes = DB::select($query);
        return View::make("reportes.notas_creditos", compact('lst_clientes'));
    }


    public function getJson_rptnc(Request $params)
    {
        $api_Result = array();
        $today = date("Y/m/d");
        // Create a mapping of our query fields in the order that will be shown in datatable.
        $columnsMapping = array("id", "fecha", "nombres", "apellidos");

        // Initialize query (get all)

        $api_logsQueriable = DB::table('nota_credito_maestro');
        $api_Result['recordsTotal'] = $api_logsQueriable->count();

        $query = "SELECT ncm.id as id, date(ncm.created_at) as fecha, cl.cl_nombres as nombres, cl.cl_apellidos as apellidos
        FROM nota_credito_maestro ncm 
        INNER JOIN clientes cl ON cl.id=ncm.cliente_id ";

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
