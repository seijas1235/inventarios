@extends('layouts.app')
@section('content')
<div id="content">
    <div class="container-custom">

        {!! Form::model($cupon, ['method' => 'PATCH', 'action' => ['CuponesController@update', $cupon->id], 'id' => 'CuponesUpdateForm']) !!}

        <div class="row">
            <div class="col-sm-12">
            <h3 class="tittle-custom"> Edición de Cupones de Combustible PUMA  </h3>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-4">
                {!! Form::label("fecha_corte","Fecha Corte:") !!}
                {!! Form::text( "fecha_corte" , null , ['class' => 'form-control' , 'placeholder' => 'Fecha Corte' ]) !!}
            </div>
            <div class="col-sm-4">
                {!! Form::label("codigo_corte","Codigo Corte:") !!}
                {!! Form::text( "codigo_corte" , null , ['class' => 'form-control' , 'placeholder' => 'Codigo Corte' ]) !!}
            </div>
            <div class="col-sm-4">
                {!! Form::label("no_cupon","No Cupón:") !!}
                {!! Form::text( "no_cupon" , null , ['class' => 'form-control' , 'placeholder' => 'No de Cupón' ]) !!}
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-3">
                {!! Form::label("codigo_cliente","Codigo de Cliente:") !!}
                {!! Form::text( "codigo_cliente" , null , ['class' => 'form-control' , 'placeholder' => 'Código de Cliente' ]) !!}
            </div>
            <div class="col-sm-9">
                {!! Form::label("nombre_cliente","Nombre del Cliente:") !!}
                {!! Form::text( "nombre_cliente" , null , ['class' => 'form-control' , 'placeholder' => 'Nombre del Cliente' ]) !!}
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-3">
                {!! Form::label("monto","Total Cupón:") !!}
                {!! Form::text( "monto" , null , ['class' => 'form-control' , 'placeholder' => 'Total del Cupón' ]) !!}
            </div>
            <div class="col-sm-9">
                {!! Form::label("observaciones","Observaciones:") !!}
                {!! Form::text( "observaciones" , null , ['class' => 'form-control' , 'placeholder' => 'Observaciones' ]) !!}
            </div>
        </div>
        <br>
        <div class="text-right m-t-15">
            <a class='btn btn-primary form-gradient-color form-button' href="{{ url('/cupones') }}">Regresar</a>
            
            {!! Form::input('submit', 'submit', 'Editar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonUpdateCupones']) !!}
        </div>
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
    </br>
    {!! Form::close() !!}
</div>
</div>

@endsection
@section('scripts')
{!! HTML::script('/../../sfi_tecu/sfi/js/cupones/edit.js') !!}
@endsection