<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte Orden Trabajo</title>
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
    .row-doble{
      width: 92%;
    }


</style>

</head>
<body>

  <div class="row">
    <table style="width:100%" border="1">
        <tr>
          <th><center><h4> Registro de calidad</h4></center></th> 
        </tr>
    
        <tr>
          <td><center><h5>Orden de Trabajo</h5> <p>
          Recepcion de vehiculos/ mecánica automotriz </center>
          </td> 
        </tr>
      </table>
  </div>
@foreach ($facturas as $item)
    

  <br>
  <div class="row">
    <div class="col-xs-6">
      Num. de orden: <b>{{$item->serie}}</b>
    </div>

    <div class="col-xs-6">
      Fecha y hora: {{$item->numero}}
    </div>
  </div>

  <br>


  @endforeach
  @foreach ($detalle as $item)
    

  <br>
  <div class="row">
    <div class="col-xs-6">
      Num. de orden: <b>{{$item->id}}</b>
    </div>

    <div class="col-xs-6">
      Fecha y hora: {{$item->subtotal}}
    </div>
  </div>

  <br>


  @endforeach
 
  @foreach ($cliente as $item)
    

  <br>
  <div class="row">
    <div class="col-xs-6">
      Num. de orden: <b>{{$item->nombres}}</b>
    </div>

    <div class="col-xs-6">
      Fecha y hora: {{$item->direccion}}
    </div>
  </div>

  <br>


  @endforeach
 


    <!-- Latest compiled and minified JavaScript -->
{{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>--}}
</body>
</html>