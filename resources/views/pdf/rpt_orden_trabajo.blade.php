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

    .circulo-2 {
     width: 7px;
     height: 7px;
     -moz-border-radius: 50%;
     -webkit-border-radius: 50%;
     border-radius: 50%;
     position: absolute;
     border: solid 2px orange;
     overflow: hidden;
}

.circulo-3 {
     width: 5px;
     height: 5px;
     radius: 50%;
     position: absolute;
     background-color: red;
     overflow: hidden;
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

  <div class="row" style="padding-bottom:0.2cm; padding-right:0">
  <div class="col-xs-6" style="margin-left:-15px">
    <table border="1" width="100%">
      <tr>
        <td colspan="6" align="center" style="border: 3px solid"><b>Componentes/accesorios</b></td>
      </tr>
      @foreach ($componentes as $componente)
        <tr>     
          <td colspan="2"><input type="checkbox" {{$componente->emblemas == 1 ? 'checked': ''}}> Emblemas</td>
          <td colspan="2"><input type="checkbox" {{$componente->encendedor == 1 ? 'checked': ''}}/> Encendedor</td>
          <td colspan="2"><input type="checkbox" {{$componente->espejos == 1 ? 'checked': ''}}/> Espejos</td>
        </tr>

        <tr>     
          <td colspan="2"><input type="checkbox" {{$componente->antena == 1 ? 'checked': ''}}/> Antena</td>
          <td colspan="2"><input type="checkbox" {{$componente->radio == 1 ? 'checked': ''}}/> Radio</td>
          <td colspan="2"><input type="checkbox" {{$componente->llavero == 1 ? 'checked': ''}}/> Llavero</td>
        </tr>
   
        <tr>     
          <td colspan="2"><input type="checkbox" {{$componente->placas == 1 ? 'checked': ''}}/> Placas</td>
          <td colspan="2"><input type="checkbox" {{$componente->platos == 1 ? 'checked': ''}}/> Platos</td>
          <td colspan="2"><input type="checkbox" {{$componente->tapon_combustible == 1 ? 'checked': ''}}/> Tapon de combustible</td>
        </tr>

        <tr>     
          <td colspan="2"><input type="checkbox" {{$componente->soporte_bateria == 1 ? 'checked': ''}}/> Soporte bateria</td>
          <td colspan="2"><input type="checkbox" {{$componente->papeles == 1 ? 'checked': ''}}/> Papeles</td>
          <td colspan="2"><input type="checkbox" {{$componente->alfombras == 1 ? 'checked': ''}}/> Alfombras</td>
        </tr>

        <tr>     
          <td colspan="2"><input type="checkbox" {{$componente->control_alarma == 1 ? 'checked': ''}}/> Control alarma</td>
          <td colspan="2"><input type="checkbox" {{$componente->extinguidor == 1 ? 'checked': ''}}/> Extinguidor</td>
          <td colspan="2"><input type="checkbox" {{$componente->triangulos == 1 ? 'checked': ''}}/> Triangulos</td>
        </tr>
  
        <tr>     
          <td colspan="2"><input type="checkbox" {{$componente->conos == 1 ? 'checked': ''}}/> Conos</td>
          <td colspan="2"><input type="checkbox" {{$componente->neblineras == 1 ? 'checked': ''}}/> Neblineras</td>
          <td colspan="2"><input type="checkbox" {{$componente->tricket == 1 ? 'checked': ''}}/> Tricket</td>
        </tr>

        <tr>
          <td colspan="2"><input type="checkbox" {{$componente->luces == 1 ? 'checked': ''}}/> Luces</td>
          <td colspan="2"><input type="checkbox" {{$componente->llanta_repuesto == 1 ? 'checked': ''}}/> Llanta repuesto</td>
          <td colspan="2"><input type="checkbox" {{$componente->llave_ruedas == 1 ? 'checked': ''}}/> Llave ruedas</td>
        </tr>

        <tr>     
          <td colspan="6"><input type="checkbox" {{$componente->vidrios_electricos == 1 ? 'checked': ''}}/> Vidrios Electricos</td>
        </tr>

      @endforeach

      <tr>
        <td colspan="6"> <b>Observaciones:</b>  {{$componente->descripcion}}  </td>
      </tr>
    </table>
  </div>

<!-- Combustible -->
    <div class="col-xs-6">
        @foreach ($componentes as $componente)
        <img src="./img/tanque.jpg" alt="No hay imagen" width="90%">    
    
        <div class="circulo {{$componente->combustible ==0 ? '': 'hidden'}}" style="top:89px; left:52px"></div>
        <div class="circulo {{$componente->combustible ==1 ? '': 'hidden'}}" style="top:80px; left:77px"></div>
        <div class="circulo {{$componente->combustible ==2 ? '': 'hidden'}}" style="top:71px; left:112px"></div>
        <div class="circulo {{$componente->combustible ==3 ? '': 'hidden'}}" style="top:66px; left:148px"></div>
        <div class="circulo {{$componente->combustible ==4 ? '': 'hidden'}}" style="top:64px; left:179px"></div>
        <div class="circulo {{$componente->combustible ==5 ? '': 'hidden'}}" style="top:66px; left:216px"></div>
        <div class="circulo {{$componente->combustible ==6 ? '': 'hidden'}}" style="top:73px; left:255px"></div>
        <div class="circulo {{$componente->combustible ==7 ? '': 'hidden'}}" style="top:82px; left:286px"></div>
        <div class="circulo {{$componente->combustible ==8 ? '': 'hidden'}}" style="top:97px; left:317px"></div>   
        @endforeach
      
          <div class="circulo-2" style="top:157px; left:90px"> </div>

          <div class="circulo-3" style="top:179px; left:150px"></div>

         <div>Rayones =</div> 
         <div>Golpes y abollenes =</div>
    </div>
  </div>
  <!-- rayones y golpes -->
  <div class="row">
    <div class="col-xs-3" style="padding:0">
        <!-- imagen frente 1 -->
        @foreach ($rayones as $rayon)
            
        <div class="circulo-2 {{$rayon->img1_1 ==1 ? '': 'hidden'}}" style="top:20px; left:15px"></div>
        <div class="circulo-2 {{$rayon->img1_2 ==1 ? '': 'hidden'}}" style="top:23px; left:40px"></div>
        <div class="circulo-2 {{$rayon->img1_3 ==1 ? '': 'hidden'}}" style="top:20px; left:63px"></div>
        <div class="circulo-2 {{$rayon->img1_4 ==1 ? '': 'hidden'}}" style="top:40px; left:15px"></div>
        <div class="circulo-2 {{$rayon->img1_5 ==1 ? '': 'hidden'}}" style="top:40px; left:40px"></div>
        <div class="circulo-2 {{$rayon->img1_6 ==1 ? '': 'hidden'}}" style="top:40px; left:63px"></div>

        <!-- imagen tracera 1 -->
        <div class="circulo-2 {{$rayon->img1_7 ==1 ? '': 'hidden'}}" style="top:18px; left:108px"></div>
        <div class="circulo-2 {{$rayon->img1_8 ==1 ? '': 'hidden'}}" style="top:19px; left:130px"></div>
        <div class="circulo-2 {{$rayon->img1_9 ==1 ? '': 'hidden'}}" style="top:19px; left:152px"></div>
        <div class="circulo-2 {{$rayon->img1_10 ==1 ? '': 'hidden'}}" style="top:40px; left:102px"></div>
        <div class="circulo-2 {{$rayon->img1_11 ==1 ? '': 'hidden'}}" style="top:40px; left:130px"></div>
        <div class="circulo-2 {{$rayon->img1_12 ==1 ? '': 'hidden'}}" style="top:40px; left:157px"></div> 

        @endforeach

        @foreach ($golpes as $golpe)
            
        <div class="circulo-3 {{$golpe->img1_1 ==1 ? '': 'hidden'}}" style="top:20px; left:15px"></div>
        <div class="circulo-3 {{$golpe->img1_2 ==1 ? '': 'hidden'}}" style="top:23px; left:40px"></div>
        <div class="circulo-3 {{$golpe->img1_3 ==1 ? '': 'hidden'}}" style="top:20px; left:63px"></div>
        <div class="circulo-3 {{$golpe->img1_4 ==1 ? '': 'hidden'}}" style="top:40px; left:15px"></div>
        <div class="circulo-3 {{$golpe->img1_5 ==1 ? '': 'hidden'}}" style="top:40px; left:40px"></div>
        <div class="circulo-3 {{$golpe->img1_6 ==1 ? '': 'hidden'}}" style="top:40px; left:63px"></div>

        <!-- imagen tracera 1 -->
        <div class="circulo-3 {{$golpe->img1_7 ==1 ? '': 'hidden'}}" style="top:18px; left:108px"></div>
        <div class="circulo-3 {{$golpe->img1_8 ==1 ? '': 'hidden'}}" style="top:19px; left:130px"></div>
        <div class="circulo-3 {{$golpe->img1_9 ==1 ? '': 'hidden'}}" style="top:19px; left:152px"></div>
        <div class="circulo-3 {{$golpe->img1_10 ==1 ? '': 'hidden'}}" style="top:40px; left:102px"></div>
        <div class="circulo-3 {{$golpe->img1_11 ==1 ? '': 'hidden'}}" style="top:40px; left:130px"></div>
        <div class="circulo-3 {{$golpe->img1_12 ==1 ? '': 'hidden'}}" style="top:40px; left:157px"></div> 

        @endforeach
        <img src="./img/imagen1.png" width="180">
    </div>
                        
    <div class="col-xs-3" style="padding:0">
        <!-- imagen costado 1 -->
        @foreach ($rayones as $rayon)
        <div class="circulo-2 {{$rayon->img2_1 ==1 ? '': 'hidden'}}" style="top:14px; left:21px"></div>
        <div class="circulo-2 {{$rayon->img2_2 ==1 ? '': 'hidden'}}" style="top:25px; left:10px"></div>
        <div class="circulo-2 {{$rayon->img2_3 ==1 ? '': 'hidden'}}" style="top:25px; left:65px"></div>
        <div class="circulo-2 {{$rayon->img2_4 ==1 ? '': 'hidden'}}" style="top:25px; left:100px"></div>
        <div class="circulo-2 {{$rayon->img2_5 ==1 ? '': 'hidden'}}" style="top:15px; left:133px"></div>
        <div class="circulo-2 {{$rayon->img2_6 ==1 ? '': 'hidden'}}" style="top:28px; left:158px"></div>
        @endforeach 
        
        @foreach ($golpes as $golpe)
        <div class="circulo-3 {{$golpe->img2_1 ==1 ? '': 'hidden'}}" style="top:14px; left:21px"></div>
        <div class="circulo-3 {{$golpe->img2_2 ==1 ? '': 'hidden'}}" style="top:25px; left:10px"></div>
        <div class="circulo-3 {{$golpe->img2_3 ==1 ? '': 'hidden'}}" style="top:25px; left:65px"></div>
        <div class="circulo-3 {{$golpe->img2_4 ==1 ? '': 'hidden'}}" style="top:25px; left:100px"></div>
        <div class="circulo-3 {{$golpe->img2_5 ==1 ? '': 'hidden'}}" style="top:15px; left:133px"></div>
        <div class="circulo-3 {{$golpe->img2_6 ==1 ? '': 'hidden'}}" style="top:28px; left:158px"></div>
        @endforeach 
        <img src="./img/imagen2.png" width="180">
    </div>
    <div class="col-xs-3" style="padding:0">
        <!-- imagen costado 2 -->
        @foreach ($rayones as $rayon)      
        <div class="circulo-2 {{$rayon->img3_1 ==1 ? '': 'hidden'}}" style="top:32px; left:12px"></div>
        <div class="circulo-2 {{$rayon->img3_2 ==1 ? '': 'hidden'}}" style="top:19px; left:28px"></div>
        <div class="circulo-2 {{$rayon->img3_3 ==1 ? '': 'hidden'}}" style="top:25px; left:75px"></div>
        <div class="circulo-2 {{$rayon->img3_4 ==1 ? '': 'hidden'}}" style="top:25px; left:108px"></div>
        <div class="circulo-2 {{$rayon->img3_5 ==1 ? '': 'hidden'}}" style="top:16px; left:146px"></div>
        <div class="circulo-2 {{$rayon->img3_6 ==1 ? '': 'hidden'}}" style="top:30px; left:162px"></div>
        @endforeach  
        
        @foreach ($golpes as $golpe)      
        <div class="circulo-3 {{$golpe->img3_1 ==1 ? '': 'hidden'}}" style="top:32px; left:12px"></div>
        <div class="circulo-3 {{$golpe->img3_2 ==1 ? '': 'hidden'}}" style="top:19px; left:28px"></div>
        <div class="circulo-3 {{$golpe->img3_3 ==1 ? '': 'hidden'}}" style="top:25px; left:75px"></div>
        <div class="circulo-3 {{$golpe->img3_4 ==1 ? '': 'hidden'}}" style="top:25px; left:108px"></div>
        <div class="circulo-3 {{$golpe->img3_5 ==1 ? '': 'hidden'}}" style="top:16px; left:146px"></div>
        <div class="circulo-3 {{$golpe->img3_6 ==1 ? '': 'hidden'}}" style="top:30px; left:162px"></div>
        @endforeach  
        <img src="./img/imagen3.png" width="180">
    </div>
    <div class="col-xs-3" style="padding:0">
        <!-- imagen arriba 1 -->
        @foreach ($rayones as $rayon)    
        <div class="circulo-2 {{$rayon->img4_1 ==1 ? '': 'hidden'}}" style="top:3px; left:14px"></div>
        <div class="circulo-2 {{$rayon->img4_2 ==1 ? '': 'hidden'}}" style="top:27px; left:14px"></div>
        <div class="circulo-2 {{$rayon->img4_3 ==1 ? '': 'hidden'}}" style="top:54px; left:14px"></div>
        <div class="circulo-2 {{$rayon->img4_4 ==1 ? '': 'hidden'}}" style="top:27px; left:31px"></div>
        <div class="circulo-2 {{$rayon->img4_5 ==1 ? '': 'hidden'}}" style="top:27px; left:72px"></div>
        <div class="circulo-2 {{$rayon->img4_6 ==1 ? '': 'hidden'}}" style="top:27px; left:113px"></div>
        @endforeach

        @foreach ($golpes as $golpe)    
        <div class="circulo-3 {{$golpe->img4_1 ==1 ? '': 'hidden'}}" style="top:3px; left:14px"></div>
        <div class="circulo-3 {{$golpe->img4_2 ==1 ? '': 'hidden'}}" style="top:27px; left:14px"></div>
        <div class="circulo-3 {{$golpe->img4_3 ==1 ? '': 'hidden'}}" style="top:54px; left:14px"></div>
        <div class="circulo-3 {{$golpe->img4_4 ==1 ? '': 'hidden'}}" style="top:27px; left:31px"></div>
        <div class="circulo-3 {{$golpe->img4_5 ==1 ? '': 'hidden'}}" style="top:27px; left:72px"></div>
        <div class="circulo-3 {{$golpe->img4_6 ==1 ? '': 'hidden'}}" style="top:27px; left:113px"></div>
        @endforeach
        <img src="./img/imagen4.png" width="180">
    </div>

  </div>
  <div class="row" style="padding-bottom:0.2cm">
    @foreach ($rayones as $rayon)
      <table border="1" width="100%">
        <tr>
          <td style="border: 3px solid"> <b>Observaciones</b> </td>
        </tr>
        <tr>
          <td>{{$rayon->descripcion}}</td>
        </tr>
      </table> 
    @endforeach
    
  </div>

  <!-- Servicios solicitados -->
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