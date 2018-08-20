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
             <div class="col-lg-4">
                <div class="col-lg-12">
                    {!! Form::label("has_orden","Mantener Precio Calculado:") !!}
                </br>
                <input type="checkbox" checked data-toggle="toggle" data="mantener" id="mantener" data-on="Si" data-off="No">
            </div>
        </div>
    </div>


    <hr>

    <div class="row">
        <div class="col-lg-12">

            <h4> Selecciona los vales haciendo clic </h4>
            <table id="example" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Fecha</th>
                        <th>Total</th>
                        <th>Galones</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($vales_vencidos as $vale_vencido)
                    <tr name="{{$vale_vencido->suma_galones}}" id="{{$vale_vencido->total_vale}}">

                       <td> {{ $vale_vencido->id }}</td>
                       <td> {{ $vale_vencido->created_at }}</td>
                       <td> 
                           Q.{{{number_format((float) $vale_vencido->total_vale, 2) }}}
                       </td>
                       <td> {{ $vale_vencido->suma_galones}}</td>
                       <td> 
                           {{App\estado_vale::find($vale_vencido->estado_vale_id)->estado_vale}} </td>

                       </tr>
                       @endforeach

                       @foreach ($vales_activos as $vale_activo)
                       <tr name="{{$vale_activo->suma_galones}}" id="{{$vale_activo->total_vale}}">

                           <td> {{ $vale_activo->id }}</td>
                           <td> {{ $vale_activo->created_at }}</td>
                           <td> 
                               Q.{{{number_format((float) $vale_activo->total_vale, 2) }}}
                           </td>
                           <td> {{ $vale_activo->suma_galones }}</td>
                           <td> 
                               {{App\estado_vale::find($vale_activo->estado_vale_id)->estado_vale}} </td>

                           </tr>
                           @endforeach
                       </tbody>
                   </table>
               </div>
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
        <div class="col-lg-6">
           <h3> Descuento por Vales Vencidos: Q. {{$suma_gav * $tasa1}} </h3>
       </div>
       <div class="col-lg-6">
        <h3> Descuento por Vales Activos:  Q. {{ $suma_gaa * $tasa }}  </h3>

    </div>


    {!! Form::hidden( "tasa" , $tasa, ['class' => 'form-control' , 'disabled', 'id' => 'tasa' ]) !!}
    {!! Form::hidden( "tasa1" , $tasa1, ['class' => 'form-control' , 'disabled', 'id' => 'tasa1' ]) !!}
    <div class="row">
        <div class="col-lg-6 text-right">
         <h4>   Sumatoria de Galones por Vales Seleccionados: </h4>
     </div>
     <div class="col-lg-6 text-center" style="margin-top: 10px">
         {!! Form::number( "descuento_vales" , null , ['class' => 'form-control' , 'disabled', 'placeholder' => '0.00', "id" => "descuento_vales" ]) !!}
     </div>
 </div>
 <div class="row">

     <div class="col-lg-6 text-right">
         <h4>   Sumatoria de Descuento por Vales Seleccionados: </h4>
     </div>
     <div class="col-lg-6 text-center" style="margin-top: 10px">

         {!! Form::number( "dinero_descuento" , null , ['class' => 'form-control' , 'disabled', 'placeholder' => '0.00', "id" => "dinero_descuento" ]) !!}
     </div>
 </div>
</div>
</br>

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
{!! HTML::script('/sfi/js/notac/crearDescuento.js') !!}
@endsection
