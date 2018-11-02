<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
Use App\User;
Use App\Serie;
Use App\Factura;
use App\TipoPago;

class FacturasController extends Controller
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
        return view ("facturas.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $user = Auth::user()->id;
       $series = Serie::all();
       $pagos = TipoPago::all();
       
       return view("facturas.create" , compact( "user", "series","pagos",'fecha'));
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
               
        $factura = Factura::create($data);

        return Response::json($factura);
    }
    public function savec(Request $request)
    {       
        $query='SELECT F.numero as numero from facturas F order by F.id DESC limit 1';
        $fieldsArray = DB::select($query);
      
        $numero=$fieldsArray[0]->numero;
        
        $data = $request->all();
        $data["user_id"] = Auth::user()->id;
        $data["numero"] = $numero+1;        
        $factura = Factura::create($data);

        return Response::json($factura);
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
    public function edit(Factura $factura)
    {
        $query = "SELECT * FROM facturas WHERE id=".$factura->id."";
        $fieldsArray = DB::select($query);
        $series = Serie::all();
        $pagos = TipoPago::all();
        return view('facturas.edit', compact('factura', 'fieldsArray', 'series','pagos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Factura $factura, Request $request)
    {
        
        Response::json( $this->updateFactura($factura , $request->all()));
        return redirect('/factura');
    }

    public function updateFactura(Factura $factura, array $data )
    {
        $id= $factura->id;
        $factura->numero = $data["numero"];
        $factura->fecha = $data["fecha"];    
        $factura->serie_id = $data["serie_id"];
        $factura->total = $data["total"];
        $factura->voucher = $data["voucher"];
        $factura->tipo_pago_id= $data["tipo_pago_id"];
        $factura->save();

        return $factura;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Factura $factura, Request $request)
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
            $factura->delete();
            
            $response["response"] = "La factura ha sido eliminada";
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
        $columnsMapping = array("id", "numero");

        // Initialize query (get all)

        $api_logsQueriable = DB::table('facturas');
        $api_Result['recordsTotal'] = $api_logsQueriable->count();

        
        $query = "SELECT F.voucher,F.id, F.numero, F.fecha,  F.total, S.serie as serie, TP.tipo_pago as pago
        from facturas F
        INNER JOIN series S on S.id = F.serie_id 
        INNER JOIN tipos_pago TP on TP.id = F.tipo_pago_id ";

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
