@extends('layouts.app')
@section('content')
<div id="content">
  <div class="container-custom">
    <!-- {!! Form::open(array('class' => 'form', 'id' => 'ProductoForm')) !!} -->
    {!! Form::open( array( 'id' => 'NotaCForm') ) !!}
    <div class="row">
      <div class="col-sm-12">
        <h3 class="tittle-custom"> Creación de Nota de Credito por Descuento </h3>
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
   </div>


   <hr>
   <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <table id="example" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th>Galones</th>
              <th>Producto</th>
              <th>Subtotal</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($records as $record)
            <tr>
             <td> {{ $record->cantidad }}</td>
             <td> {{App\combustible::find($record->combustible_id)->combustible}} </td>
             <td> Q.{{{number_format((float) $record->subtotal, 2) }}}</td>


           </tr>
           @endforeach
         </tbody>
       </table>
     </div>
   </div>             
   <div class="row">

     <div class="col-lg-6 text-right">
     <h4>   Total de Nota de Crédito: </h4>
     </div>
     <div class="col-lg-6 text-center" style="margin-top: 10px">

       {!! Form::number( "total" , $total , ['class' => 'form-control' , 'disabled', 'placeholder' => '0.00', "id" => "dinero_descuento" ]) !!}
     </div>
   </div>
 </div>
</br>

<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">

<input type="hidden" name="cliente_id" id="cliente_id" value="{{ $cliente->id }}">


<input type="hidden" name="selected" id="selected" value="{{ $valores }}">


<div class="text-right m-t-15">
  <a class='btn btn-primary form-gradient-color form-button' href="{{ url('/nota_credito') }}">Regresar</a>

  {!! Form::input('button', 'button', 'Crear', ['class' => 'btn btn-danger form-gradient-color form-button', 'id'=>'CreateNota']) !!}
</div>
<br>

</br>
{!! Form::close() !!}
</div>
</div>



@endsection
@section('scripts')
{!! HTML::script('/sfi/js/notac/crearRefacturacion.js') !!}
@endsection
