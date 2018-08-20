<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=big5">
    
    <title>Listado de Abonos por Fecha</title>
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
        <h1 style="text-align:center;">Listado de Abonos por Fecha </h1>
        <h3 style="text-align:center;">Centro de Servicio Texaco</h3>
        <h3 style="text-align:center;">La Nueva San José, Chiquimula, Chiquimula </h3>
        
        <table border="1" cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
            <tr>
                <td style="font-size:15px;"> Usuario: {{$user}}  </td>
            </tr>
            <tr>
                <td style="font-size:15px;"> Fecha y Hora de generacion: {{ Carbon\Carbon::parse($today)->format('d-m-Y H:i:s') }} </td>
            </tr>
            <tr>
                <td style="font-size:15px;"> Fecha del Reporte: {{ Carbon\Carbon::parse($fecha)->format('d-m-Y') }}  </td>
            </tr>
        </table>
        <br>
        <table border="1" cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
            <tr>
                <td style="font-size:20px;"> Total </td>
                @foreach ($total as $totales)
                <td style="font-size:20px;">Q. {{{number_format((float) $totales->Total, 2) }}} </td>
                @endforeach
            </tr>
        </table>
        <br>
        <table border="1" cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th width=15%>No Recibo</th>
                    <th width=25%>Cliente</th>
                    <th width=20%>Tipo Pago</th>
                    <th width=20%>No Boleta</th>
                    <th width=20%>Depósito</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $dat)
                <tr>
                    <td style="font-size:13px;">{{ $dat->no_recibocaja }}</td>
                    <td style="font-size:13px;">{{ $dat->cliente }}</td>
                    <td style="font-size:13px;">{{ $dat->tipo_pago }}</td>
                    <td style="font-size:13px;">{{ $dat->no_cheque_boleta }}</td>
                    <td style="font-size:13px;">Q. {{{number_format((float) $dat->abono, 2) }}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>
</body>
</html>