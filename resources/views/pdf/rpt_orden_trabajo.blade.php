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
    /*th {
        background-color: gray;
        color: white;
    }*/

    .row-doble{
      width: 92%;
    }

    .circulo {
     width: 10px;
     height: 10px;
     -moz-border-radius: 50%;
     -webkit-border-radius: 50%;
     border-radius: 50%;
     position: absolute;
     border: solid 3px red;
     overflow: hidden;
}

.triangulo-2 {
     width: 0; 
     height: 0; 
     border-left: 30px solid #ff0000;
     border-top: 15px solid transparent;
     border-bottom: 15px solid transparent;
     position: absolute; 
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
          <td><center>  <h5>Orden de Trabajo</h5> <p>
          Recepcion de vehiculos/ mecánica automotriz </center>
          </td> 
        </tr>
      </table>
  </div>
@foreach ($data as $item)
    

  <br>
  <div class="row">
    <div class="col-xs-6">
      Num. de orden: <b>{{$item->id}}</b>
    </div>

    <div class="col-xs-6">
      Fecha y hora: {{$item->fecha_hora}}
    </div>
  </div>

  <br>

  <div class="row">
    <div class="col-xs-4">
     Responsable de la recepcion: {{$item->resp_recepcion}}
    </div>

    <div class="col-xs-4">
      Fecha entrega prometida: {{$item->fecha_prometida}}
    </div>

    <div class="col-xs-4">
        Vo.Bo. _________________
    </div>
  </div>
  <br>
  <div class="row">
    <table border="0" cellpadding="0" cellspacing="0" width="100%">      
      <tbody>
        <tr>
          <td style="width: 50%; vertical-align: top;">
            <table border="1" cellpadding="0" cellspacing="0" width="100%">

              <tbody>
                <tr>
                <td colspan="4" align="center" style="border: 3px solid"> <b>Datos del Cliente</b> </td>
                </tr>
                <tr>
                  <td colspan="4">Nombre: {{$item->nombrecliente}} </td>
                </tr>
                <tr>
                  <td colspan="4">e-mail: {{$item->email}} </td>
                </tr>
                <tr>
                  <td colspan="2">Nit: {{$item->nit}} </td>
                  <td colspan="2">Teléfono: {{$item->telefonos}} </td>
                </tr>
              </tbody>

            </table>
          </td>
        <td style="width: 50%; vertical-align: top;">

        <table border="1" cellpadding="0" cellspacing="0" width="100%">         
        <tbody>

        <tr>
        <td colspan="4" align="center" style="border: 3px solid"> <b> Datos del vehiculo</b></td>
        </tr>
        <tr>
          <td colspan="2">Marca: {{$item->marca}}</td>
          <td colspan="2">Linea: {{$item->linea}}</td>
        </tr>
        <tr>
          <td colspan="2">Color: {{$item->color}}</td>
          <td colspan="2">Año: {{$item->año}}</td>
        </tr>
        <tr>
          <td colspan="2">Placa: {{$item->placa}}</td>
          <td colspan="2">Chasis: {{$item->chasis}}</td>
        </tr>
        <tr>
          <td colspan="4">Kilometraje: {{$item->kilometraje}}</td>
        </tr>

        </tbody>

        </table>

        </td>
        </tr>
      </tbody>
    </table>
  </div>
  <br>
  @endforeach

  <div class="row" style="padding-bottom:0.2cm">
  <div class="col-xs-6" style="margin-left:-15px">
    <table border="1" width="100%">
      <tr>
        <td colspan="4" align="center" style="border: 3px solid"><b>Componentes/accesorios</b></td>
      </tr>
      @foreach ($componentes as $componente)
      @if($componente->emblemas == 1) 
        <tr>     
          <td colspan="4"><input type="checkbox" checked/> Emblemas</td>
        </tr>
      @endif

      @if($componente->encendedor == 1)
        <tr>     
          <td colspan="4"><input type="checkbox" checked/> Encendedor</td>
        </tr>
      @endif
      @if($componente->espejos == 1)
      <tr>     
        <td colspan="4"><input type="checkbox" checked/> Espejos</td>
      </tr>
      @endif
      @if($componente->antena == 1)
      <tr>     
        <td colspan="4"><input type="checkbox" checked/> Antena</td>
      </tr>
      @endif
      @if($componente->radio == 1)
      <tr>     
        <td colspan="4"><input type="checkbox" checked/> Radio</td>
      </tr>
      @endif
      @if($componente->llavero == 1)
      <tr>     
        <td colspan="4"><input type="checkbox" checked/> Llavero</td>
      </tr>
      @endif
      @if($componente->placas == 1)
      <tr>     
        <td colspan="4"><input type="checkbox" checked/> Placas</td>
      </tr>
      @endif
      @if($componente->platos == 1)
      <tr>     
        <td colspan="4"><input type="checkbox" checked/> Platos</td>
      </tr>
      @endif
      @if($componente->tapon_combustible == 1)
      <tr>     
        <td colspan="4"><input type="checkbox" checked/> Tapon combustible</td>
      </tr>
      @endif
      @if($componente->soporte_bateria == 1)
      <tr>     
        <td colspan="4"><input type="checkbox" checked/> Soporte bateria</td>
      </tr>
      @endif
      @if($componente->papeles == 1)
      <tr>     
        <td colspan="4"><input type="checkbox" checked/> Papeles</td>
      </tr>
      @endif
      @if($componente->alfombras == 1)
      <tr>     
        <td colspan="4"><input type="checkbox" checked/> Alfombras</td>
      </tr>
      @endif
      @if($componente->control_alarma == 1)
      <tr>     
        <td colspan="4"><input type="checkbox" checked/> Control alarma</td>
      </tr>
      @endif
      @if($componente->extinguidor == 1)
      <tr>     
        <td colspan="4"><input type="checkbox" checked/> Extinguidor</td>
      </tr>
      @endif
      @if($componente->triangulos == 1)
      <tr>     
        <td colspan="4"><input type="checkbox" checked/> Triangulos</td>
      </tr>
      @endif
      @if($componente->vidrios_electricos == 1)
      <tr>     
        <td colspan="4"><input type="checkbox" checked/> Vidrios Electricos</td>
      </tr>
      @endif
      @if($componente->conos == 1)
      <tr>     
        <td colspan="4"><input type="checkbox" checked/> Conos</td>
      </tr>
      @endif
      @if($componente->neblineras == 1)
      <tr>     
        <td colspan="4"><input type="checkbox" checked/> Neblineras</td>
      </tr>
      @endif
      @if($componente->luces == 1)
      <tr>     
        <td colspan="4"><input type="checkbox" checked/> Luces</td>
      </tr>
      @endif
      @if($componente->llanta_repuesto == 1)
      <tr>     
        <td colspan="4"><input type="checkbox" checked/> Llanta repuesto</td>
      </tr>
      @endif
      @if($componente->llave_ruedas == 1)
      <tr>     
        <td colspan="4"><input type="checkbox" checked/> Llave ruedas</td>
      </tr>
      @endif
      @if($componente->tricket == 1)
      <tr>     
        <td colspan="4"><input type="checkbox" checked/> Tricket</td>
      </tr>
      @endif

      @endforeach

      <tr>
        <td colspan="4">Observaciones: {{$componente->descripcion}}  </td>
      </tr>
    </table>
  </div>

    <div class="col-xs-6">
        @foreach ($componentes as $componente)
        <img src="./img/tanque.jpg" alt="No hay imagen" width="90%">    
        {{--<input type="checkbox" style="position:absolute; top:88px; left:55px;" value="0" placeholder="E" {{$componente->combustible ==0 ? 'checked': ''}}>
        <input type="checkbox" style="position:absolute; top:76px; left:83px;" value="1" placeholder="1/8" {{$componente->combustible ==1 ? 'checked': ''}}>
        <input type="checkbox" style="position:absolute; top:70px; left:120px;" value="2" placeholder="1/4" {{$componente->combustible ==2 ? 'checked': ''}}>
        <input type="checkbox" style="position:absolute; top:63px; left:148px;" value="3" placeholder="3/8" {{$componente->combustible ==3 ? 'checked': ''}}>
        <input type="checkbox" style="position:absolute; top:61px; left:181px;" value="4" placeholder="1/2" {{$componente->combustible ==4 ? 'checked': ''}}>
        <input type="checkbox" style="position:absolute; top:63px; left:215px;" value="5" placeholder="5/8" {{$componente->combustible ==5 ? 'checked': ''}}>
        <input type="checkbox" style="position:absolute; top:70px; left:250px;" value="6" placeholder="3/4" {{$componente->combustible ==6 ? 'checked': ''}}>
        <input type="checkbox" style="position:absolute; top:79px; left:283px;" value="7" placeholder="7/8" {{$componente->combustible ==7 ? 'checked': ''}}>
        <input type="checkbox" style="position:absolute; top:90px; left:317px;" value="8" placeholder="Full" {{$componente->combustible ==8 ? 'checked': ''}}>--}}

        <div class="circulo {{$componente->combustible ==0 ? '': 'hidden'}}" style="top:89px; left:52px"></div>
        <div class="circulo {{$componente->combustible ==1 ? '': 'hidden'}}" style="top:80px; left:77px"></div>
        <div class="circulo {{$componente->combustible ==2 ? '': 'hidden'}}" style="top:71px; left:112px"></div>
        <div class="circulo {{$componente->combustible ==3 ? '': 'hidden'}}" style="top:66px; left:148px"></div>
        <div class="circulo {{$componente->combustible ==4 ? '': 'hidden'}}" style="top:64px; left:179px"></div>
        <div class="circulo {{$componente->combustible ==5 ? '': 'hidden'}}" style="top:66px; left:216px"></div>
        <div class="circulo {{$componente->combustible ==6 ? '': 'hidden'}}" style="top:73px; left:255px"></div>
        <div class="circulo {{$componente->combustible ==7 ? '': 'hidden'}}" style="top:82px; left:286px"></div>
        <div class="circulo {{$componente->combustible ==8 ? '': 'hidden'}}" style="top:97px; left:317px"></div>
        {{--<div class="triangulo-2 {{$componente->combustible ==8 ? '': 'hidden'}}" style="top:90px; left:317px"></div>--}}        
        @endforeach
    </div>
  </div>


  <div class="row">
      <table border="1" width="100%">
        <tr>
          <td colspan="8" align="center" style="border: 3px solid"><b>Servicios solicitados</b></td>
        </tr>
        <tr>
          <td colspan="2" align="center" style="border: 3px solid"> <b>Nombre servicio</b> </td>
          <td colspan="2" align="center" style="border: 3px solid"> <b>Precio</b> </td>
          <td colspan="2" align="center" style="border: 3px solid"> <b>Mano de obra</b> </td>
          <td colspan="2" align="center" style="border: 3px solid"> <b>Subtotal</b> </td>
        </tr>

        @foreach ($detalles as $detalle)
          <tr>
            <td colspan="2" align="center"> {{$detalle->nombre}} </td>
            <td colspan="2" align="center"> Q. {{$detalle->precio}} </td>
            <td colspan="2" align="center"> Q. {{$detalle->mano_obra}} </td>
            <td colspan="2" align="center"> Q. {{$detalle->subtotal}} </td>
          </tr>
        @endforeach


        @foreach ($data as $item)
        <tr>
          <td colspan="6" align="left"><b>Total</b></td>
          <td colspan="2" align="center"> <b>Q.{{$item->total}}</b> </td>
        </tr>
        @endforeach

      </table>
    </div>   

    <!-- Latest compiled and minified JavaScript -->
{{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>--}}
</body>
</html>