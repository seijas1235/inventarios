<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use DB;
use View;
use Illuminate\Http\Request;
use App\Bitacora;
use App\cliente;
use App\vale_maestro;
use App\Bloqueo_Diario;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class HomeController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{

		$clientes_bloqueados = cliente::where('estado_cliente_id', 4)->count();
		$vales = vale_maestro::where("estado_vale_id", 1)->count();
		$clientes_bloqueados2 = cliente::where('estado_cliente_id', 4)->limit(5)->get();
		$vales2 = vale_maestro::where("estado_vale_id", 1)->whereDate('created_at', '=', Carbon::now()->format('Y-m-d'))->orderBy('id', 'DESC')->limit(5)->get();

		$queryvales = "SELECT DATE_FORMAT(fecha_corte,'%d') as Fecha, COUNT(*) as Total_Vales, SUM(total_vale) as Total_Diario
		FROM vale_maestro
		WHERE MONTH(fecha_corte) = MONTH(Sysdate()) AND estado_vale_id <4
		GROUP BY DATE_FORMAT(fecha_corte,'%d')";
		$resultsvales = DB::select($queryvales);
		
		$queryrecibos = "SELECT DATE_FORMAT(fecha_recibo,'%d') as FechaR, COUNT(*) as Total_RecibosR, SUM(monto) as Total_DiarioR
		FROM recibo_caja
		WHERE MONTH(fecha_recibo) = MONTH(Sysdate())
		GROUP BY DATE_FORMAT(fecha_recibo,'%d')";
		$resultsrecibos = DB::select($queryrecibos);

		$date = Carbon::now();
		$mes = $date->format('F');

		return view('home', compact('clientes_bloqueados', 'vales', 'clientes_bloqueados2', 'vales2', 'resultsvales', 'resultsrecibos', 'mes'));
	}


	public function bloqueo()
	{
		$query = "SELECT cl.id as cod_cliente, CONCAT(cl.cl_nombres,' ',cl.cl_apellidos) as Nombre, SUM(total_vale) as Total, 
		cl.cl_montomaximo as Maximo, (cl.cl_montomaximo - SUM(total_vale)) as Diferencia
		FROM vale_maestro vm
		INNER JOIN clientes cl ON cl.id=vm.cliente_id
		GROUP BY cliente_id";
		$res = DB::select($query);

		foreach($res as $datos){
			if($datos->Diferencia<0)
			{
				$updates = DB::table('clientes')
				->where('id', '=', $datos->cod_cliente)
				->update([
					'estado_cliente_id' => '4',
					]);

				$data['fecha'] = date("Y/m/d");
				$data['cliente_id'] = $datos->cod_cliente;
				$data['accion'] = "Bloqueo de Usuario de forma Automática";
				$data['razon'] = "Bloqueo de Usuario por sobrepasar el límite de crédito";
				$data['user_id'] = Auth::user()->id;
				$dats = Bloqueo_Diario::create($data);
				return $dats;
			}  
		}


		$query2 = "SELECT vm.cliente_id as cod_cliente, vm.id as Num_Vale, vm.created_at as fecha_vale, 
		DATEDIFF(sysdate(),date(vm.created_at)) as Dias, tc.dias as TDias, 
		(DATEDIFF(sysdate(),date(vm.created_at)))-tc.dias as Diferencia
		FROM vale_maestro vm
		INNER JOIN clientes cl ON cl.id=vm.cliente_id
		INNER JOIN tipo_cliente tc ON tc.id=cl.tipo_cliente_id
		ORDER BY vm.cliente_id, vm.id, vm.created_at ASC";
		$res2 = DB::select($query2);

		foreach($res2 as $datos2){
			if($datos2->Diferencia>0)
			{
				$updates2 = DB::table('clientes')
				->where('id', '=', $datos2->cod_cliente)
				->update([
					'estado_cliente_id' => '4',
					]);
				

				$updates3 = DB::table('vale_maestro')
				->where('id', '=', $datos2->Num_Vale)
				->update([
					'estado_vale_id' => '5',
					]);


				$data2['fecha'] = date("Y/m/d");
				$data2['cliente_id'] = $datos2->cod_cliente;
				$data2['accion'] = "Bloqueo de Usuario de forma Automática";
				$data2['razon'] = "Bloqueo de Usuario por atraso en pago de vales";
				$data2['user_id'] = Auth::user()->id;
				$dats2 = Bloqueo_Diario::create($data2);
				return $dats2;   
			}
		}
	}      




	public static function bitacora($action)
	{
		$datos['user_id'] = Auth::user()->id;
		$datos['accion'] = $action;
		$data = Bitacora::create($datos);
		return $data;
	}


}
