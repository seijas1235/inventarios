<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=big5">
    
    <title>Estado de Cuenta por Empleado</title>
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
            <h1 style="text-align:center;">Estado de Cuenta por Empleado </h1>
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
                @foreach ($empleados as $emp)
                <tr>
                    <td style="font-size:15px;" width="50%"> Código del Empleado: {{$emp->id}}  </td>
                    <td style="font-size:15px;" width="50%"> Nombre del Empleado: {{$emp->emp_nombres}} {{$emp->emp_apellidos}} </td>
                </tr>
                <tr>
                    <td style="font-size:15px;" width="50%"> DPI del Empleado: {{$emp->emp_cui}} </td>
                    <td style="font-size:15px;" width="50%"> Telefono del Empleado: {{$emp->emp_telefonos}} </td>
                </tr>
                <tr>
                    <td style="font-size:15px;" colspan=2> Dirección del Empleado: {{$emp->emp_direccion}} </td>
                </tr>
                @endforeach
            </table>
            <br>
            <table border="1" cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th width=15%>Fecha</th>
                        <th width=35%>Documento</th>
                        <th width=15%>Cargos</th>
                        <th width=15%>Abonos</th>
                        <th width=20%>Saldo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $dat)
                    <tr>
                        <td style="font-size:12px;" style="text-align:center;">{{ Carbon\Carbon::parse($dat->fecha)->format('d-m-Y') }}</td>
                        <td style="font-size:12px;" style="text-align:left;">{{ $dat->doc }}  {{ $dat->no_doc }}</td>
                        <td style="font-size:12px;" style="text-align:right;">Q. {{{number_format((float) $dat->cargos, 2) }}}</td>
                        <td style="font-size:12px;" style="text-align:right;">Q. {{{number_format((float) $dat->abonos, 2) }}}</td>
                        <td style="font-size:12px;" style="text-align:right;">Q. {{{number_format((float) $dat->saldo, 2) }}}
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