<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=big5">
    
    <title>Saldos de Clientes por Cierre de Mes</title>
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
        <h1 style="text-align:center;">Saldos de Clientes por Cierre de Mes </h1>
        <h3 style="text-align:center;">Centro de Servicio Texaco</h3>
        <h3 style="text-align:center;">La Nueva San José, Chiquimula, Chiquimula </h3>
        
        <table border="1" cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
            <tr>
                <td style="font-size:15px;"> Usuario: {{$user}}  </td>
            </tr>
            <tr>
                <td style="font-size:15px;"> Fecha y hora de impresión: {{ Carbon\Carbon::parse($today)->format('d-m-Y H:i:s') }} </td>
            </tr>
        </table>
        <br>
        <table border="1" cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
            <tr>
                <td style="font-size:20px;"> Total Cuentas por Cobrar al {{$f1}} </td>
                @foreach ($total as $totales)
                <td style="font-size:20px;">Q. {{{number_format((float) $totales->Total, 2) }}}</td>
                @endforeach
            </tr>
        </table>
        <br>
        <table border="1" cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th width=20%>Nit</th>
                    <th width=35%>Cliente</th>
                    <th width=25%>Saldo</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $dat)
                <tr>
                    <td style="font-size:13px; text-align:center;">{{ $dat->nit }}</td>
                    <td style="font-size:13px; text-align:left;">{{ $dat->cliente }}</td>
                    <td style="font-size:13px; text-align:center;">Q {{{number_format((float) $dat->saldo, 2) }}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>
</body>
</html>