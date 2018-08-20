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
use App\ReciboCaja;
use App\ReciboCajaFactura;
use App\ReciboCajaVale;
use App\Tipo_Pago;
use App\FacturaCambiariaMaestro;
use App\FacturaCambiariaDetalle;
use App\CuentaCobrarMaestro;
use App\CuentaCobrarDetalle;
use App\serie_factura;
use App\Banco;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Input;
use Mail;


class ReciboCajaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("recibo_caja.index");
    }


public function Recibo_Disponible()
    {
        $dato = Input::get("no_recibo_caja");
        $query = ReciboCaja::where("no_recibo_caja",$dato)->where("estado_id",1)->get();
        $contador = count($query);
        if ($contador == 0)
        {
            return 'false';
        }
        else
        {
            return 'true';
        }
    }


    public function showRecibo(ReciboCaja $recibo)
    {

        $facturas = ReciboCajaFactura::where("recibo_caja_id", $recibo->id)->pluck('factura_cambiaria_id')->toArray();
        $detalles = FacturaCambiariaMaestro::whereIn('id', $facturas)->get();

        $number2 = number_format($recibo->monto, 2, '.', '');

        $word  = \NumeroALetras::convertir($number2, 'quetzales', 'centavos');


        $pdf = PDF::loadView('recibo_caja.show', compact('recibo', 'detalles', 'word'));
        $customPaper = array(0,0,550,720);
        $pdf->setPaper($customPaper, 'portrait');


        return $pdf->stream('vale', array("Attachment" => 0));
    }


    public function getJson(Request $params)
    {
        $api_Result = array();
        $today = date("Y/m/d");
        // Create a mapping of our query fields in the order that will be shown in datatable.
        $columnsMapping = array("v.id", "v.total_vale", "u.name", "c.cliente", "e.estado_vale", "v.created_at", "tp.tipo_pago");

        // Initialize query (get all)

        $api_logsQueriable = DB::table('recibo_caja');
        $api_Result['recordsTotal'] = $api_logsQueriable->count();

        $query = "SELECT v.id AS id, v.created_at as created_at, TRUNCATE(v.monto,4) AS monto, 
        tp.tipo_pago AS tipo_pago, us.name AS name, CONCAT(c.cl_nombres,' ',c.cl_apellidos) as cliente, 
        v.created_at as created_at, v.estado_id as estado_id
        FROM recibo_caja v
        INNER JOIN clientes c ON v.cliente_id=c.id
        INNER JOIN tipos_pagos tp ON v.tipo_pago_id=tp.id 
        INNER JOIN users us ON us.id=v.user_id ";

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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clientes = cliente::all();
        return view("recibo_caja.create", compact("clientes"));
    }


    function getFacturas(Request $params,  $cliente) {

        $api_Result = array();
        $today = date("Y/m/d");
        // Create a mapping of our query fields in the order that will be shown in datatable.
        $columnsMapping = array("f.id", "f.total_vale", "c.cliente", "f.created_at");

        // Initialize query (get all)


        $api_logsQueriable = DB::table('vale_maestro');
        $api_Result['recordsTotal'] = $api_logsQueriable->count();

         $query = "SELECT f.id AS id, f.no_vale AS no_vale, TRUNCATE(f.total_vale, 4) AS total_vale,  CONCAT(c.cl_nombres,' ',c.cl_apellidos) as cliente, f.created_at as created_at, f.total_pagado AS total_pagado, f.total_por_pagar AS total_por_pagar, ev.estado_vale AS estado
        FROM vale_maestro f
        INNER JOIN clientes c ON f.cliente_id=c.id INNER JOIN estado_vale ev ON f.estado_vale_id=ev.id ";

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
        $condition = " WHERE f.cliente_id='".$cliente."' and (f.estado_vale_id=1 or f.estado_vale_id=2)  ORDER BY f.id ASC";

        $query = $query . $where . $condition;

        // Sorting
        $sort = "";
        // foreach ($params->order as $order) {
        //     if (strlen($sort) == 0) {
        //         $sort .= 'order by ' . $columnsMapping[$order['column']] . ' '. $order['dir']. ' ';
        //     } else {
        //         $sort .= ', '. $columnsMapping[$order['column']] . ' '. $order['dir']. ' ';
        //     }
        // }

        $result = DB::select($query);
        $api_Result['recordsFiltered'] = count($result);

        $filter = " ";

        $query .= $sort . $filter;

        $result = DB::select($query);
        $api_Result['data'] = $result;

        return Response::json( $api_Result );

    } 


    public function selectNota(Request $request) {

        $data = $request->all();
        $valores = $data["selected"];
        $valore= array_map('trim', explode(',', $data["selected"]));
        $facturas = FacturaCambiariaMaestro::whereIn('id', $valore)->get();
        $cliente = cliente::where('id', $data["cliente_id"])->get()->first();
        $notas = NotaCreditoMaestro::where([
            ['cliente_id', $cliente->id],
            ['tipo_id', 1 ]
            ])
        ->orWhere(
            [
            ['cliente_id', $cliente->id],
            ['tipo_id', 2 ]
            ]
            )->get();




        return view("recibo_caja.nota", compact("cliente",  "series", "valores", "facturas", "notas"));
    }


    public function destroy(ReciboCaja $recibo, Request $request) {
        $user1= Auth::user()->password;

        if ($request["password_delete"] == "")
        {
            $response["password_delete"]  = "La contrase帽a es requerida";
            return Response::json( $response  , 422 );
        }
        else if( password_verify( $request["password_delete"] , $user1))
        {
            $id= $recibo->id;
            $recibo->estado_id = 2;

            $action="Recibo Borrado, c贸digo de Recibo ".$recibo->id." con  ".$recibo->estado_id." de estado 1";
            $bitacora = HomeController::bitacora($action);

            $recibo->save();

            $cuenta_detalle = CuentaCobrarDetalle::where([
                ['tipo_transaccion', 3], 
                ['documento_id', $recibo->id]
                ])->get()->first();

            $cuenta_detalle->estado_cuenta_cobrar_id = 2;
            $cuenta_detalle->save();

            $estado_cuenta_detalle = CuentaCobrarDetalle::where('cuenta_cobrar_maestro_id', $cuenta_detalle->cuenta_cobrar_maestro_id)->orderBy('id', 'desc')->get()->first();

            $cuenta_maestro = CuentaCobrarMaestro::where('id', $cuenta_detalle->cuenta_cobrar_maestro_id)->get()->first();
            
            $detalle_cuenta["tipo_transaccion"] = 5;
            $detalle_cuenta["documento_id"] = $recibo->id;
            $detalle_cuenta["total"] = $recibo->monto;
            $detalle_cuenta["saldo"] = $estado_cuenta_detalle->saldo + $recibo->monto; 
$detalle_cuenta["fecha_documento"] = $recibo->fecha_recibo; 
            $detalle_cuenta["estado_cuenta_cobrar_id"] = 2;
            $detalle_cuenta["user_id"] =  Auth::user()->id;

            $cliente = cliente::where("id", $recibo->cliente_id)->get()->first(); 
            $cliente->cl_saldo = $estado_cuenta_detalle->saldo - $recibo->monto; 
            $cliente->fecha_saldo = $recibo->created_at;
            $cliente->save();

            $cuenta_maestro->cuenta_detalle()->create($detalle_cuenta);

            $recibo_vales = ReciboCajaVale::where("recibo_caja_id", $recibo->id)->get();

            foreach($recibo_vales as $recibo_vale)  {

                $vale = vale_maestro::where("id", $recibo_vale->vale_id)->get()->first();

                if ($vale->total_vale == $recibo_vale->total) {
                    $vale->total_pagado = 0;
                    $vale->total_por_pagar = $vale->total_vale;
                    $vale->estado_vale_id = 1;
                    $vale->save();
                }

                else {
                    $totalP = $vale->total_pagado  - $recibo_vale->total;
                    $vale->total_pagado = $totalP;
                    $vale->total_por_pagar = $vale->total_por_pagar + $recibo_vale->total;
                    if ($vale->total_pagado == 0 ) {
                        $vale->estado_vale_id = 1;
                    }

                    else {
                        $vale->estado_vale_id = 2;
                    }
                    $vale->save();
                }


            }
            $detalles = ReciboCajaVale::where('recibo_caja_id', $recibo->id)->get();
            $user = Auth::user();


            $number2 = number_format($recibo->monto, 2, '.', '');

            $word  = \NumeroALetras::convertir($number2, 'quetzales', 'centavos');
            

            Mail::send('email.recibo', ['recibo' => $recibo, 'user' => $user, 'detalles' => $detalles, 'word' => $word],  function ($m) use ($recibo, $user, $detalles, $word) {

                $m->from('info@vrinfosysgt.com', 'VR InfoSys');

                $m->to("ing.ivargas21314@gmail.com", "Noelia Pazos")->subject('Anulaci贸n de Recibo');

                $response["response"] = "El registro ha sido borrado";
                return Response::json( $response );
            });


        }
        else {
            $response["password_delete"] = "La contraseña no coincide";
            return Response::json( $response  , 422 );
        }
    }



    public function generar(Request $request) {

        $data = $request->all();
        $valores = $data["selected"];
        $valore= array_map('trim', explode(',', $data["selected"]));
        $cliente = cliente::where('id', $data["cliente_id"])->get()->first();
        $bancos = Banco::where('estado_id', 1)->get();
        $tipos_pagos = Tipo_Pago::all();
        $user = Auth::user();

        $estado_cuenta = CuentaCobrarMaestro::where('cliente_id', $data["cliente_id"])->get()->first();

        $estado_cuenta_detalle = CuentaCobrarDetalle::where('cuenta_cobrar_maestro_id', $estado_cuenta->id)->orderBy('id', 'desc')->get()->first();


        $saldo_anterior = $estado_cuenta_detalle->saldo;

        $records = [];
        $total = 0;

        $valecitos = vale_maestro::whereIn("id",  $valore)->whereIn("estado_vale_id", [1,2])->orderBy('id', 'asc')->get();

        foreach ($valecitos as $vale) {
         $total = $total + $vale->total_por_pagar;    
     }

     $saldo_actual  = $saldo_anterior - $total;  
     $total_pagado = $total;

     return view("recibo_caja.generar", compact("records", "cliente", "user", "total", "valores", "bancos", "saldo_anterior", "saldo_actual", "tipos_pagos","total_pagado", "valecitos"));
 }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {
        //

        $data = $request->all();
        $valores = $data["selected"];
        $valore= array_map('trim', explode(',', $data["selected"]));
        $cliente = cliente::where('id', $data["cliente_id"])->get()->first();
        $user = Auth::user();


        $vale_maestros = vale_maestro::whereIn('id', $valore)->whereIn("estado_vale_id", [1,2])->get();

        $estado_cuenta = CuentaCobrarMaestro::where('cliente_id', $data["cliente_id"])->get()->first();

        $estado_cuenta_detalle = CuentaCobrarDetalle::where('cuenta_cobrar_maestro_id', $estado_cuenta->id)->orderBy('id', 'desc')->get()->first();

        $saldo_anterior = $estado_cuenta_detalle->saldo;
        $saldo_actual  = $saldo_anterior - $data["total_pagado"]; 
        
        $dataF["user_id"] = $user->id;
        $dataF["cliente_id"] =  $data["cliente_id"];
        $dataF["banco_id"] = $data["banco_id"];
        $dataF["estado_id"] = 1;
        $dataF["cheque"] = $data["cheque"];
        $dataF["no_recibo_caja"] = $data["no_recibo_caja"];
        $dataF["nit"] = $data["nit"];
        $dataF["monto_pagado"] = $data["total_pagado"];
        $dataF["monto"] = $dataF["monto_pagado"];
$dataF["observaciones"] = $data["observaciones"];
        $dataF["saldo_anterior"] = $saldo_anterior;
        $dataF["saldo_actual"] = $saldo_actual;
        $dataF["tipo_pago_id"] = $data["tipo_pago_id"];

        if ( $dataF["monto"] == 0) {

            $dataF["concepto_id"] = 1;
        }
        else {
            $dataF["concepto_id"] = 2;
        }

        $dataF["fecha_recibo"] = Carbon::createFromFormat('d-m-Y', $data['fecha_recibo']);

        $recibo_caja = ReciboCaja::create($dataF);


        if ($dataF["monto_pagado"] == $data["total_recibo"]) {
            foreach ($vale_maestros as $vale_maestro) {

                $recibo_vale["recibo_caja_id"] = $recibo_caja->id;
                $recibo_vale["vale_id"] = $vale_maestro->id;
                $recibo_vale["total"] = $vale_maestro->total_por_pagar;
                ReciboCajaVale::create($recibo_vale);

                $vale_maestro->estado_vale_id = 3;
                $vale_maestro->total_pagado = $vale_maestro->total_vale;
                $vale_maestro->total_por_pagar = 0;
                $vale_maestro->save();

                
            }


            $detalle_cuenta["tipo_transaccion"] = 3;
            $detalle_cuenta["documento_id"] = $recibo_caja->id;
            $detalle_cuenta["total"] = $dataF["monto_pagado"];
            $detalle_cuenta["fecha_documento"] = $recibo_caja->fecha_recibo;
            $detalle_cuenta["saldo"] = $saldo_actual; 
            $detalle_cuenta["estado_cuenta_cobrar_id"] = 1;
            $detalle_cuenta["user_id"] =  Auth::user()->id;



            $cliente->cl_saldo = $saldo_actual; 
            $cliente->fecha_saldo = $recibo_caja->created_at;
            $cliente->save();

            $estado_cuenta->cuenta_detalle()->create($detalle_cuenta);

        }

        else { 
            $suma = 0;
            $diferencia = 0;
            foreach ($vale_maestros as $vale_maestro) {

                $diferencia = $dataF["monto_pagado"] - $suma;

                if ($diferencia > 0) {

                    if ($diferencia > $vale_maestro->total_por_pagar) {
                        $vale_maestro->estado_vale_id = 3;
                        $suma = $suma + $vale_maestro->total_por_pagar;


                        $vale_maestro->total_pagado = $vale_maestro->total_vale;
                        $vale_maestro->total_por_pagar = 0;

                        $recibo_vale3["recibo_caja_id"] = $recibo_caja->id;
                        $recibo_vale3["vale_id"] = $vale_maestro->id;
                        $recibo_vale3["total"] = $vale_maestro->total_vale;
                        ReciboCajaVale::create($recibo_vale3);


                        $vale_maestro->save();
                        
                    }

                    else {
                        $vale_maestro->estado_vale_id = 2;
                        if ($vale_maestro->total_pagado == 0) {
                            $vale_maestro->total_pagado = $diferencia;
                        }
                        else {
                            $vale_maestro->total_pagado = $vale_maestro->total_pagado + $diferencia;
                        }


                        $vale_maestro->total_por_pagar = $vale_maestro->total_vale - $vale_maestro->total_pagado;

                        $recibo_vale2["recibo_caja_id"] = $recibo_caja->id;
                        $recibo_vale2["vale_id"] = $vale_maestro->id;
                        $recibo_vale2["total"] = $vale_maestro->total_pagado;
                        ReciboCajaVale::create($recibo_vale2);


                        $vale_maestro->save();
                        $suma = $suma + $diferencia;
                    }

                }
            }

            $saldo_actual  = $saldo_anterior - $dataF["monto_pagado"]; 

            $detalle_cuenta["tipo_transaccion"] = 3;
            $detalle_cuenta["documento_id"] = $recibo_caja->id;
            $detalle_cuenta["total"] = $dataF["monto_pagado"];
            $detalle_cuenta["fecha_documento"] = $recibo_caja->fecha_recibo;
            $detalle_cuenta["saldo"] = $saldo_actual; 
            $detalle_cuenta["estado_cuenta_cobrar_id"] = 1;
            $detalle_cuenta["user_id"] =  Auth::user()->id;

            $cliente->cl_saldo = $saldo_actual; 
            $cliente->fecha_saldo = $recibo_caja->created_at;
            $cliente->save();

            $estado_cuenta->cuenta_detalle()->create($detalle_cuenta);


        }

        return $recibo_caja;

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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
}
