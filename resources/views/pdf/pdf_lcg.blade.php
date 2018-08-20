<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Listado de Clientes</title>
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
        <h1 style="text-align:center;">Listado de Clientes </h1>
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
            <thead>
                <tr>
                    <th width=10%>Código</th>
                    <th width=15%>NIT</th>
                    <th width=20%>Cliente</th>
                    <th width=15%>Telefono</th>
                    <th width=25%>Dirección</th>
                    <th width=15%>Monto Máximo</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $dat)
                <tr>
                    <td style="font-size:13px; text-align:center;">{{ $dat->id }}</td>
                    <td style="font-size:13px; text-align:center;">{{ $dat->cl_nit }}</td>
                    <td style="font-size:13px;">{{ $dat->cl_nombres }} {{ $dat->cl_apellidos }}</td>
                    <td style="font-size:13px; text-align:center;">{{ $dat->cl_telefonos }}</td>
                    <td style="font-size:13px;">{{ $dat->cl_direccion }}</td>
                    <td style="font-size:13px; text-align:right;">Q. {{{number_format((float) $dat->cl_montomaximo, 2) }}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>
</body>
</html>