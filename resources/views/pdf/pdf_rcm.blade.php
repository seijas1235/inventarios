<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
    
    <title>Compras de Combustible en Galones por Mes</title>
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
        <h1 style="text-align:center;">Compra de Combustible en Galones por Mes </h1>
        <h3 style="text-align:center;">Centro de Servicio Texaco</h3>
        <h3 style="text-align:center;">La Nueva San José, Chiquimula, Chiquimula </h3>
        
        <table border="1" cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
            <tr>
                <td width=50% style="font-size:15px;"> Usuario: {{$user}}  </td>
                <td width=50% style="font-size:15px;"> Mes: {{$mecesito->mes}}, {{$anio}}  </td>
            </tr>
            <tr>
                <td width=100% style="font-size:15px;" colspan=2> Fecha y hora de impresión: {{ Carbon\Carbon::parse($today)->format('d-m-Y H:i:s') }} </td>
            </tr>
        </table>
        <br>
        <table border="1" cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
           <thead>
               <tr>
                   <th width=40% style="text-align:center;" rowspan:2> TOTALES </th>
                   <th width=15% style="text-align:center;"> SUPER </th>
                   <th width=15% style="text-align:center;"> REGULAR </th>
                   <th width=15% style="text-align:center;"> DIESEL </th>
                   <th width=15% style="text-align:center;"> TOTAL MES </th>
               </tr>
           </thead>
           <tbody>
               @foreach ($total as $tot)
               <tr>
                   <td width=40% style="font-size:15px; text-align:center;"> </td>
                   <td widht=15% style="font-size:15px; text-align:center;"> {{{number_format((float) $tot->tot_super, 2) }}} </td>
                   <td widht=15% style="font-size:15px; text-align:center;"> {{{number_format((float) $tot->tot_regular, 2) }}} </td>
                   <td widht=15% style="font-size:15px; text-align:center;"> {{{number_format((float) $tot->tot_diesel, 2) }}} </td>
                   <td widht=15% style="font-size:15px; text-align:center;"> {{{number_format((float) $tot->total_gals, 2) }}} </td>
               </tr>
               @endforeach
           </tbody>    
       </table>
       <br>
       <table border="1" cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
        <thead>
            <tr>
                <th width=20%>Fecha</th>
                <th width=20%>No Documento</th>
                <th width=15%>Super</th>
                <th width=15%>Regular</th>
                <th width=15%>Diesel</th>
                <th width=15%>Total Galones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $dat)
            <tr>
                <td style="font-size:12px;" style="text-align:center;">{{ Carbon\Carbon::parse($dat->fecha_corte)->format('d-m-Y') }}</td>
                <td style="font-size:12px; text-align:left;">{{ $dat->serie_factura }} {{ $dat->no_factura }}</td>
                <td style="font-size:12px; text-align:center;">{{{number_format((float) $dat->gal_super, 2) }}}</td>
                <td style="font-size:12px; text-align:center;">{{{number_format((float) $dat->gal_regular, 2) }}}</td>
                <td style="font-size:12px; text-align:center;">{{{number_format((float) $dat->gal_diesel, 2) }}}</td>
                <td style="font-size:12px; text-align:center;">{{{number_format((float) $dat->total_galones, 2) }}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>
</div>
</body>
</html>