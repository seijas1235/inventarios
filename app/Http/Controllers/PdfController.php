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
use App\vale_maestro;
use App\vale_detalle;
use App\cliente;
use App\Cuenta;
use App\combustible;
use App\empleado;
use App\producto;
use App\bomba;
use App\user;
use App\estado_vale;
use App\meses;
use App\saldos_clientes;
use App\precio_combustible;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade as PDF;
use Maatwebsite\Excel\Facades\Excel;

class PdfController extends Controller
{


    public function pdf_vales(Request $request) 
    {
        $datas = $request->all();
        $fec = $datas["fecha_vale"];
        $us = $datas["userslst"];
        
        Excel::create('Vales por Fecha y Cliente', function($excel) use ($fec, $us) {
            $excel->sheet('Vales', function($sheet) use ($fec, $us) {

                $clientes = $this->getDataVales($fec,$us);
                $json  = json_encode($clientes);
                $body = json_decode($json, true);
                $sheet->fromArray($body, null, 'A1', true);

            });
        })->export('xls');
    }

    public function rpt_lad(Request $request) 
    {
        return view("reportes.listado_abono_diario");
    }

    public function rpt_xls_lad(Request $request) 
    {
        $data = $request->all();
        $datas = Carbon::parse($data['fecha'])->format('Y-m-d');
        
        Excel::create('Listado de Abonos Diarios', function($excel) use ($datas) {
            $excel->sheet('Listado', function($sheet) use ($datas) {
                $abonos = $this->getData_XLS_LAD($datas);
                $json  = json_encode($abonos);
                $body = json_decode($json, true);
                $sheet->fromArray($body, null, 'A1', true);
            });
        })->export('xls');
    }

    public function getData_XLS_LAD($fec) 
    {
        $query_xls_lad = "SELECT rc.fecha_recibo as fecha, rc.id as no_recibocaja, CONCAT(cl.cl_nombres,' ',cl.cl_apellidos) as cliente, 
        tp.tipo_pago, rc.monto as abono
        FROM recibo_caja rc
        INNER JOIN clientes cl ON rc.cliente_id = cl.id
        INNER JOIN tipos_pagos tp ON rc.tipo_pago_id=tp.id
        WHERE CAST(rc.created_at AS date) = '".$fec."' ";

        $rpt_xls_lad = DB::select($query_xls_lad);
        return $rpt_xls_lad;
    }

