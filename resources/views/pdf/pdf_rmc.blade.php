<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
    
    <title>Movimientos de Combustible</title>
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
        <h1 style="text-align:center;">Movimienetos de Combustible </h1>
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
                    <th width=10%>Fecha</th>
                    <th width=10%>Entrada Super</th>
                    <th width=10%>Salida Super</th>
                    <th width=10%>Existencia Super</th>
                    <th width=10%>Entrada Regular</th>
                    <th width=10%>Salida Regular</th>
                    <th width=10%>Existencia Regular</th>
                    <th width=10%>Entrada Diesel</th>
                    <th width=10%>Salida Diesel</th>
                    <th width=10%>Existencia Diesel</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $dat)
                <tr>
                    <td style="font-size:11px; text-align:center;">{{ Carbon\Carbon::parse($dat->fecha_inventario)->format('d-m-Y') }}</td>
                    <td style="font-size:11px; text-align:center;">{{{number_format((float) $dat->gal_sup_entrada, 2) }}}</td>
                    <td style="font-size:11px; text-align:center;">{{{number_format((float) $dat->gal_sup_salida, 2) }}}</td>
                    <td style="font-size:11px; text-align:center;">{{{number_format((float) $dat->gal_sup_existencia, 2) }}}</td>
                    <td style="font-size:11px; text-align:center;">{{{number_format((float) $dat->gal_reg_entrada, 2) }}}</td>
                    <td style="font-size:11px; text-align:center;">{{{number_format((float) $dat->gal_reg_salida, 2) }}}</td>
                    <td style="font-size:11px; text-align:center;">{{{number_format((float) $dat->gal_reg_existencia, 2) }}}</td>
                    <td style="font-size:11px; text-align:center;">{{{number_format((float) $dat->gal_die_entrada, 2) }}}</td>
                    <td style="font-size:11px; text-align:center;">{{{number_format((float) $dat->gal_die_salida, 2) }}}</td>
                    <td style="font-size:11px; text-align:center;">{{{number_format((float) $dat->gal_die_existencia, 2) }}}</td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>
</body>
</html>