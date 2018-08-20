@extends('layouts.app')
@section('content')
<div id="content">
  <div class="container-custom">
    <!-- {!! Form::open(array('class' => 'form', 'id' => 'ProductoForm')) !!} -->
    {!! Form::open( array( 'id' => 'NotaCForm') ) !!}
    <div class="row">
      <div class="col-sm-12">
        <h3 class="tittle-custom"> Creación de Nota de Credito por Refacturación </h3>
        <line>
        </div>
      </div>
      <hr>
      <div class="row">
        <div class="col-lg-12">

         <h4> 
           Información del cliente 
         </h4>

       </div>
       <div class="col-lg-4"> <h5>
         <strong> Cliente: </strong> {{$cliente->cl_nombres}} {{$cliente->cl_apellidos}} </h5>
       </div>
       <div class="col-lg-4"> <h5>
         <strong>  Tipo Cliente:</strong> {{App\Tipo_Cliente::find($cliente->tipo_cliente_id)->tipo_cliente}} </h5>
       </div>
     </div>
     <div class="row">

     </div>
   </br>
   <hr>


  <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">

  <input type="hidden" name="cliente_id" id="cliente_id" value="{{ $cliente->id }}">

  <table id="example" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap" cellspacing="0" width="100%">

    <thead>
      <tr>
       <th>No. Factura</th>
       <th>Total </th>
     </tr>
   </thead>
   <tbody>

    @foreach ($facturas as $factura)
    <tr>
     <td> {{$factura->id}}</td>
     <td> {{$factura->total}}</td>
   </tr>
   @endforeach
 </tbody>
</table>
 <div class="row">
    <div class="col-lg-12">
      <br>
      <br>
      <br>
      <div class="col-lg-6 text-right" style="margin-top: 20px;">
        <span>Total:</span>
      </div>
      <div class="col-lg-6 text-right" style="margin-top: 15px;">
        {!! Form::number( "total" , 0 , ['class' => 'form-control' , 'placeholder' => '0.00', 'disabled' => true, 'id' => 'total' ]) !!}
      </div>
    </div>

  </div>
  <br>
<div class="text-right m-t-15">
  <a class='btn btn-primary form-gradient-color form-button' href="{{ url('/nota_credito') }}">Regresar</a>

  {!! Form::input('button', 'button', 'Crear', ['class' => 'btn btn-danger form-gradient-color form-button', 'id'=>'siguientePaso']) !!}
</div>
<br>

</br>
{!! Form::close() !!}
</div>
</div>

<script type="text/javascript">

  $(document).on("keypress", 'form', function (e) {
    var code = e.keyCode || e.which;
    if (code == 13) {
      e.preventDefault();
      return false;
    }
  });

  var selected = [];



   var example = $('#example').DataTable({

  });



  $('#example tbody').on( 'click', 'tr', function () {
    $(this).toggleClass('selected');
  } );



  $('#example tbody').on( 'click', 'tr', function () {

    var d = example.row( this ).data();

    var id = d[0];
    var total_selected = parseFloat(d[1]);
    var index = $.inArray(id, selected);
    var total = parseFloat($("#total").val());
    if ( index === -1 ) {
      selected.push(id);

      $("#total").val(total_selected + total);
    } else {
      selected.splice( index, 1 );
       $("#total").val(total - total_selected);
    }

  } );


  $("#siguientePaso").click(function(e) {


    if (selected.length == 0) {

      bootbox.alert("Debe de seleccionar como mìnimo una factura");
    }

    else 
    {
      var form = document.createElement("form");
      var element1 = document.createElement("input");  
      var element2 = document.createElement("input");  
      var element3 = document.createElement("input");  
       var element4 = document.createElement("input");  



      form.method = "POST";
      form.action = "/nota_credito/generarRef";   

      element1.value=selected;
      element1.name="selected";
      form.appendChild(element1); 


      element2.value= $("#token").val();
      element2.name="_token";
      form.appendChild(element2); 


      element3.value= $("#cliente_id").val();
      element3.name="cliente_id";
      form.appendChild(element3); 

       element4.value= $("#total").val();
      element4.name="total";
      form.appendChild(element4); 

      document.body.appendChild(form);

      form.submit();

      // window.location = '/factura_cambiaria/generar' + "?selected=" + selected;

    }
  });

</script>

@endsection
@section('scripts')
{!! HTML::script('/sfi/js/notac/crearDescuento3.js') !!}
@endsection
