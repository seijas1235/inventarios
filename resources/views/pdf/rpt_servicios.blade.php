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
    <center><h1>Car-Zone Chiquimula </h1> </center>
    <center><h3>Reporte de Servicios realizados por Fecha </h3></center>
    <h4> <center>Del {{$fecha_inicial}} al {{$fecha_final}} </center> <p align="right"> Generado por: {{$user}}  </p>  </h4>

    <table border="1" width="100%">
        <tr>
            <th style="border: 0px">Fecha</th>
            <th style="border: 0px">Codigo</th>
            <th style="border: 0px">Cantidad</th>
            <th style="border: 0px">servicio</th>
            
            <th style="border: 0px">precio</th>
            <th style="border: 0px">Subtotal</th>
        </tr>

        @foreach ($detalles as $detalle)
        <tr>
            <td style="text-align: center">{{$detalle->fecha}}</td>

            <td style="text-align: center">{{$detalle->codigo}}</td>
            <td style="text-align: center">{{$detalle->cantidad}}</td>
            <td style="text-align: center">{{$detalle->nombre}}</td>
            <td style="text-align: center">Q {{number_format($detalle->precio,2)}}</td>
            <td style="text-align: center">Q {{number_format($detalle->subtotal,2)}}</td>
        </tr>            
        @endforeach
    </table>

</body>
</html>