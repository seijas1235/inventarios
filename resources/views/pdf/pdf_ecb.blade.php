<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Estado de Cuenta Bancaria</title>
    <link rel="stylesheet" type="text/css" href="/public/style.css">
    <style>
        .table {
            width: 700px;
            height: auto;
        }
        th {
            background-color: gray;
            color: white;
        }
        table {
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
    </style>
</head>
<body><div class="container">
 <div class="row">
    <div class="col-md-12">
        <h1 style="text-align:center;">Estado de Cuenta Bancaria </h1>
        <h3 style="text-align:center;">Centro de Servicio Texaco</h3>
        <h3 style="text-align:center;">La Nueva San José, Chiquimula, Chiquimula </h3>
        
        <table border="1" cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
            <tr>
                <td style="font-size:15px;"> Usuario: {{$user}}  </td>
            </tr>
            <tr>
                <td style="font-size:15px;"> Fecha y hora de impresión: {{ Carbon\Carbon::parse($today)->format('d-m-Y H:i:s') }} </td>
            </tr>
            <tr>
                <td style="font-size:15px;"> Busqueda del {{ Carbon\Carbon::parse($fechai)->format('d-m-Y') }} al {{ Carbon\Carbon::parse($fechaf)->format('d-m-Y') }} </td>
            </tr>
        </table>
        <br>
       <table border="1" cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
        @foreach ($cuentas as $cuen)
            <tr>
                <td style="font-size:15px;"> No de la Cuenta: {{$cuen->no_cuenta}}  </td>
            </tr>
            <tr>
                <td style="font-size:15px;"> Nombre de la Cuenta: {{$cuen->nombre_cuenta}} </td>
            </tr>
            @endforeach
        </table>
        <br>
        <table border="1" cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th width=10%>Fecha</th>
                    <th width=10%>Documento</th>
                    <th width=10%>No Documento</th>
                    <th width=15%>Débitos</th>
                    <th width=15%>Créditos</th>
                    <th width=15%>Saldo</th>
                    <th width=25%>Observaciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $dat)
                <tr>
                    <td style="font-size:12px;" style="text-align:center;">{{ Carbon\Carbon::parse($dat->fecha_transaccion)->format('d-m-Y') }}</td>
                    <td style="font-size:12px;" style="text-align:left;">{{ $dat->documento }}</td>
                    <td style="font-size:12px;" style="text-align:left;">{{ $dat->no_documento }}</td>
                    <td style="font-size:12px;" style="text-align:right;">Q. {{{number_format((float) $dat->debitos, 2) }}}</td>
                    <td style="font-size:12px;" style="text-align:right;">Q. {{{number_format((float) $dat->creditos, 2) }}}</td>
                    <td style="font-size:12px;" style="text-align:right;">Q. {{{number_format((float) $dat->saldo, 2) }}}</td>
                    <td style="font-size:12px;" style="text-align:left;">{{ $dat->descripcion }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>
</body>
</html>