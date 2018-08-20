@extends('layouts.app')
@section('content')
<div id="content">
  <div class="container-custom">
    <!-- {!! Form::open(array('class' => 'form', 'id' => 'ProductoForm')) !!} -->
    {!! Form::open( array( 'id' => 'NotaCForm') ) !!}
    <div class="row">
      <div class="col-sm-12">
        <h3 class="tittle-custom"> Creación de Nota de Credito por Pronto Pago </h3>
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
      <div class="col-lg-12">
       <div class="col-lg-6">
         <h3> Sumatoria de Vales Vencidos:   Q.{{{number_format((float) $sum_vv, 2) }}} </h3>
       </div>
       <div class="col-lg-6">
         <h3> Sumatoria de Vales Activos:  Q.{{{number_format((float) $sum_va, 2) }}}  </h3>
       </div>
       <div class="col-lg-6">
         <h3> Galones de Vales Vencidos:   {{$suma_gav}} </h3>
       </div>
       <div class="col-lg-6">
         <h3> Galones de Vales Activos:  {{ $suma_gaa}}  </h3>
       </div>
     </div>
   </div>
 </br>
 <hr>
 <div class="row">
  <div class="col-lg-12">
    <strong>
      <div class="col-lg-3">
        Tipo de Gasolina
      </div>
      <div class="col-lg-3">
        Precio
      </div>
      <div class="col-lg-3">
        Cantidad de Galones
      </div>
      <div class="col-lg-3">
        Total
      </div>
    </strong>
    <div class="col-lg-3">
      Galones de Gasolina Super
    </div>
    <div class="col-lg-3">
      {!! Form::number( "super" , $precio_super , ['class' => 'form-control' , 'placeholder' => '0.00' ]) !!}
    </div>
    <div class="col-lg-3">    
    {!! Form::number( "galones_super" , null , ['class' => 'form-control' , 'placeholder' => '0.00' ]) !!} 
    </div>
    <div class="col-lg-3">
      {!! Form::number( "total_super" , null , ['class' => 'form-control' , 'placeholder' => '0.00', 'disabled' => true ]) !!}
    </div>
    <div class="col-lg-3">
      Galones de Gasolina Diesel
    </div>
    <div class="col-lg-3">
      {!! Form::number( "disel" , $precio_disel , ['class' => 'form-control' , 'placeholder' => '0.00' ]) !!}
    </div>
    <div class="col-lg-3">

      {!! Form::number( "galones_disel" , null , ['class' => 'form-control' , 'placeholder' => '0.00' ]) !!}
    </div>
    <div class="col-lg-3">
      {!! Form::number( "total_disel" , null , ['class' => 'form-control' , 'placeholder' => '0.00', 'disabled' => true ]) !!}
    </div>
    <div class="col-lg-3">
      Galones de Gasolina Regular
    </div>
    <div class="col-lg-3">
      {!! Form::number( "regular" , $precio_regular, ['class' => 'form-control' , 'placeholder' => '0.00' ]) !!}</div>
      <div class="col-lg-3">

        {!! Form::number( "galones_regular" , null , ['class' => 'form-control' , 'placeholder' => '0.00' ]) !!}

      </div>
      <div class="col-lg-3">
        {!! Form::number( "total_regular" , null , ['class' => 'form-control' , 'placeholder' => '0.00', 'disabled' => true ]) !!}
      </div>
      <br>
      <br>
      <br>
      <div class="col-lg-6 text-right" style="margin-top: 20px;">
        <span>Total:</span>
      </div>
      <div class="col-lg-6 text-right" style="margin-top: 15px;">
        {!! Form::number( "total" , 0 , ['class' => 'form-control' , 'placeholder' => '0.00', 'disabled' => true ]) !!}
      </div>
    </div>

  </div>
  <br>
  <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">

  <input type="hidden" name="cliente_id" id="cliente_id" value="{{ $cliente->id }}">

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
{!! HTML::script('/sfi/js/notac/crearDescuento2.js') !!}
@endsection
