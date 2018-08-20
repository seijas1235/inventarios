<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\cupones;
use App\User;

class CuponesController extends Controller
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
        return view("cupones.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("cupones.create");
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
      $cupones = cupones::create($data);

      $action="Cupon de combustible creado, código ".$cupones->id;
      $bitacora = HomeController::bitacora($action);

      return Response::json($cupones);
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
    public function edit(cupones $cupon)
    {
       $query = "SELECT * FROM cupones WHERE id=".$cupon->id."";
       $fieldsArray = DB::select($query);

       return view('cupones.edit', compact('fieldsArray', 'cupon'));
   }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(cupones $cupon, Request $request)
    {
       Response::json( $this->updateCupon($cupon , $request->all()));
       return redirect('/cupones');
   }

   public function updateCupon(cupones $cupon, array $data )
   {
    $action="Cupones de Combustible Editado, código ".$cupon->id."; datos anteriores: ".$cupon->fecha_corte.",".$cupon->codigo_corte.",".$cupon->no_cupon.",".$cupon->codigo_cliente.",".$cupon->nombre_cliente.",".$cupon->monto."; datos nuevos ".$data["fecha_corte"].", ".$data["codigo_corte"].", ".$data["no_cupon"].", ".$data["codigo_cliente"].",".$data["nombre_cliente"].",".$data["monto"]."";
    $bitacora = HomeController::bitacora($action);

    $cupon->fecha_corte = $data["fecha_corte"];
    $cupon->codigo_corte = $data["codigo_corte"];
    $cupon->no_cupon = $data["no_cupon"];
    $cupon->codigo_cliente = $data["codigo_cliente"];
    $cupon->nombre_cliente = $data["nombre_cliente"];
    $cupon->monto = $data["monto"];
    $cupon->observaciones = $data["observaciones"];
    $cupon->user_id = Auth::user()->id;
    $cupon->save();
    return $cupon;
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(cupones $cupon, Request $request)
    {
        $user1= Auth::user()->password;

        if ($request["password_delete"] == "")
        {
            $response["password_delete"]  = "La contraseña es requerida";
            return Response::json( $response  , 422 );
        }
        else if( password_verify( $request["password_delete"] , $user1))
        {
            $action="Cupon de combustible PUMA Borrado, codigo ".$cupon->id." y datos ".$cupon->fecha_corte.",".$cupon->no_cupon.",".$cupon->monto.",".$cupon->nombre_cliente.",".$cupon->user_id."";
            $bitacora = HomeController::bitacora($action);

            $cupon->delete();

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
        $columnsMapping = array("id", "fecha_corte", "codigo_corte", "no_cupon", "codigo_cliente", "nombre_cliente", "monto");

        // Initialize query (get all)

        $api_logsQueriable = DB::table('cupones');
        $api_Result['recordsTotal'] = $api_logsQueriable->count();

        $query = 'SELECT * FROM cupones ';

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
        $condition = " WHERE estado = 1 ";
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
