<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estado de cuenta por pagar</title>
    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<style>

  html{
    margin 0;
  }
    .table {
        height: auto;
    }

    th{
        background-color:gray;
        color: white;
        text-align: center;
    }

</style>

</head>
<body>

    <center><h3>Estado de cuenta de Proveedores</h3></center>
    <center><h4>Al {{$fecha}}</h4></center>

    <table border="1" width="100%">
        <tr>
            <th style="border: 0px">No.</th>
            <th style="border: 0px">Codigo Proveedor</th>
            <th style="border: 0px">Nombre Proveedor</th>
            <th style="border: 0px">Saldo Actual</th>
        </tr>

        @foreach ($detalles as $detalle)
        <tr>
            <td style="text-align: center">{{$detalle->id}}</td>
            <td style="text-align: center">{{$detalle->proveedor_id}}</td>
            <td style="text-align: center">{{$detalle->nombre}}</td>
            <td style="text-align: center">Q {{number_format($detalle->total,2)}}</td>
        </tr>            
        @endforeach
    </table>

</body>
</html>