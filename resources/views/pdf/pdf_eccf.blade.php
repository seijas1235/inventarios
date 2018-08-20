<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=big5">
    
    <title>Saldos por Cliente y Fecha</title>
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
            <h1 style="text-align:center;">Saldos por Cliente y Fecha </h1>
        <h3 style="text-align:center;">Centro de Servicio Texaco</h3>
        <h3 style="text-align:center;">La Nueva San José, Chiquimula, Chiquimula </h3>
            
            <table border="1" cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
                <tr>
                    <td style="font-size:15px;" width="50%"> Usuario: {{$user}}  </td>
                    <td style="font-size:15px;" width="50%"> Fecha y hora de impresión: {{ Carbon\Carbon::parse($today)->format('d-m-Y H:i') }} </td>
                </tr>
                <tr>
                    <td style="font-size:15px;" colspan=2> Saldos hasta el: {{ Carbon\Carbon::parse($fecha)->format('d-m-Y') }} </td>
                </tr>
            </table>
            <br>
<table border="1" cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
            <tr>
                <td style="font-size:20px;" width="50%"> Suma de Saldos </td>
                @foreach ($saldos as $sal)
                <td style="font-size:20px;" width="50%">Q. {{{number_format((float) $sal->saldo_anterior + $sal->total_cargos - $sal->total_abonos, 2) }}} </td>
                @endforeach
            </tr>
        </table>
<br>
            <table border="1" cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th width=28%>Cliente</th>
                        <th width=18%>Saldo Mes Anterior</th>
                        <th width=18%>Total Cargos</th>
                        <th width=18%>Total Abonos</th>
                        <th width=18%>Saldo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $dat)
                    <tr>
                        <td style="font-size:12px;" style="text-align:left;">{{ $dat->cliente }}</td>
                        <td style="font-size:12px;" style="text-align:center;">Q. {{{number_format((float) $dat->saldo_anterior, 2) }}}</td>
                        <td style="font-size:12px;" style="text-align:right;">Q. {{{number_format((float) $dat->total_cargos, 2) }}}</td>
                        <td style="font-size:12px;" style="text-align:right;">Q. {{{number_format((float) $dat->total_abonos, 2) }}}</td>
                        <td style="font-size:12px;" style="text-align:right;">Q. {{{number_format((float) $dat->saldo_anterior + $dat->total_cargos - $dat->total_abonos, 2) }}}
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