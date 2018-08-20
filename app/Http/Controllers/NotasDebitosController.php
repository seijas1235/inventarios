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
use App\nota_debito;
use App\cliente;
use App\CuentaCobrarMaestro;
use App\CuentaCobrarDetalle;
use App\user;
use Barryvdh\DomPDF\Facade as PDF;
use Mail;

class NotasDebitosController extends Controller
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
        return view("nota_debito.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clientes = cliente::all();

        return view("nota_debito.create" , compact( "clientes"));
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
        $data["estado"] = 1;
        $data["anio"] = 2018;

        $nota_debito = nota_debito::create($data);
        $cliente = cliente::where("id", $data["cliente_id"])->get()->first();

        $estado_cuenta = CuentaCobrarMaestro::where('cliente_id', $data["cliente_id"])->get()->first();

        
        if(count($estado_cuenta) != 0) {
            $estado_cuenta_detalle = CuentaCobrarDetalle::where('cuenta_cobrar_maestro_id', $estado_cuenta->id)->orderBy('id', 'desc')->get()->first();

            $detalle_cuenta["tipo_transaccion"] = 7;
            $detalle_cuenta["documento_id"] = $nota_debito->id;
            $detalle_cuenta["total"] = $nota_debito->total;
            $detalle_cuenta["fecha_documento"] = $data["fecha"];
            $detalle_cuenta["saldo"] = $estado_cuenta_detalle->saldo + $nota_debito->total; 
            $detalle_cuenta["estado_cuenta_cobrar_id"] = 1;
            $detalle_cuenta["user_id"] =  Auth::user()->id;

            $estado_cuenta->cuenta_detalle()->create($detalle_cuenta);

        }

        else {

            $new_estado['cliente_id'] = $nota_debito->cliente_id;
            $new_estado['user_id'] = Auth::user()->id;
            $new_estado['estacion_id'] = 1;
            $new_estado['estado_cuenta_cobrar_id'] = 1;
            $estado_cuenta = CuentaCobrarMaestro::create($new_estado);

            $detalle_cuenta["tipo_transaccion"] = 7;
            $detalle_cuenta["documento_id"] = $nota_debito->id;
            $detalle_cuenta["total"] = $nota_debito->total;
            $detalle_cuenta["fecha_documento"] = $data["fecha"];
            $detalle_cuenta["saldo"] = $nota_debito->total; 
            $detalle_cuenta["estado_cuenta_cobrar_id"] = 1;
            $detalle_cuenta["user_id"] =  Auth::user()->id;

            $estado_cuenta->cuenta_detalle()->create($detalle_cuenta);

        }

        $action="Nota de Débito creada, código ".$nota_debito->id;
        $bitacora = HomeController::bitacora($action);

        return Response::json($nota_debito);
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
    public function edit(nota_debito $nota_debito)
    {
        $clientes = cliente::all();

        $query = "SELECT * FROM notas_debitos WHERE id=".$nota_debito->id."";
        $fieldsArray = DB::select($query);

        return view("nota_debito.edit" , compact( "clientes", "nota_debito", "fieldsArray"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(nota_debito $nota_debito, Request $request)
    {
        Response::json( $this->updateNotaDebito($nota_debito , $request->all()));
        return redirect('/nota_debito2');
    }

    public function updateNotaDebito(nota_debito $nota_debito, array $data )
    {
        $action="Registro de nota de débito Editado, código ".$nota_debito->id."; datos anteriores: ".$nota_debito->fecha.",".$nota_debito->total.",".$nota_debito->cliente_id.",".$nota_debito->descripcion."; datos nuevos ".$data["fecha"].", ".$data["total"].", ".$data["cliente_id"].",".$data["descripcion"]."";
        $bitacora = HomeController::bitacora($action);

        $nota_debito->fecha = $data['fecha'];
        $nota_debito->total = $data["total"];
        $nota_debito->descripcion = $data["descripcion"];
        $nota_debito->cliente_id = $data["cliente_id"];
        $nota_debito->user_id = Auth::user()->id;
        $nota_debito->save();

        $cuentas_detalle = CuentaCobrarDetalle::where("documento_id",$nota_debito->id)->where("tipo_transaccion",7)->get()->first();
        $cuentas_maestro = CuentaCobrarMaestro::where("cliente_id",$nota_debito->cliente_id)->get()->first();
        
        $cuentas_detalle->total = $data["total"];
        $cuentas_detalle->cuenta_cobrar_maestro_id = $cuentas_maestro->id;
        $cuentas_detalle->fecha_documento = $data["fecha"];
        $cuentas_detalle->save();

        return $nota_debito;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(nota_debito $nota_debito, Request $request) {
        $user1= Auth::user()->password;

        if ($request["password_delete"] == "")
        {
            $response["password_delete"]  = "La contraseña es requerida";
            return Response::json( $response  , 422 );
        }
        else if( password_verify( $request["password_delete"] , $user1))
        {
            $id= $nota_debito->id;
            $nota_debito->estado = 2;

            $action="Nota de Débito Borrado, código de Nota ".$nota_debito->id." ";
            $bitacora = HomeController::bitacora($action);

            $nota_debito->save();

            $cuenta_detalle = CuentaCobrarDetalle::where([
                ['tipo_transaccion', 7], 
                ['documento_id', $nota_debito->id]
                ])->get()->first();

            $cuenta_detalle->estado_cuenta_cobrar_id = 2;
            $cuenta_detalle->save();

            $estado_cuenta_detalle = CuentaCobrarDetalle::where('cuenta_cobrar_maestro_id', $cuenta_detalle->cuenta_cobrar_maestro_id)->orderBy('id', 'desc')->get()->first();

            $cuenta_maestro = CuentaCobrarMaestro::where('id', $cuenta_detalle->cuenta_cobrar_maestro_id)->get()->first();
            
            $detalle_cuenta["tipo_transaccion"] = 8;
            $detalle_cuenta["documento_id"] = $nota_debito->id;
            $detalle_cuenta["total"] = $nota_debito->total;
            $detalle_cuenta["saldo"] = $estado_cuenta_detalle->saldo - $nota_debito->total;
            $detalle_cuenta["fecha_documento"] = $nota_debito->fecha; 
            $detalle_cuenta["estado_cuenta_cobrar_id"] = 2;
            $detalle_cuenta["user_id"] =  Auth::user()->id;

            $cuenta_maestro->cuenta_detalle()->create($detalle_cuenta);


            $detalles = nota_debito::where('id', $nota_debito->id)->get();
            $user = Auth::user();

            $number2 = number_format($nota_debito->total, 2, '.', '');

            $word  = \NumeroALetras::convertir($number2, 'quetzales', 'centavos');
            
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
        $columnsMapping = array("nc.id", "nc.fecha", "cl.cl_nombres", "cl.cl_apellidos", "nc.total", "us.name", "nc.created_at");

        // Initialize query (get all)

        $api_logsQueriable = DB::table('notas_debitos');
        $api_Result['recordsTotal'] = $api_logsQueriable->count();

        $query = "SELECT nc.id as id, nc.fecha as fecha, CONCAT(cl.cl_nombres,' ',cl.cl_apellidos) as cliente, nc.total as total, us.name as usuario, nc.created_at as fechac
        FROM notas_debitos nc
        INNER JOIN clientes cl ON nc.cliente_id = cl.id INNER JOIN users us ON us.id=nc.user_id ";

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
        $condition = " WHERE nc.estado = 1  ";
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
