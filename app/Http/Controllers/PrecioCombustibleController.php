<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use App\combustible;
use App\bomba;
use App\User;
use App\precio_combustible;

class PrecioCombustibleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("precio_combustible.index");
    }

    public function getPrecio(combustible $combustible) {

        $precio_combustible = precio_combustible::where("combustible_id", $combustible->id)->orderBy('id', 'desc')->get()->first();
        return Response::json($precio_combustible);
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
        $combustibles = Combustible::all();
        return view("precio_combustible.create" , compact( "user","today", "combustibles"));
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
        $precio = precio_combustible::create($data);

        $action="PrecioCombustible Creado, código ".$precio->id;
        $bitacora = HomeController::bitacora($action);

        return Response::json($precio);
    }


    public function getJson(Request $params)
    {
        $api_Result = array();
        // Create a mapping of our query fields in the order that will be shown in datatable.
        $columnsMapping = array("pc.id", "pc.precio_venta","pc.precio_compra","c.combustible","pc.created_at");

        // Initialize query (get all)

        $api_logsQueriable = DB::table('precio_combustible');
        $api_Result['recordsTotal'] = $api_logsQueriable->count();

        $query = 'SELECT pc.id as id, pc.precio_venta as precio_venta, pc.precio_compra as precio_compra, c.combustible as combustible, pc.created_at as created_at FROM precio_combustible pc inner join combustible c ON pc.combustible_id=c.id  ';

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


    public function edit(precio_combustible $precio_combustible)
    {

        $combustibles = combustible::all();
        return view('precio_combustible.edit', compact('precio_combustible', "combustibles"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(precio_combustible $precio_combustible, Request $request)
    {
        Response::json( $this->updatePrecio($precio_combustible , $request->all()));
        return redirect('/precio_combustible');
    }

    public function updatePrecio(precio_combustible $precio_combustible, array $data )
    {
        $action="precio editado, codigo ".$precio_combustible->id." datos anteriores: ".$precio_combustible->precio_compra.",".$precio_combustible->precio_venta.",".$precio_combustible->combustible_id. "datos nuevos: ".$data["precio_compra"].$data["precio_venta"].$data["combustible_id"]."";
        $bitacora = HomeController::bitacora($action);

        $precio_combustible->precio_venta = $data["precio_venta"];
        $precio_combustible->precio_compra = $data["precio_compra"];
        $precio_combustible->combustible_id = $data["combustible_id"];
        $precio_combustible->save();

        return $precio_combustible;
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
}
