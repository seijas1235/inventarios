<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
    
    <title>Estado de Cuenta por Cliente</title>
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
            <h1 style="text-align:center;">Estado de Cuenta por Cliente </h1>
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
                @foreach ($clientes as $cl)
                <tr>
                    <td style="font-size:15px;" width="50%"> Código del Cliente: {{$cl->id}}  </td>
                    <td style="font-size:15px;" width="50%"> Nombre del Cliente: {{$cl->cl_nombres}} {{$cl->cl_apellidos}} </td>
                </tr>
                <tr>
                    <td style="font-size:15px;" width="50%"> NIT del Cliente: {{$cl->cl_nit}} </td>
                    <td style="font-size:15px;" width="50%"> Telefono del Cliente: {{$cl->cl_telefonos}} </td>
                </tr>
                <tr>
                    <td style="font-size:15px;" colspan=2> Dirección del Cliente: {{$cl->cl_direccion}} </td>
                </tr>
                @endforeach
            </table>
            <br>
            <table border="1" cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
                <tr>
                    <td style="font-size:15px;"> Saldo hasta {{$mes->mes}} de {{$aa}}: Q. {{{number_format((float) $saldo_viene->saldo, 2) }}}  </td>
                </tr>
            </table>
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

                    @if($dat->Cargos>0)
                    @php
                    $saldo_viene->saldo = $saldo_viene->saldo+$dat->Cargos;
                    @endphp
                    @else 
                    @php
                    $saldo_viene->saldo = $saldo_viene->saldo-$dat->Abonos;
                    @endphp
                    @endif

                    @if( Carbon\Carbon::parse($dat->fecha)->format('d-m-Y') >= Carbon\Carbon::parse($fechai)->format('d-m-Y') )
                    <tr>
                        <td style="font-size:12px;" style="text-align:center;">{{ Carbon\Carbon::parse($dat->fecha)->format('d-m-Y') }}</td>
                        <td style="font-size:12px;" style="text-align:left;">{{ $dat->doc }}</td>
                        <td style="font-size:12px;" style="text-align:right;">Q. {{{number_format((float) $dat->Cargos, 2) }}}</td>
                        <td style="font-size:12px;" style="text-align:right;">Q. {{{number_format((float) $dat->Abonos, 2) }}}</td>
                        <td style="font-size:12px;" style="text-align:right;">Q. {{{number_format((float) $saldo_viene->saldo, 2) }}}
                        </td>
                    </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>