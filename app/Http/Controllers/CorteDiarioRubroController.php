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
use App\corte_diario;
use App\corte_diario_rubro;
use Illuminate\Support\Facades\Input;

class CorteDiarioRubroController extends Controller
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
        return view("corte_diario_rubro.index");
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
        return view("corte_diario_rubro.create" , compact( "user","today"));
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
        $cdr = corte_diario_rubro::create($data);

        $action="Rubro de corte diario creado, código ".$cdr->id;
        $bitacora = HomeController::bitacora($action);

        return Response::json($cdr);
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
    public function edit(corte_diario_rubro $rubro)
    {
        return view('corte_diario_rubro.edit', compact('rubro'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(corte_diario_rubro $rubro, Request $request)
    {
        Response::json( $this->updateCDRubro($rubro , $request->all()));
        return redirect('/cdrubros');
    }

    public function updateCDRubro(corte_diario_rubro $rubro, array $data )
    {
        $action="Rubro Editado, código ".$rubro->id."; datos anteriores: ".$rubro->rubro;
        $bitacora = HomeController::bitacora($action);

        $rubro->rubro = $data["rubro"];
        $rubro->save();

        return $rubro;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(corte_diario_rubro $rubro, Request $request)
    {
         $user1= Auth::user()->password;

        if ($request["password_delete"] == "")
        {
            $response["password_delete"]  = "La contraseña es requerida";
            return Response::json( $response  , 422 );
        }
        else if( password_verify( $request["password_delete"] , $user1))
        {
            $action="Rubro Borrado, codigo ".$rubro->id." y datos ".$rubro->rubro."";
            $bitacora = HomeController::bitacora($action);

            $rubro->delete();

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
        $columnsMapping = array("id", "rubro", "created_at");

        // Initialize query (get all)

        $api_logsQueriable = DB::table('corte_diario_rubro');
        $api_Result['recordsTotal'] = $api_logsQueriable->count();

        $query = "SELECT * FROM corte_diario_rubro ";

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
