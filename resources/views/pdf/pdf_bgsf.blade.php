<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Listado de Cobro de Seguros por Combustible</title>
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
        <h1 style="text-align:center;">Listado de Cobro de Seguros por Combustible </h1>
        <h3 style="text-align:center;">Centro de Servicio Puma</h3>
        <h3 style="text-align:center;">Teculután, Zacapa </h3>
        
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
                <td style="font-size:20px;"> Total por Cobrar por Seguro </td>
                @foreach ($total as $totales)
                <td style="font-size:20px;">Q. {{{number_format((float) $totales->Total, 2) }}}</td>
                @endforeach
            </tr>
        </table>
        <br>
        <table border="1" cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th width=15%>Fecha</th>
                    <th width=10%>No Pedido</th>
                    <th width=10%>No Carga</th>
                    <th width=15%>Gal Super</th>
                    <th width=15%>Gal Regular</th>
                    <th width=15%>Gal Diesel</th>
                    <th width=15%>Total Gals</th>
                    <th width=15%>Seguro</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $dat)
                <tr>
                    <td style="font-size:13px; text-align:center;">{{ Carbon\Carbon::parse($dat->fecha_compra)->format('d-m-Y') }}</td>
                    <td style="font-size:13px; text-align:center;">{{ $dat->no_pedido }}</td>
                    <td style="font-size:13px; text-align:center;">{{ $dat->no_carga }}</td>
                    <td style="font-size:13px; text-align:center;">{{{number_format((float) $dat->gal_super, 2) }}}</td>
                    <td style="font-size:13px; text-align:center;">{{{number_format((float) $dat->gal_regular, 2) }}}</td>
                    <td style="font-size:13px; text-align:center;">{{{number_format((float) $dat->gal_diesel, 2) }}}</td>
                    <td style="font-size:13px; text-align:center;">{{{number_format((float) $dat->total_galones, 2) }}}</td>
                    <td style="font-size:13px; text-align:right;">Q.{{{number_format((float) $dat->total_seguro, 2) }}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>
</body>
</html>