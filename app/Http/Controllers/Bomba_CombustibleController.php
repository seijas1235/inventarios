<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\bomba;
use App\combustible;
use App\Bomba_Combustible;
use App\User;

class Bomba_CombustibleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view("bombas_combustibles.index");
    }

    public function create()
    {
        $user = Auth::user()->id;
        $today = date("Y/m/d");
        $bombas = bomba::all();
        $combustibles = combustible::all();
        return view("bombas_combustibles.create" , compact( "user","today","bombas","combustibles"));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data["user_id"] = Auth::user()->id;
        $bomba_combustible = Bomba_Combustible::create($data);

        $action="Bomba_Combustible Creado, código ".$bomba_combustible->bomba_id.", combustible ".$bomba_combustible->combustible_id;
        $bitacora = HomeController::bitacora($action);

        return Response::json($bomba_combustible);
    }


    public function edit(Bomba_Combustible $bomba_combustible)
    {
        $query = "SELECT * FROM bomba_combustible WHERE id=".$bomba_combustible->id;
        $fieldsArray = DB::select($query);
        $combustibles = combustible::all();
        $bombas = bomba::all();

        return view('bombas_combustibles.edit', compact('bomba_combustible','fieldsArray','bombas','combustibles'));
    }


    public function update(Bomba_Combustible $bomba_combustible, Request $request)
    {
        Response::json( $this->updateBombaCombustible($bomba_combustible, $request->all()));
        return redirect('/bombas_combustibles');
    }

    public function updateBombaCombustible(Bomba_Combustible $bomba_combustible, array $data )
    {
        $action="Bomba y Combustible Editada, código ".$bomba_combustible->id."; datos anteriores: ".$bomba_combustible->bomba_id." combustible ".$bomba_combustible->combustible_id;
        $bitacora = HomeController::bitacora($action);

        $bomba_combustible->bomba_id = $data["bomba_id"];
        $bomba_combustible->combustible_id = $data["combustible_id"];
        $bomba_combustible->save();

        return $bomba_combustible;
    }



    public function destroy(Bomba_Combustible $bomba_combustible, Request $request)
    {
        $user1= Auth::user()->password;

        if ($request["password_delete"] == "")
        {
            $response["password_delete"]  = "La contraseña es requerida";
            return Response::json( $response  , 422 );
        }
        else if( password_verify( $request["password_delete"] , $user1))
        {
            $action="Bomba Combustible Borrada, codigo ".$bomba_combustible->id." y datos ".$bomba_combustible->bomba_id.", ".$bomba_combustible->combustible_id."";
            $bitacora = HomeController::bitacora($action);

            $bomba_combustible->delete();

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
        $columnsMapping = array("id", "bomba", "combustible");

        // Initialize query (get all)

        $api_logsQueriable = DB::table('bomba_combustible');
        $api_Result['recordsTotal'] = $api_logsQueriable->count();

        $query = 'SELECT bc.id as id, bm.bomba as bomba, cm.combustible as combustible FROM bomba_combustible bc INNER JOIN bomba bm ON bm.id=bc.bomba_id INNER JOIN combustible cm ON cm.id=bc.combustible_id ';

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
