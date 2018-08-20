<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Diferencias de Combustible por Fechas</title>
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
<body>
    <div class="container">
       <div class="row">
        <div class="col-md-12">
            <h1 style="text-align:center;">Diferencias de Combustible por Fechas </h1>
        <h3 style="text-align:center;">Centro de Servicio Texaco</h3>
        <h3 style="text-align:center;">La Nueva San José, Chiquimula, Chiquimula </h3>
            
            <table border="1" cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
                <tr>
                    <td style="font-size:15px;" width="50%"> Usuario: {{$user}}  </td>
                    <td style="font-size:15px;" width="50%"> Fecha y hora de impresión: {{ Carbon\Carbon::parse($today)->format('d-m-Y H:i:s') }} </td>
                </tr>
                <tr>
                    <td style="font-size:15px;" colspan=2> Busqueda del {{ Carbon\Carbon::parse($fechai)->format('d-m-Y') }} al {{ Carbon\Carbon::parse($fechaf)->format('d-m-Y') }} </td>
                </tr>
            </table>
            <br>
            <table border="1" cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
                @foreach ($combustibles as $comb)
                <tr>
                    <td style="font-size:15px;" width="50%"> Tipo de Combustible: {{$comb->combustible}}  </td>
                </tr>
                @endforeach
            </table>
            <br>
            <table border="1" cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th width=10%>Fecha</th>
                        <th width=15%>Galones del día</th>
                        <th width=15%>Galones Sistema</th>
                        <th width=15%>Compras</th>
                        <th width=15%>Saldo Galones</th>
                        <th width=15%>Dif del Día</th>
                        <th width=15%>Dif Acumulada</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $dat)
                    <tr>
                        <td style="font-size:12px;" style="text-align:center;">{{ Carbon\Carbon::parse($dat->fecha)->format('d-m-Y') }}</td>
                        <td style="font-size:12px;" style="text-align:center;">{{{number_format((float) $dat->venta_dia, 2) }}}</td>
                        <td style="font-size:12px;" style="text-align:center;">{{{number_format((float) $dat->sistema, 2) }}}</td>
                        <td style="font-size:12px;" style="text-align:center;">{{{number_format((float) $dat->compras, 2) }}}</td>
                        <td style="font-size:12px;" style="text-align:center;">{{{number_format((float) $dat->saldo, 2) }}}
                        </td>
                        <td style="font-size:12px;" style="text-align:center;">{{{number_format((float) $dat->dif_dia, 2) }}}
                        </td>
                        <td style="font-size:12px;" style="text-align:center;">{{{number_format((float) $dat->dif_acum, 2) }}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>