    public function rpt_pdf_lad(Request $request) 
    {
        $data = $request->all();
        $fecha = Carbon::parse($data['fecha'])->format('Y-m-d');
        
        $query = "SELECT SUM( rc.monto) as Total
        FROM recibo_caja rc
        INNER JOIN clientes cl ON rc.cliente_id = cl.id
        INNER JOIN tipos_pagos tp ON rc.tipo_pago_id=tp.id
        WHERE CAST(rc.fecha_recibo AS date) = '".$fecha."' ";
        $total = DB::select($query);

        $data = $this->getData_PDF_LAD($fecha);
        $user = Auth::user()->name;
        $today = Carbon::now();
        $view =  \View::make('pdf.pdf_lad', compact('data', 'user', 'today', 'total', 'fecha'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('PDF_LAD', array("Attachment" => 0));
    }

    public function getData_PDF_LAD($fec) 
    {
        $query = "SELECT rc.fecha_recibo as fecha, rc.no_recibo_caja as no_recibocaja, CONCAT(cl.cl_nombres,' ',cl.cl_apellidos) as cliente, 
        tp.tipo_pago, rc.cheque as no_cheque_boleta, rc.monto as abono
        FROM recibo_caja rc
        INNER JOIN clientes cl ON rc.cliente_id = cl.id
        INNER JOIN tipos_pagos tp ON rc.tipo_pago_id=tp.id
        WHERE CAST(rc.fecha_recibo AS date) = '".$fec."' ";
        $pdf_lad = DB::select($query);
        return $pdf_lad;
    }




    public function rpt_lvd(Request $request) 
    {
        return view("reportes.listado_vales_diarios");
    }

    public function rpt_xls_lvd(Request $request) 
    {
        $data = $request->all();
        $datas = Carbon::parse($data['fechav'])->format('Y-m-d');
        
        Excel::create('Listado de Vales Diarios', function($excel) use ($datas) {
            $excel->sheet('Listado', function($sheet) use ($datas) {
                $vales = $this->getData_XLS_LVD($datas);
                $json  = json_encode($vales);
                $body = json_decode($json, true);
                $sheet->fromArray($body, null, 'A1', true);
            });
        })->export('xls');
    }

    public function getData_XLS_LVD($fec) 
    {
        $query_xls_lvd = "SELECT vd.vale_maestro_id as No_Vale, CONCAT(cl.cl_nombres,' ',cl.cl_apellidos) as Cliente, 
        cm.combustible as Tipo_Combustible, vd.subtotal as Cargo
        FROM vale_maestro vm
        INNER JOIN vale_detalle vd ON vm.id=vd.vale_maestro_id
        INNER JOIN clientes cl ON vm.cliente_id=cl.id
        INNER JOIN combustible cm ON vd.combustible_id=cm.id
        WHERE CAST(vm.created_at AS date) = '".$fec."' ";

        $rpt_xls_lvd = DB::select($query_xls_lvd);
        return $rpt_xls_lvd;
    }

     public function rpt_pdf_lvd(Request $request) 
    {
        $data = $request->all();
        $fecha = Carbon::parse($data['fecha'])->format('Y-m-d');
        
        $query = "SELECT  SUM(total_vale) as Total
        FROM vale_maestro
        WHERE CAST(fecha_corte AS date) = '".$fecha."' AND estado_vale_id < 4 ";
        $total = DB::select($query);

        $data = $this->getData_PDF_LVD($fecha);
        $user = Auth::user()->name;
        $today = Carbon::now();
        $view =  \View::make('pdf.pdf_lvd', compact('data', 'user', 'today', 'total', 'fecha'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('PDF_LVD', array("Attachment" => 0));
    }

    public function getData_PDF_LVD($fec) 
    {
        $query = "SELECT vm.no_vale as No_Vale, CONCAT(cl.cl_nombres,' ',cl.cl_apellidos) as Cliente, IF(vd.combustible_id >0,cm.combustible, pro.nombre)  as Tipo_Combustible, vd.subtotal as Cargo, vm.piloto as piloto, vm.fecha_corte FROM vale_maestro vm INNER JOIN vale_detalle vd ON vm.id=vd.vale_maestro_id INNER JOIN clientes cl ON vm.cliente_id=cl.id LEFT JOIN combustible cm ON vd.combustible_id=cm.id LEFT JOIN productos pro ON vd.producto_id=pro.id
        WHERE CAST(vm.fecha_corte AS date) = '".$fec."' AND vm.estado_vale_id <4 ORDER BY vm.no_vale ASC ";
        $pdf_lvd = DB::select($query);
        return $pdf_lvd;
    }





    public function rpt_lvc(Request $request) 
    {
        $clientes = Cliente::all();

        return view("reportes.listado_vales_clientes", compact("clientes"));
    }

    public function rpt_xls_lvc(Request $request) 
    {
        $data = $request->all();
        $fec1 = Carbon::parse($data['fechainicio'])->format('Y-m-d');
        $fec2 = Carbon::parse($data['fechafinal'])->format('Y-m-d');
        $cliente = $data["cliente_id"];
        
        Excel::create('Listado de Vales por Cliente', function($excel) use ($fec1, $fec2, $cliente) {
            $excel->sheet('Listado', function($sheet) use ($fec1, $fec2, $cliente) {
                $valespc = $this->getData_XLS_LVC($datas);
                $json  = json_encode($valespc);
                $body = json_decode($json, true);
                $sheet->fromArray($body, null, 'A1', true);
            });
        })->export('xls');
    }

    public function getData_XLS_LVC($fec1, $fec2, $cliente) 
    {
        $query_xls_lvd = "SELECT vd.vale_maestro_id as No_Vale, CONCAT(cl.cl_nombres,' ',cl.cl_apellidos) as Cliente, 
        cm.combustible as Tipo_Combustible, vd.subtotal as Cargo
        FROM vale_maestro vm
        INNER JOIN vale_detalle vd ON vm.id=vd.vale_maestro_id
        INNER JOIN clientes cl ON vm.cliente_id=cl.id
        INNER JOIN combustible cm ON vd.combustible_id=cm.id
        WHERE (CAST(vm.created_at as date) BETWEEN '".$fec1."' AND '".$fec2."') AND vm.cliente_id =".$cliente."";

        $rpt_xls_lvc = DB::select($query_xls_lvc);
        return $rpt_xls_lvc;
    }

    public function rpt_pdf_lvc(Request $request) 
    {
        $data = $request->all();
        $fechai = Carbon::parse($data['fechainicio'])->format('Y-m-d');
        $fechaf = Carbon::parse($data['fechafinal'])->format('Y-m-d');
        $cliente = $data["cliente"];

        $clientes = cliente::where("id",$cliente)->get();
        
        $query = "SELECT  SUM(vm.total_vale) as Total
        FROM vale_maestro vm
        WHERE (CAST(vm.fecha_corte as date) BETWEEN '".$fechai."' AND '".$fechaf."') AND vm.cliente_id =".$cliente." AND vm.estado_vale_id <4";
        $total = DB::select($query);

        $data = $this->getData_PDF_LVC($fechai, $fechaf, $cliente);
        $user = Auth::user()->name;
        $today = Carbon::now();
        $view =  \View::make('pdf.pdf_lvc', compact('data', 'user', 'today', 'total', 'fechai', 'fechaf', 'clientes'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('PDF_LVC', array("Attachment" => 0));
    }

    public function getData_PDF_LVC($feci, $fecf, $cliente) 
    {
        $query = "SELECT date(vm.fecha_corte) as fecha, vm.no_vale as No_Vale, vm.piloto as piloto, vm.placa as placa, 
        vd.cantidad as Cant, IF(vd.combustible_id >0,cm.combustible, pro.nombre) as producto, 
          vd.precio_venta as precio, vd.subtotal as Cargo, ev.estado_vale as estado
        FROM vale_maestro vm
        INNER JOIN vale_detalle vd ON vm.id=vd.vale_maestro_id
        INNER JOIN clientes cl ON vm.cliente_id=cl.id
LEFT JOIN combustible cm ON vd.combustible_id=cm.id 
LEFT JOIN productos pro ON vd.producto_id=pro.id
        INNER JOIN estado_vale ev ON vm.estado_vale_id=ev.id
        WHERE (CAST(vm.fecha_corte as date) BETWEEN '".$feci."' AND '".$fecf."') AND vm.cliente_id =".$cliente." AND vm.estado_vale_id <4 ORDER BY vm.fecha_corte ASC ";
        $pdf_lvc = DB::select($query);
        return $pdf_lvc;
    }






    public function rpt_ecc(Request $request) 
    {
        $clientes = Cliente::all();
        return view("reportes.estado_cuenta_cliente", compact("clientes"));
    }

    public function rpt_xls_ecc(Request $request) 
    {
        $data = $request->all();
        $fec1 = Carbon::parse($data['fechainicio'])->format('Y-m-d');
        $fec2 = Carbon::parse($data['fechafinal'])->format('Y-m-d');
        $cliente = $data["cliente"];
        
        Excel::create('Listado de Vales por Cliente', function($excel) use ($fec1, $fec2, $cliente) {
            $excel->sheet('Listado', function($sheet) use ($fec1, $fec2, $cliente) {
                $valespc = $this->getData_XLS_LVC($datas);
                $json  = json_encode($valespc);
                $body = json_decode($json, true);
                $sheet->fromArray($body, null, 'A1', true);
            });
        })->export('xls');
    }

    public function getData_XLS_ECC($fec1, $fec2, $cliente) 
    {
        $query_xls_lvd = "SELECT vd.vale_maestro_id as No_Vale, CONCAT(cl.cl_nombres,' ',cl.cl_apellidos) as Cliente, 
        cm.combustible as Tipo_Combustible, vd.subtotal as Cargo
        FROM vale_maestro vm
        INNER JOIN vale_detalle vd ON vm.id=vd.vale_maestro_id
        INNER JOIN clientes cl ON vm.cliente_id=cl.id
        INNER JOIN combustible cm ON vd.combustible_id=cm.id
        WHERE (CAST(vm.created_at as date) BETWEEN '".$feci."' AND '".$fecf."') AND vm.cliente_id =".$cliente."";

        $rpt_xls_lvc = DB::select($query_xls_lvc);
        return $rpt_xls_lvc;
    }

    public function rpt_pdf_ecc(Request $request) 
    {
        $data = $request->all();
        $fechai = Carbon::parse($data['fechainicio'])->format('Y-m-d');
        $fechaf = Carbon::parse($data['fechafinal'])->format('Y-m-d');
        $m = Carbon::parse($data['fechainicio'])->format('m');
        $a = Carbon::parse($data['fechainicio'])->format('Y');

        if ($m>1){
            $mm = $m-1;
            $aa = $a;
        }else if ($m==1) {
            $mm = 12;
            $aa = $a-1;
        }

        $cliente = $data["cliente"];

        $clientes = cliente::where("id",$cliente)->get();
        $saldo_viene = saldos_clientes::where("cliente_id",$cliente)->where("mes_id",$mm)->where("anio",$aa)->get()->first();
        $mes = meses::where("id",$mm)->get()->first();

        $ff = new Carbon($data['fechainicio']);
        $fi = $ff->startOfMonth();
        $ffii = Carbon::parse($fi)->format('Y-m-d');

        $data = $this->getData_PDF_ECC($fechai, $fechaf, $cliente, $ffii);
        $user = Auth::user()->name;
        $today = Carbon::now();

        $view =  \View::make('pdf.pdf_ecc', compact('data', 'user', 'today', 'fechai', 'fechaf', 'clientes', 'saldo_viene','mes','aa'))->render();

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('PDF_ECC', array("Attachment" => 0));
    }

    public function getData_PDF_ECC($feci, $fecf, $cliente, $ff) 
    {
        $query = "SELECT ccm.cliente_id, cl_nit, CONCAT(cl.cl_nombres,' ',cl.cl_apellidos) as cliente, ccd.id, 
        ccd.fecha_documento as fecha, 
        IF(ccd.tipo_transaccion=1, CONCAT('Vale No ',vm.no_vale), IF(ccd.tipo_transaccion=2, CONCAT('Nota de Crédito No ', nc.id), IF(ccd.tipo_transaccion=7, CONCAT('Nota de Débito No ', nd.id), IF(ccd.tipo_transaccion=3, 
        CONCAT('Recibo de Caja No ',rc.no_recibo_caja, ' Deposito / Cheque No ',rc.cheque),0)))) as doc,
        IF(ccd.tipo_transaccion=1 or ccd.tipo_transaccion=7,ccd.total,0) as Cargos, 
        IF(ccd.tipo_transaccion=3 or ccd.tipo_transaccion=2,ccd.total,0) as Abonos, 
        ccd.saldo as Saldo
        FROM cuenta_cobrar_maestro ccm
        INNER JOIN cuenta_cobrar_detalle ccd ON ccm.id=ccd.cuenta_cobrar_maestro_id
        INNER JOIN clientes cl ON ccm.cliente_id=cl.id
        LEFT JOIN vale_maestro vm ON ccd.documento_id = vm.id
        LEFT JOIN recibo_caja rc ON ccd.documento_id = rc.id 
        LEFT JOIN notas_creditos nc ON ccd.documento_id = nc.id
        LEFT JOIN notas_debitos nd ON ccd.documento_id = nd.id
        WHERE (CAST(ccd.fecha_documento as date) BETWEEN '".$ff."' AND '".$fecf."')  AND ccm.cliente_id = ".$cliente." AND ccd.estado_cuenta_cobrar_id = 1
        ORDER BY ccd.fecha_documento ASC, ccd.tipo_transaccion ASC ";

        $pdf_ecc = DB::select($query);
        return $pdf_ecc;
    }




public function rpt_sccf(Request $request) 
    {
        return view("reportes.saldo_consolidado_cliente");
    }

    public function rpt_xls_sccf(Request $request) 
    {
        $data = $request->all();
        $fec1 = Carbon::parse($data['fechainicio'])->format('Y-m-d');
        $fec2 = Carbon::parse($data['fechafinal'])->format('Y-m-d');
        $cliente = $data["cliente"];
        
        Excel::create('Listado de Vales por Cliente', function($excel) use ($fec1, $fec2, $cliente) {
            $excel->sheet('Listado', function($sheet) use ($fec1, $fec2, $cliente) {
                $valespc = $this->getData_XLS_LVC($datas);
                $json  = json_encode($valespc);
                $body = json_decode($json, true);
                $sheet->fromArray($body, null, 'A1', true);
            });
        })->export('xls');
    }

    public function getData_XLS_SCCF($fec1, $fec2, $cliente) 
    {
        $query_xls_lvd = "SELECT vd.vale_maestro_id as No_Vale, CONCAT(cl.cl_nombres,' ',cl.cl_apellidos) as Cliente, 
        cm.combustible as Tipo_Combustible, vd.subtotal as Cargo
        FROM vale_maestro vm
        INNER JOIN vale_detalle vd ON vm.id=vd.vale_maestro_id
        INNER JOIN clientes cl ON vm.cliente_id=cl.id
        INNER JOIN combustible cm ON vd.combustible_id=cm.id
        WHERE (CAST(vm.created_at as date) BETWEEN '".$feci."' AND '".$fecf."') AND vm.cliente_id =".$cliente."";

        $rpt_xls_lvc = DB::select($query_xls_lvc);
        return $rpt_xls_lvc;
    }

    public function rpt_pdf_sccf(Request $request) 
    {
        $data = $request->all();
        $fecha = Carbon::parse($data['fecha'])->format('Y-m-d');

        $m = Carbon::parse($data['fecha'])->format('m');
        $a = Carbon::parse($data['fecha'])->format('Y');

        if ($m>1){
            $mm = $m-1;
            $aa = $a;
        }else if ($m==1) {
            $mm = 12;
            $aa = $a-1;
        }

        $ff = new Carbon($data['fecha']);
        $fi = $ff->startOfMonth();
        $ffii = Carbon::parse($fi)->format('Y-m-d');

        $data = $this->getData_PDF_SCCF($fecha, $ffii, $mm);
        $user = Auth::user()->name;
        $today = Carbon::now();

        $query = "SELECT SUM(sc.saldo) as saldo_anterior,
          (SELECT SUM(ccd3.total) FROM cuenta_cobrar_maestro ccm3 INNER JOIN cuenta_cobrar_detalle ccd3 ON 
        ccm3.id=ccd3.cuenta_cobrar_maestro_id WHERE (CAST(ccd3.fecha_documento as date) BETWEEN '".$ffii."' AND '".$fecha."') 
        AND ccd3.estado_cuenta_cobrar_id=1 AND (ccd3.tipo_transaccion = 1 OR ccd3.tipo_transaccion = 7)) as total_cargos,
        (SELECT SUM(ccd2.total) FROM cuenta_cobrar_maestro ccm2 INNER JOIN cuenta_cobrar_detalle ccd2 ON 
        ccm2.id=ccd2.cuenta_cobrar_maestro_id WHERE (CAST(ccd2.fecha_documento as date) BETWEEN '".$ffii."' AND '".$fecha."') 
        AND  ccd2.estado_cuenta_cobrar_id=1 AND (ccd2.tipo_transaccion = 2 OR ccd2.tipo_transaccion = 3)) as total_abonos
        FROM saldos_clientes sc
        WHERE sc.mes_id = ".$mm."";
        $saldos = DB::select($query);

        $view =  \View::make('pdf.pdf_eccf', compact('data', 'user', 'today', 'fecha', 'ffii', 'saldos'))->render();

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('PDF_ECCF', array("Attachment" => 0));
    }

    public function getData_PDF_SCCF($fecf, $ff, $mm) 
    {
        $query = "SELECT CONCAT(cl.cl_nombres,' ',cl.cl_apellidos) as cliente, sc.saldo as saldo_anterior,
        IF((SELECT SUM(ccd3.total) FROM cuenta_cobrar_maestro ccm3 INNER JOIN cuenta_cobrar_detalle ccd3 ON 
        ccm3.id=ccd3.cuenta_cobrar_maestro_id WHERE (CAST(ccd3.fecha_documento as date) BETWEEN '".$ff."' AND '".$fecf."') 
        AND ccm3.cliente_id = sc.cliente_id AND ccd3.estado_cuenta_cobrar_id=1 
        AND (ccd3.tipo_transaccion = 1 OR ccd3.tipo_transaccion = 7)) is null,0,(SELECT SUM(ccd3.total) FROM cuenta_cobrar_maestro ccm3
        INNER JOIN cuenta_cobrar_detalle ccd3 ON ccm3.id=ccd3.cuenta_cobrar_maestro_id WHERE (CAST(ccd3.fecha_documento as date) 
        BETWEEN '".$ff."' AND '".$fecf."') AND ccm3.cliente_id = sc.cliente_id AND ccd3.estado_cuenta_cobrar_id=1 
        AND (ccd3.tipo_transaccion = 1 OR ccd3.tipo_transaccion = 7))) as total_cargos,
        IF((SELECT SUM(ccd2.total) FROM cuenta_cobrar_maestro ccm2 INNER JOIN cuenta_cobrar_detalle ccd2 ON 
        ccm2.id=ccd2.cuenta_cobrar_maestro_id WHERE (CAST(ccd2.fecha_documento as date) BETWEEN '".$ff."' AND '".$fecf."') 
        AND ccm2.cliente_id = sc.cliente_id AND ccd2.estado_cuenta_cobrar_id=1 
        AND (ccd2.tipo_transaccion = 2 OR ccd2.tipo_transaccion = 3)) is null,0,(SELECT SUM(ccd2.total) FROM cuenta_cobrar_maestro ccm2
        INNER JOIN cuenta_cobrar_detalle ccd2 ON ccm2.id=ccd2.cuenta_cobrar_maestro_id WHERE (CAST(ccd2.fecha_documento as date) 
        BETWEEN '".$ff."' AND '".$fecf."') AND ccm2.cliente_id = sc.cliente_id AND ccd2.estado_cuenta_cobrar_id=1 
        AND (ccd2.tipo_transaccion = 2 OR ccd2.tipo_transaccion = 3))) as total_abonos
        FROM saldos_clientes sc
        INNER JOIN clientes cl ON sc.cliente_id=cl.id
        WHERE sc.mes_id = ".$mm."
        ORDER BY cl.cl_nombres ASC";
        $pdf_sccf = DB::select($query);
        return $pdf_sccf;
    }



    public function rpt_lgd(Request $request) 
    {
        return view("reportes.listado_gastos_diario");
    }

    public function rpt_xls_lgd(Request $request) 
    {
        $data = $request->all();
        $datas = Carbon::parse($data['fechav'])->format('Y-m-d');
        
        Excel::create('Listado de Vales Diarios', function($excel) use ($datas) {
            $excel->sheet('Listado', function($sheet) use ($datas) {
                $vales = $this->getData_XLS_LVD($datas);
                $json  = json_encode($vales);
                $body = json_decode($json, true);
                $sheet->fromArray($body, null, 'A1', true);
            });
        })->export('xls');
    }

    public function getData_XLS_LGD($fec) 
    {
        $query_xls_lvd = "SELECT vd.vale_maestro_id as No_Vale, CONCAT(cl.cl_nombres,' ',cl.cl_apellidos) as Cliente, 
        cm.combustible as Tipo_Combustible, vd.subtotal as Cargo
        FROM vale_maestro vm
        INNER JOIN vale_detalle vd ON vm.id=vd.vale_maestro_id
        INNER JOIN clientes cl ON vm.cliente_id=cl.id
        INNER JOIN combustible cm ON vd.combustible_id=cm.id
        WHERE CAST(vm.created_at AS date) = '".$fec."' ";

        $rpt_xls_lvd = DB::select($query_xls_lvd);
        return $rpt_xls_lvd;
    }

    public function rpt_pdf_lgd(Request $request) 
    {
        $data = $request->all();
        $fecha = Carbon::parse($data['fecha'])->format('Y-m-d');
        
        $query = "SELECT SUM(monto) as Total
        FROM gastos
        WHERE CAST(fecha_corte AS date) = '".$fecha."' ";
        $total = DB::select($query);

        $data = $this->getData_PDF_LGD($fecha);
        $user = Auth::user()->name;
        $today = Carbon::now();
        $view =  \View::make('pdf.pdf_lgd', compact('data', 'user', 'today', 'total', 'fecha'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('PDF_LGD', array("Attachment" => 0));
    }

    public function getData_PDF_LGD($fec) 
    {
        $query = "SELECT *
        FROM gastos
        WHERE CAST(fecha_corte AS date) = '".$fec."' ";
        $pdf_lgd = DB::select($query);
        return $pdf_lgd;
    }




    public function rpt_lvsd(Request $request) 
    {
        return view("reportes.listado_vouchers_diarios");
    }

    public function rpt_xls_lvsd(Request $request) 
    {
        $data = $request->all();
        $datas = Carbon::parse($data['fechav'])->format('Y-m-d');
        
        Excel::create('Listado de Vales Diarios', function($excel) use ($datas) {
            $excel->sheet('Listado', function($sheet) use ($datas) {
                $vales = $this->getData_XLS_LVSD($datas);
                $json  = json_encode($vales);
                $body = json_decode($json, true);
                $sheet->fromArray($body, null, 'A1', true);
            });
        })->export('xls');
    }

    public function getData_XLS_LVSD($fec) 
    {
        $query_xls_lvd = "SELECT vd.vale_maestro_id as No_Vale, CONCAT(cl.cl_nombres,' ',cl.cl_apellidos) as Cliente, 
        cm.combustible as Tipo_Combustible, vd.subtotal as Cargo
        FROM vale_maestro vm
        INNER JOIN vale_detalle vd ON vm.id=vd.vale_maestro_id
        INNER JOIN clientes cl ON vm.cliente_id=cl.id
        INNER JOIN combustible cm ON vd.combustible_id=cm.id
        WHERE CAST(vm.created_at AS date) = '".$fec."' ";

        $rpt_xls_lvd = DB::select($query_xls_lvd);
        return $rpt_xls_lvd;
    }

    public function rpt_pdf_lvsd(Request $request) 
    {
        $data = $request->all();
        $fecha = Carbon::parse($data['fecha'])->format('Y-m-d');
        
        $query = "SELECT SUM(total) as Total
        FROM voucher_tarjetas
        WHERE CAST(fecha_corte AS date) = '".$fecha."' ";
        $total = DB::select($query);

        $data = $this->getData_PDF_LVSD($fecha);
        $user = Auth::user()->name;
        $today = Carbon::now();
        $view =  \View::make('pdf.pdf_lvsd', compact('data', 'user', 'today', 'total', 'fecha'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('PDF_LVSD', array("Attachment" => 0));
    }

    public function getData_PDF_LVSD($fec) 
    {
        $query = "SELECT *
        FROM voucher_tarjetas
        WHERE CAST(fecha_corte AS date) = '".$fec."' ";
        $pdf_lvsd = DB::select($query);
        return $pdf_lvsd;
    }




    public function rpt_lasd(Request $request) 
    {
        return view("reportes.listado_anticipos_diarios");
    }

    public function rpt_xls_lasd(Request $request) 
    {
        $data = $request->all();
        $datas = Carbon::parse($data['fechav'])->format('Y-m-d');
        
        Excel::create('Listado de Vales Diarios', function($excel) use ($datas) {
            $excel->sheet('Listado', function($sheet) use ($datas) {
                $vales = $this->getData_XLS_LASD($datas);
                $json  = json_encode($vales);
                $body = json_decode($json, true);
                $sheet->fromArray($body, null, 'A1', true);
            });
        })->export('xls');
    }

    public function getData_XLS_LASD($fec) 
    {
        $query_xls_lvd = "SELECT vd.vale_maestro_id as No_Vale, CONCAT(cl.cl_nombres,' ',cl.cl_apellidos) as Cliente, 
        cm.combustible as Tipo_Combustible, vd.subtotal as Cargo
        FROM vale_maestro vm
        INNER JOIN vale_detalle vd ON vm.id=vd.vale_maestro_id
        INNER JOIN clientes cl ON vm.cliente_id=cl.id
        INNER JOIN combustible cm ON vd.combustible_id=cm.id
        WHERE CAST(vm.created_at AS date) = '".$fec."' ";

        $rpt_xls_lvd = DB::select($query_xls_lvd);
        return $rpt_xls_lvd;
    }

    public function rpt_pdf_lasd(Request $request) 
    {
        $data = $request->all();
        $fecha = Carbon::parse($data['fecha'])->format('Y-m-d');
        
        $query = "SELECT SUM(monto) as Total
        FROM anticipo_empleados
        WHERE CAST(fecha_corte AS date) = '".$fecha."' ";
        $total = DB::select($query);

        $data = $this->getData_PDF_LASD($fecha);
        $user = Auth::user()->name;
        $today = Carbon::now();
        $view =  \View::make('pdf.pdf_lasd', compact('data', 'user', 'today', 'total', 'fecha'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('PDF_LASD', array("Attachment" => 0));
    }

    public function getData_PDF_LASD($fec) 
    {
        $query = "SELECT at.monto as total, at.documento as documento, at.no_documento as no_documento, at.observaciones as observaciones, CONCAT(emp.emp_nombres,' ',emp.emp_apellidos) as empleado
        FROM anticipo_empleados at
        INNER JOIN empleados emp ON at.empleado_id=emp.id
        WHERE CAST(at.fecha_corte AS date) = '".$fec."' ";
        $pdf_lasd = DB::select($query);
        return $pdf_lasd;
    }





    public function rpt_lbgrf(Request $request) 
    {
        return view("reportes.listado_bg_repuestos");
    }

    public function rpt_xls_lbgrf(Request $request) 
    {
        $data = $request->all();
        $fechai = Carbon::parse($data['fechainicio'])->format('Y-m-d');
        $fechaf = Carbon::parse($data['fechafinal'])->format('Y-m-d');
        
        Excel::create('Listado de repuestos BG', function($excel) use ($datas) {
            $excel->sheet('Listado', function($sheet) use ($datas) {
                $vales = $this->getData_XLS_LBGRF($datas);
                $json  = json_encode($vales);
                $body = json_decode($json, true);
                $sheet->fromArray($body, null, 'A1', true);
            });
        })->export('xls');
    }

    public function getData_XLS_LBGRF($fec) 
    {
        $query_xls_lvd = "SELECT vd.vale_maestro_id as No_Vale, CONCAT(cl.cl_nombres,' ',cl.cl_apellidos) as Cliente, 
        cm.combustible as Tipo_Combustible, vd.subtotal as Cargo
        FROM vale_maestro vm
        INNER JOIN vale_detalle vd ON vm.id=vd.vale_maestro_id
        INNER JOIN clientes cl ON vm.cliente_id=cl.id
        INNER JOIN combustible cm ON vd.combustible_id=cm.id
        WHERE CAST(vm.created_at AS date) = '".$fec."' ";

        $rpt_xls_lvd = DB::select($query_xls_lvd);
        return $rpt_xls_lvd;
    }

    public function rpt_pdf_lbgrf(Request $request) 
    {
        $data = $request->all();
        $fechai = Carbon::parse($data['fechainicio'])->format('Y-m-d');
        $fechaf = Carbon::parse($data['fechafinal'])->format('Y-m-d');
        
        $query = "SELECT SUM(monto) as Total
        FROM bg_repuestos
        WHERE (CAST(fecha_corte as date) BETWEEN '".$fechai."' AND '".$fechaf."')";
        $total = DB::select($query);

        $data = $this->getData_PDF_LBGRF($fechai, $fechaf);
        $user = Auth::user()->name;
        $today = Carbon::now();
        $view =  \View::make('pdf.pdf_lbgrf', compact('data', 'user', 'today', 'total', 'fechai', 'fechaf'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('PDF_LBGRF', array("Attachment" => 0));
    }

    public function getData_PDF_LBGRF($fec1, $fec2) 
    {
        $query = "SELECT *
        FROM bg_repuestos
        WHERE (CAST(fecha_corte as date) BETWEEN '".$fec1."' AND '".$fec2."')";
        $pdf_lbgrf = DB::select($query);
        return $pdf_lbgrf;
    }






    public function rpt_lbgvf(Request $request) 
    {
        return view("reportes.listado_bg_viaticos");
    }

    public function rpt_xls_lbgvf(Request $request) 
    {
        $data = $request->all();
        $fechai = Carbon::parse($data['fechainicio'])->format('Y-m-d');
        $fechaf = Carbon::parse($data['fechafinal'])->format('Y-m-d');
        
        Excel::create('Listado de repuestos BG', function($excel) use ($datas) {
            $excel->sheet('Listado', function($sheet) use ($datas) {
                $vales = $this->getData_XLS_LBGVF($datas);
                $json  = json_encode($vales);
                $body = json_decode($json, true);
                $sheet->fromArray($body, null, 'A1', true);
            });
        })->export('xls');
    }

    public function getData_XLS_LBGVF($fec) 
    {
        $query_xls_lvd = "SELECT vd.vale_maestro_id as No_Vale, CONCAT(cl.cl_nombres,' ',cl.cl_apellidos) as Cliente, 
        cm.combustible as Tipo_Combustible, vd.subtotal as Cargo
        FROM vale_maestro vm
        INNER JOIN vale_detalle vd ON vm.id=vd.vale_maestro_id
        INNER JOIN clientes cl ON vm.cliente_id=cl.id
        INNER JOIN combustible cm ON vd.combustible_id=cm.id
        WHERE CAST(vm.created_at AS date) = '".$fec."' ";

        $rpt_xls_lvd = DB::select($query_xls_lvd);
        return $rpt_xls_lvd;
    }

    public function rpt_pdf_lbgvf(Request $request) 
    {
        $data = $request->all();
        $fechai = Carbon::parse($data['fechainicio'])->format('Y-m-d');
        $fechaf = Carbon::parse($data['fechafinal'])->format('Y-m-d');
        
        $query = "SELECT SUM(monto) as Total
        FROM bg_viaticos
        WHERE (CAST(fecha_corte as date) BETWEEN '".$fechai."' AND '".$fechaf."')";
        $total = DB::select($query);

        $data = $this->getData_PDF_LBGVF($fechai, $fechaf);
        $user = Auth::user()->name;
        $today = Carbon::now();
        $view =  \View::make('pdf.pdf_lbgvf', compact('data', 'user', 'today', 'total', 'fechai', 'fechaf'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('PDF_LBGVF', array("Attachment" => 0));
    }

    public function getData_PDF_LBGVF($fec1, $fec2) 
    {
        $query = "SELECT bgv.fecha_corte as fecha_corte, bgv.no_vale as no_vale, CONCAT(emp.emp_nombres,' ',emp.emp_apellidos) as conductor, bgv.monto as monto, bgv.observaciones as observaciones
        FROM bg_viaticos bgv
        INNER JOIN empleados emp ON bgv.conductor_id=emp.id
        WHERE (CAST(bgv.fecha_corte as date) BETWEEN '".$fec1."' AND '".$fec2."')";
        $pdf_lbgvf = DB::select($query);
        return $pdf_lbgvf;
    }






    public function rpt_lbgcf(Request $request) 
    {
        return view("reportes.listado_bg_combustibles");
    }

    public function rpt_xls_lbgcf(Request $request) 
    {
        $data = $request->all();
        $fechai = Carbon::parse($data['fechainicio'])->format('Y-m-d');
        $fechaf = Carbon::parse($data['fechafinal'])->format('Y-m-d');
        
        Excel::create('Listado de repuestos BG', function($excel) use ($datas) {
            $excel->sheet('Listado', function($sheet) use ($datas) {
                $vales = $this->getData_XLS_LBGCF($datas);
                $json  = json_encode($vales);
                $body = json_decode($json, true);
                $sheet->fromArray($body, null, 'A1', true);
            });
        })->export('xls');
    }

    public function getData_XLS_LBGCF($fec) 
    {
        $query_xls_lcd = "SELECT vd.vale_maestro_id as No_Vale, CONCAT(cl.cl_nombres,' ',cl.cl_apellidos) as Cliente, 
        cm.combustible as Tipo_Combustible, vd.subtotal as Cargo
        FROM vale_maestro vm
        INNER JOIN vale_detalle vd ON vm.id=vd.vale_maestro_id
        INNER JOIN clientes cl ON vm.cliente_id=cl.id
        INNER JOIN combustible cm ON vd.combustible_id=cm.id
        WHERE CAST(vm.created_at AS date) = '".$fec."' ";

        $rpt_xls_lcd = DB::select($query_xls_lvd);
        return $rpt_xls_lcd;
    }

    public function rpt_pdf_lbgcf(Request $request) 
    {
        $data = $request->all();
        $fechai = Carbon::parse($data['fechainicio'])->format('Y-m-d');
        $fechaf = Carbon::parse($data['fechafinal'])->format('Y-m-d');
        
        $query = "SELECT SUM(monto) as Total
        FROM bg_combustible
        WHERE (CAST(fecha_corte as date) BETWEEN '".$fechai."' AND '".$fechaf."')";
        $total = DB::select($query);

        $data = $this->getData_PDF_LBGCF($fechai, $fechaf);
        $user = Auth::user()->name;
        $today = Carbon::now();
        $view =  \View::make('pdf.pdf_lbgcf', compact('data', 'user', 'today', 'total', 'fechai', 'fechaf'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('PDF_LBGCF', array("Attachment" => 0));
    }

    public function getData_PDF_LBGCF($fec1, $fec2) 
    {
        $query = "SELECT bgc.fecha_corte as fecha_corte, bgc.no_vale as no_vale, CONCAT(emp.emp_nombres,' ',emp.emp_apellidos) as conductor, bgc.monto as monto, bgc.observaciones as observaciones, bgc.galones as galones
        FROM bg_combustible bgc
        INNER JOIN empleados emp ON bgc.conductor_id=emp.id
        WHERE (CAST(bgc.fecha_corte as date) BETWEEN '".$fec1."' AND '".$fec2."')";
        $pdf_lbgcf = DB::select($query);
        return $pdf_lbgcf;
    }






    public function rpt_lbgsf(Request $request) 
    {
        return view("reportes.listado_bg_salarios");
    }

    public function rpt_xls_lbgsf(Request $request) 
    {
        $data = $request->all();
        $fechai = Carbon::parse($data['fechainicio'])->format('Y-m-d');
        $fechaf = Carbon::parse($data['fechafinal'])->format('Y-m-d');
        
        Excel::create('Listado de repuestos BG', function($excel) use ($datas) {
            $excel->sheet('Listado', function($sheet) use ($datas) {
                $vales = $this->getData_XLS_LBGSF($datas);
                $json  = json_encode($vales);
                $body = json_decode($json, true);
                $sheet->fromArray($body, null, 'A1', true);
            });
        })->export('xls');
    }

    public function getData_XLS_LBGSF($fec) 
    {
        $query_xls_lsd = "SELECT vd.vale_maestro_id as No_Vale, CONCAT(cl.cl_nombres,' ',cl.cl_apellidos) as Cliente, 
        cm.combustible as Tipo_Combustible, vd.subtotal as Cargo
        FROM vale_maestro vm
        INNER JOIN vale_detalle vd ON vm.id=vd.vale_maestro_id
        INNER JOIN clientes cl ON vm.cliente_id=cl.id
        INNER JOIN combustible cm ON vd.combustible_id=cm.id
        WHERE CAST(vm.created_at AS date) = '".$fec."' ";

        $rpt_xls_lsd = DB::select($query_xls_lvd);
        return $rpt_xls_lsd;
    }

    public function rpt_pdf_lbgsf(Request $request) 
    {
        $data = $request->all();
        $fechai = Carbon::parse($data['fechainicio'])->format('Y-m-d');
        $fechaf = Carbon::parse($data['fechafinal'])->format('Y-m-d');
        
        $query = "SELECT SUM(monto) as Total
        FROM bg_salarios
        WHERE (CAST(fecha_corte as date) BETWEEN '".$fechai."' AND '".$fechaf."')";
        $total = DB::select($query);

        $data = $this->getData_PDF_LBGSF($fechai, $fechaf);
        $user = Auth::user()->name;
        $today = Carbon::now();
        $view =  \View::make('pdf.pdf_lbgsf', compact('data', 'user', 'today', 'total', 'fechai', 'fechaf'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('PDF_LBGSF', array("Attachment" => 0));
    }

    public function getData_PDF_LBGSF($fec1, $fec2) 
    {
        $query = "SELECT bgs.fecha_corte as fecha_corte, CONCAT(emp.emp_nombres,' ',emp.emp_apellidos) as conductor, bgs.monto as monto, bgs.observaciones as observaciones
        FROM bg_salarios bgs
        INNER JOIN empleados emp ON bgs.conductor_id=emp.id
        WHERE (CAST(bgs.fecha_corte as date) BETWEEN '".$fec1."' AND '".$fec2."')";
        $pdf_lbgsf = DB::select($query);
        return $pdf_lbgsf;
    }




    public function rpt_pdf_lcg() 
    {
        $data = $this->getData_PDF_LCG();
        $user = Auth::user()->name;
        $today = Carbon::now();
        $view =  \View::make('pdf.pdf_lcg', compact('data', 'user', 'today' ))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('PDF_LCG', array("Attachment" => 0));
    }

    public function getData_PDF_LCG() 
    {
        $query = "SELECT * FROM clientes ORDER BY id ASC";
        $pdf_lcg = DB::select($query);
        return $pdf_lcg;
    }




    public function rpt_pdf_scc() 
    {
        $query = "SELECT SUM(cl_saldo) as Total
        FROM clientes ";
        $total = DB::select($query);

        $data = $this->getData_PDF_SCC();
        $user = Auth::user()->name;
        $today = Carbon::now();
        $view =  \View::make('pdf.pdf_scc', compact('data', 'user', 'today', 'total' ))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('PDF_SCC', array("Attachment" => 0));
    }

    public function getData_PDF_SCC() 
    {
        $query = "SELECT * FROM clientes ORDER BY id ASC";
        $pdf_scc = DB::select($query);
        return $pdf_scc;
    }




 public function rpt_pdf_cmes2() 
    {
        $data = $this->getData_PDF_CMES2();
        $user = Auth::user()->name;
        $today = Carbon::now();
        $f1 = "31-05-2018";

        $query = "SELECT SUM(saldo) as Total
        FROM saldos_clientes
        WHERE mes_id = 5";
        $total = DB::select($query);

        $view =  \View::make('pdf.pdf_cmes2', compact('data', 'user', 'today', 'f1', 'total' ))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('PDF_CMES2', array("Attachment" => 0));
    }

    public function getData_PDF_CMES2() 
    {
        $query = "SELECT cl.cl_nit as nit, CONCAT(cl.cl_nombres,' ',cl.cl_apellidos) as cliente, sc.saldo as saldo
        FROM saldos_clientes sc
        INNER JOIN clientes cl ON sc.cliente_id=cl.id
        WHERE sc.mes_id = 5 AND anio = 2018 ";
        $pdf_cmes2 = DB::select($query);
        return $pdf_cmes2;
    }




    public function rpt_pdf_rmc() 
    {
        $data = $this->getData_PDF_RMC();
        $user = Auth::user()->name;
        $today = Carbon::now();
        $view =  \View::make('pdf.pdf_rmc', compact('data', 'user', 'today' ))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('PDF_RMC', array("Attachment" => 0));
    }

    public function getData_PDF_RMC() 
    {
        $query = "SELECT * FROM inventario_combustible WHERE estado = 1 ORDER BY id ASC ";
        $pdf_scc = DB::select($query);
        return $pdf_scc;
    }



    public function rpt_pdf_bgsf() 
    {
        $query = "SELECT SUM(total_seguro) as Total
        FROM bg_seguro ";
        $total = DB::select($query);

        $data = $this->getData_PDF_BGSF();
        $user = Auth::user()->name;
        $today = Carbon::now();
        $view =  \View::make('pdf.pdf_bgsf', compact('data', 'user', 'today', 'total' ))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('PDF_BGSF', array("Attachment" => 0));
    }

    public function getData_PDF_BGSF() 
    {
        $query = "SELECT * FROM bg_seguro WHERE estado = 1 ORDER BY id ASC ";
        $pdf_bgsf = DB::select($query);
        return $pdf_bgsf;
    }




    public function rpt_pdf_ecf() 
    {
        $data = $this->getData_PDF_ECF();
        $user = Auth::user()->name;
        $today = Carbon::now();
        $view =  \View::make('pdf.pdf_ecf', compact('data', 'user', 'today' ))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('PDF_ECF', array("Attachment" => 0));
    }

    public function getData_PDF_ECF() 
    {
        $query = "SELECT * FROM bg_pago_flete WHERE estado = 1 ORDER BY id ASC ";
        $pdf_ecf = DB::select($query);
        return $pdf_ecf;
    }




    public function rpt_lfed(Request $request) 
    {
        return view("reportes.listado_faltantes_efectivo");
    }

    public function rpt_xls_lfed(Request $request) 
    {
        $data = $request->all();
        $datas = Carbon::parse($data['fechav'])->format('Y-m-d');
        
        Excel::create('Listado de Vales Diarios', function($excel) use ($datas) {
            $excel->sheet('Listado', function($sheet) use ($datas) {
                $vales = $this->getData_XLS_LVSD($datas);
                $json  = json_encode($vales);
                $body = json_decode($json, true);
                $sheet->fromArray($body, null, 'A1', true);
            });
        })->export('xls');
    }

    public function getData_XLS_LFED($fec) 
    {
        $query_xls_lvd = "SELECT vd.vale_maestro_id as No_Vale, CONCAT(cl.cl_nombres,' ',cl.cl_apellidos) as Cliente, 
        cm.combustible as Tipo_Combustible, vd.subtotal as Cargo
        FROM vale_maestro vm
        INNER JOIN vale_detalle vd ON vm.id=vd.vale_maestro_id
        INNER JOIN clientes cl ON vm.cliente_id=cl.id
        INNER JOIN combustible cm ON vd.combustible_id=cm.id
        WHERE CAST(vm.created_at AS date) = '".$fec."' ";

        $rpt_xls_lvd = DB::select($query_xls_lvd);
        return $rpt_xls_lvd;
    }

    public function rpt_pdf_lfed(Request $request) 
    {
        $data = $request->all();
        $fecha = Carbon::parse($data['fecha'])->format('Y-m-d');
        
        $query = "SELECT SUM(monto) as Total
        FROM faltantes
        WHERE CAST(fecha_corte AS date) = '".$fecha."' ";
        $total = DB::select($query);

        $data = $this->getData_PDF_LFED($fecha);
        $user = Auth::user()->name;
        $today = Carbon::now();
        $view =  \View::make('pdf.pdf_lfed', compact('data', 'user', 'today', 'total', 'fecha'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('PDF_LFED', array("Attachment" => 0));
    }

    public function getData_PDF_LFED($fec) 
    {
        $query = "SELECT *
        FROM faltantes
        WHERE CAST(fecha_corte AS date) = '".$fec."' ";
        $pdf_lfed = DB::select($query);
        return $pdf_lfed;
    }





    public function rpt_ecb(Request $request) 
    {
        $cuentas = Cuenta::all();

        return view("reportes.estado_cuenta_bancaria", compact("cuentas"));
    }

    public function rpt_xls_ecb(Request $request) 
    {
        $data = $request->all();
        $fec1 = Carbon::parse($data['fechainicio'])->format('Y-m-d');
        $fec2 = Carbon::parse($data['fechafinal'])->format('Y-m-d');
        $cliente = $data["cliente_id"];
        
        Excel::create('Listado de Vales por Cliente', function($excel) use ($fec1, $fec2, $cliente) {
            $excel->sheet('Listado', function($sheet) use ($fec1, $fec2, $cliente) {
                $valespc = $this->getData_XLS_LVC($datas);
                $json  = json_encode($valespc);
                $body = json_decode($json, true);
                $sheet->fromArray($body, null, 'A1', true);
            });
        })->export('xls');
    }

    public function getData_XLS_ECB($fec1, $fec2, $cliente) 
    {
        $query_xls_lvd = "SELECT vd.vale_maestro_id as No_Vale, CONCAT(cl.cl_nombres,' ',cl.cl_apellidos) as Cliente, 
        cm.combustible as Tipo_Combustible, vd.subtotal as Cargo
        FROM vale_maestro vm
        INNER JOIN vale_detalle vd ON vm.id=vd.vale_maestro_id
        INNER JOIN clientes cl ON vm.cliente_id=cl.id
        INNER JOIN combustible cm ON vd.combustible_id=cm.id
        WHERE (CAST(vm.created_at as date) BETWEEN '".$fec1."' AND '".$fec2."') AND vm.cliente_id =".$cliente."";

        $rpt_xls_lvc = DB::select($query_xls_lvc);
        return $rpt_xls_lvc;
    }

    public function rpt_pdf_ecb(Request $request) 
    {
        $data = $request->all();
        $fechai = Carbon::parse($data['fechainicio'])->format('Y-m-d');
        $fechaf = Carbon::parse($data['fechafinal'])->format('Y-m-d');
        $cuenta = $data["cuenta"];

        $cuentas = cuenta::where("id",$cuenta)->get();

        $data = $this->getData_PDF_ECB($fechai, $fechaf, $cuenta);
        $user = Auth::user()->name;
        $today = Carbon::now();
        $view =  \View::make('pdf.pdf_ecb', compact('data', 'user', 'today', 'fechai', 'fechaf', 'cuentas'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('PDF_ECB', array("Attachment" => 0));
    }

    public function getData_PDF_ECB($feci, $fecf, $cuenta) 
    {
        $query = "SELECT DATE_FORMAT(ob.fecha_transaccion, '%d-%m-%Y') as fecha_transaccion, doc.documento as documento, ob.no_documento as no_documento, ob.debitos as debitos, ob.creditos as creditos, ob.saldo as saldo, ob.descripcion as descripcion
        FROM operacion_bancaria ob
        INNER JOIN documentos doc ON ob.documento_id=doc.id
        WHERE (CAST(ob.fecha_transaccion as date) BETWEEN '".$feci."' AND '".$fecf."') AND ob.cuenta_id =".$cuenta." ";
        $pdf_ecb = DB::select($query);
        return $pdf_ecb;
    }







    public function rpt_ece(Request $request) 
    {
        $empleados = empleado::all();
        return view("reportes.reporte_estado_cuenta", compact("empleados"));
    }

    public function rpt_xls_ece(Request $request) 
    {
        $data = $request->all();
        $datas = Carbon::parse($data['fechav'])->format('Y-m-d');
        
        Excel::create('Listado de Vales Diarios', function($excel) use ($datas) {
            $excel->sheet('Listado', function($sheet) use ($datas) {
                $vales = $this->getData_XLS_LASD($datas);
                $json  = json_encode($vales);
                $body = json_decode($json, true);
                $sheet->fromArray($body, null, 'A1', true);
            });
        })->export('xls');
    }

    public function getData_XLS_ECE($fec) 
    {
        $query_xls_lvd = "SELECT vd.vale_maestro_id as No_Vale, CONCAT(cl.cl_nombres,' ',cl.cl_apellidos) as Cliente, 
        cm.combustible as Tipo_Combustible, vd.subtotal as Cargo
        FROM vale_maestro vm
        INNER JOIN vale_detalle vd ON vm.id=vd.vale_maestro_id
        INNER JOIN clientes cl ON vm.cliente_id=cl.id
        INNER JOIN combustible cm ON vd.combustible_id=cm.id
        WHERE CAST(vm.created_at AS date) = '".$fec."' ";

        $rpt_xls_lvd = DB::select($query_xls_lvd);
        return $rpt_xls_lvd;
    }

    public function rpt_pdf_ece(Request $request) 
    {
        $data = $request->all();
        $fechai = Carbon::parse($data['fechainicio'])->format('Y-m-d');
        $fechaf = Carbon::parse($data['fechafinal'])->format('Y-m-d');

        $empleado = $data["empleado"];
        $empleados = empleado::where("id",$empleado)->get();

        $data = $this->getData_PDF_ECE($fechai, $fechaf, $empleado);
        $user = Auth::user()->name;
        $today = Carbon::now();
        $view =  \View::make('pdf.pdf_ece', compact('data', 'user', 'today', 'fechai', 'fechaf', 'empleados'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('PDF_ECE', array("Attachment" => 0));
    }

    public function getData_PDF_ECE($feci, $fecf, $emp) 
    {
        $query = "SELECT ece.fecha_transaccion as fecha, ece.documento as doc, ece.no_documento as no_doc, ece.cargos as cargos, ece.abonos as abonos, ece.saldo as saldo
        FROM estado_cuenta_empleado ece
        INNER JOIN empleados emp ON ece.empleado_id=emp.id
        WHERE (CAST(ece.fecha_transaccion AS date)  BETWEEN '".$feci."' AND '".$fecf."') AND ece.empleado_id = ".$emp."";
        $pdf_ece = DB::select($query);
        return $pdf_ece;
    }




    public function rpt_rdf(Request $request) 
    {
        $combustibles = combustible::whereIn("id",[4,5,6])->get();
        return view("reportes.reporte_diferencias_fechas", compact("combustibles"));
    }

    public function rpt_xls_rdf(Request $request) 
    {
        $data = $request->all();
        $datas = Carbon::parse($data['fechav'])->format('Y-m-d');
        
        Excel::create('Listado de Vales Diarios', function($excel) use ($datas) {
            $excel->sheet('Listado', function($sheet) use ($datas) {
                $vales = $this->getData_XLS_LASD($datas);
                $json  = json_encode($vales);
                $body = json_decode($json, true);
                $sheet->fromArray($body, null, 'A1', true);
            });
        })->export('xls');
    }

    public function getData_XLS_RDF($fec) 
    {
        $query_xls_lvd = "SELECT vd.vale_maestro_id as No_Vale, CONCAT(cl.cl_nombres,' ',cl.cl_apellidos) as Cliente, 
        cm.combustible as Tipo_Combustible, vd.subtotal as Cargo
        FROM vale_maestro vm
        INNER JOIN vale_detalle vd ON vm.id=vd.vale_maestro_id
        INNER JOIN clientes cl ON vm.cliente_id=cl.id
        INNER JOIN combustible cm ON vd.combustible_id=cm.id
        WHERE CAST(vm.created_at AS date) = '".$fec."' ";

        $rpt_xls_lvd = DB::select($query_xls_lvd);
        return $rpt_xls_lvd;
    }

    public function rpt_pdf_rdf(Request $request) 
    {
        $data = $request->all();
        $fechai = Carbon::parse($data['fechainicio'])->format('Y-m-d');
        $fechaf = Carbon::parse($data['fechafinal'])->format('Y-m-d');

        $combustible = $data["combustible"];
        $combustibles = combustible::where("id",$combustible)->get();

        $data = $this->getData_PDF_RDF($fechai, $fechaf, $combustible);
        $user = Auth::user()->name;
        $today = Carbon::now();
        $view =  \View::make('pdf.pdf_rdf', compact('data', 'user', 'today', 'fechai', 'fechaf', 'combustibles'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('PDF_RDF', array("Attachment" => 0));
    }

    public function getData_PDF_RDF($feci, $fecf, $comb) 
    {
        $query = "SELECT dc.fecha as fecha, comb.combustible as comb, dc.gal_venta_dia as venta_dia, dc.gal_sistema_comb as sistema, dc.gal_comprados as compras, 
        dc.saldo_gals as saldo, dc.dif_dia as dif_dia, dc.dif_acumulada_mes as dif_acum
        FROM diferencias_combustible dc
        INNER JOIN combustible comb ON comb.id=dc.combustible_id
        WHERE (CAST(dc.fecha AS date)  BETWEEN '".$feci."' AND '".$fecf."') AND dc.combustible_id = ".$comb."";
        $pdf_rdf = DB::select($query);
        return $pdf_rdf;
    }





    public function rpt_lcp(Request $request) 
    {
        return view("reportes.reporte_listado_cupones");
    }

    public function rpt_xls_lcp(Request $request) 
    {
        $data = $request->all();
        $datas = Carbon::parse($data['fechav'])->format('Y-m-d');
        
        Excel::create('Listado de Vales Diarios', function($excel) use ($datas) {
            $excel->sheet('Listado', function($sheet) use ($datas) {
                $vales = $this->getData_XLS_LASD($datas);
                $json  = json_encode($vales);
                $body = json_decode($json, true);
                $sheet->fromArray($body, null, 'A1', true);
            });
        })->export('xls');
    }

    public function getData_XLS_LCP($fec) 
    {
        $query_xls_lvd = "SELECT vd.vale_maestro_id as No_Vale, CONCAT(cl.cl_nombres,' ',cl.cl_apellidos) as Cliente, 
        cm.combustible as Tipo_Combustible, vd.subtotal as Cargo
        FROM vale_maestro vm
        INNER JOIN vale_detalle vd ON vm.id=vd.vale_maestro_id
        INNER JOIN clientes cl ON vm.cliente_id=cl.id
        INNER JOIN combustible cm ON vd.combustible_id=cm.id
        WHERE CAST(vm.created_at AS date) = '".$fec."' ";

        $rpt_xls_lvd = DB::select($query_xls_lvd);
        return $rpt_xls_lvd;
    }

    public function rpt_pdf_lcp(Request $request) 
    {
        $data = $request->all();
        $fecha = Carbon::parse($data['fecha'])->format('Y-m-d');

        $query = "SELECT SUM(monto) as Total
        FROM cupones
        WHERE CAST(fecha_corte AS date) = '".$fecha."' ";
        $total = DB::select($query);

        $data = $this->getData_PDF_LCP($fecha);
        $user = Auth::user()->name;
        $today = Carbon::now();
        $view =  \View::make('pdf.pdf_lcp', compact('data', 'user', 'today', 'fecha', 'total'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('PDF_LCP', array("Attachment" => 0));
    }

    public function getData_PDF_LCP($fec) 
    {
        $query = "SELECT * FROM cupones WHERE CAST(fecha_corte AS date) = '".$fec."'";
        $pdf_lcp = DB::select($query);
        return $pdf_lcp;
    }



public function rpt_rcm(Request $request) 
    {
        $meses = meses::all();
        return view("reportes.reporte_combustible_mes", compact("meses"));
    }

    public function rpt_xls_rcm(Request $request) 
    {
        $data = $request->all();
        $datas = Carbon::parse($data['fechav'])->format('Y-m-d');
        
        Excel::create('Listado de Vales Diarios', function($excel) use ($datas) {
            $excel->sheet('Listado', function($sheet) use ($datas) {
                $vales = $this->getData_XLS_LASD($datas);
                $json  = json_encode($vales);
                $body = json_decode($json, true);
                $sheet->fromArray($body, null, 'A1', true);
            });
        })->export('xls');
    }

    public function getData_XLS_rcm($fec) 
    {
        $query_xls_lvd = "SELECT vd.vale_maestro_id as No_Vale, CONCAT(cl.cl_nombres,' ',cl.cl_apellidos) as Cliente, 
        cm.combustible as Tipo_Combustible, vd.subtotal as Cargo
        FROM vale_maestro vm
        INNER JOIN vale_detalle vd ON vm.id=vd.vale_maestro_id
        INNER JOIN clientes cl ON vm.cliente_id=cl.id
        INNER JOIN combustible cm ON vd.combustible_id=cm.id
        WHERE CAST(vm.created_at AS date) = '".$fec."' ";

        $rpt_xls_rcm = DB::select($query_xls_lvd);
        return $rpt_xls_rcm;
    }

    public function rpt_pdf_rcm(Request $request) 
    {
        $data = $request->all();
        $mes = $data['mes'];
        $anio = $data['anio'];

        $mecesito = meses::where("id",$mes)->get()->first();

        $query = "SELECT sum(gal_super) as tot_super, sum(gal_regular) as tot_regular, sum(gal_diesel) as tot_diesel, sum(total_galones) as total_gals
FROM bg_fletes_maestro
WHERE month(fecha_corte) = ".$mes." AND year(fecha_corte) = ".$anio."";
        $total = DB::select($query);

        $data = $this->getData_PDF_RCM($mes, $anio);
        $user = Auth::user()->name;
        $today = Carbon::now();
        $view =  \View::make('pdf.pdf_rcm', compact('data', 'user', 'today', 'mecesito', 'anio', 'total'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('PDF_RCM', array("Attachment" => 0));
    }

    public function getData_PDF_RCM($mes, $anio) 
    {
        $query = "SELECT fecha_corte, serie_factura, no_factura, gal_super, gal_regular, gal_diesel, total_galones
FROM bg_fletes_maestro
WHERE month(fecha_corte) = ".$mes." AND year(fecha_corte) = ".$anio." ORDER BY fecha_corte ASC";
        $pdf_rcm = DB::select($query);
        return $pdf_rcm;
    }












    public function getDataVales($fec, $us) 
    {

        if ($fec=="" && $us<>"")
        {
            $query = "SELECT vm.id as cod, date(vm.created_at) as fecha, cl.cl_nombres as nombres, cl.cl_apellidos as apellidos,
            ev.estado_vale as estado
            FROM vale_maestro vm 
            INNER JOIN clientes cl ON cl.id=vm.cliente_id
            INNER JOIN estado_vale ev ON vm.estado_vale_id=ev.id
            WHERE cl.id = " .$us. "";
        } else if ($fec<>"" && $us<>"")
        {
            $query = "SELECT vm.id as cod, date(vm.created_at) as fecha, cl.cl_nombres as nombres, cl.cl_apellidos as apellidos,
            ev.estado_vale as estado
            FROM vale_maestro vm 
            INNER JOIN clientes cl ON cl.id=vm.cliente_id
            INNER JOIN estado_vale ev ON vm.estado_vale_id=ev.id
            WHERE CAST(vm.created_at AS date) = '".$fec."' AND cl.id = " .$us. "";
        }

        $rpt_cl = DB::select($query);
        return $rpt_cl;
    }



    public function pdf_vales_fechas(Request $request) 
    {
        $datas = $request->all();
        $fec1 = $datas["fecha_inicio"];
        $fec2 = $datas["fecha_fin"];

        Excel::create('Total de Vales por Fecha', function($excel) use ($fec1, $fec2) {
            $excel->sheet('Vales por Fecha', function($sheet) use ($fec1, $fec2) {

                $valesf = $this->getDataValesFecha($fec1,$fec2);
                $json  = json_encode($valesf);
                $body = json_decode($json, true);
                $sheet->fromArray($body, null, 'A1', true);

            });
        })->export('xls');
    }


    public function getDataValesFecha($fec1, $fec2) 
    {

        $queryvf = "SELECT date(vm.created_at) as fecha, vm.id as cod, cl.cl_nombres as nombres, cl.cl_apellidos as apellidos, vm.total_vale as tot, ev.estado_vale as estado
        FROM vale_maestro vm 
        INNER JOIN clientes cl ON cl.id=vm.cliente_id
        INNER JOIN estado_vale ev ON vm.estado_vale_id=ev.id 
        WHERE CAST(vm.created_at AS date) BETWEEN  '".$fec1."' AND '".$fec2."' ";


        $rpt_vf = DB::select($queryvf);
        return $rpt_vf;
    }


    public function pdf_ncs(Request $request) 
    {
        $datas = $request->all();
        $fec = $datas["fecha_nc"];
        $us = $datas["userslst"];

        Excel::create('Notas de Cr矇dito por Fecha y Cliente', function($excel) use ($fec, $us) {
            $excel->sheet('Notas de Cr矇dito', function($sheet) use ($fec, $us) {

                $ncs = $this->getDataNC($fec,$us);
                $json  = json_encode($ncs);
                $body = json_decode($json, true);
                $sheet->fromArray($body, null, 'A1', true);

            });
        })->export('xls');
    }


    public function getDataNC($fec, $us) 
    {

        if ($fec=="" && $us<>"")
        {
            $query = "SELECT ncm.id as cod, date(ncm.created_at) as fecha, cl.cl_nombres as nombres, cl.cl_apellidos as apellidos
            FROM nota_credito_maestro ncm 
            INNER JOIN clientes cl ON cl.id=ncm.cliente_id
            WHERE cl.id = " .$us. "";
        } else if ($fec<>"" && $us<>"")
        {
            $query = "SELECT ncm.id as cod, date(ncm.created_at) as fecha, cl.cl_nombres as nombres, cl.cl_apellidos as apellidos
            FROM nota_credito_maestro ncm 
            INNER JOIN clientes cl ON cl.id=ncm.cliente_id
            WHERE CAST(ncm.created_at AS date) = '".$fec."' AND cl.id = " .$us. "";
        }

        $rpt_nc = DB::select($query);
        return $rpt_nc;
    }

}
