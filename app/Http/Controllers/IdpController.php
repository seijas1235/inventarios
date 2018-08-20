<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\combustible;
use App\User;
use App\idp;

class IdpController extends Controller
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
        return view("idp.index");
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
        return view("idp.create" , compact( "user","today", "combustibles"));
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
        $idp = idp::create($data);

        $action="IDP Creado, código ".$idp->id;
        $bitacora = HomeController::bitacora($action);

        return Response::json($idp);
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
    public function edit(idp $idp)
    {
        $query = "SELECT * FROM idps WHERE id=".$idp->id."";
        $fieldsArray = DB::select($query);
        $combustibles = Combustible::all();
        return view('idp.edit', compact('idp', 'fieldsArray', "combustibles"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   public function update(idp $idp, Request $request)
    {
        Response::json( $this->updateIDP($idp , $request->all()));
        return redirect('/idp');
    }

    public function updateIDP(idp $idp, array $data )
    {
        $user = Auth::user()->id;

        $action="IDP editado, codigo ".$idp->id." datos anteriores: ".$idp->combustible_id.",".$idp->costo_idp.",".$idp->user_id." datos nuevos: ".$data["combustible_id"].$data["costo_idp"].$user."";
        $bitacora = HomeController::bitacora($action);

        $idp->combustible_id = $data["combustible_id"];
        $idp->costo_idp = $data["costo_idp"];
        $idp->user_id = $user;
        $idp->save();

        return $idp;
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(idp $idp, Request $request)
    {
        $user1= Auth::user()->password;

        if ($request["password_delete"] == "")
        {
            $response["password_delete"]  = "La contraseña es requerida";
            return Response::json( $response  , 422 );
        }
        else if( password_verify( $request["password_delete"] , $user1))
        {
            $id= $idp->id;

            $action="IDP Borrado, código ".$idp->id.",".$idp->combustible_id.",".$idp->costo_idp.",".$idp->user_id." borrado por ".$user1."";
            $bitacora = HomeController::bitacora($action);

            $idp->delete();
            
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
        $columnsMapping = array("idp.id", "idp.created_at","cmb.combustible","idp.costo_idp", "us.name");

        // Initialize query (get all)

        $api_logsQueriable = DB::table('idps');
        $api_Result['recordsTotal'] = $api_logsQueriable->count();

        $query = 'SELECT idp.id as id, idp.created_at as fecha, cmb.combustible as comb, 
        idp.costo_idp as costo, us.name as usuario 
        FROM idps idp 
        INNER JOIN combustible cmb ON idp.combustible_id=cmb.id
        INNER JOIN users us ON us.id = idp.user_id';

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
