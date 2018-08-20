@extends('layouts.app')
@section('content')
<div id="content">
    <div class="container-custom">

        {!! Form::model($precio_combustible, ['method' => 'PATCH', 'action' => ['PrecioCombustibleController@update', $precio_combustible->id], 'id' => 'PrecioCombustibleUpdateForm']) !!}

        <div class="row">
            <div class="col-sm-12">
                <h3 class="tittle-custom"> Edici¨®n de Precio de Combustible </h3>
            </div>
        </div>
        <br>
        <div class="row">
                <div class="col-sm-3">
                    {!! Form::label("precio_compra","Precio de compra:") !!}
                    {!! Form::number( "precio_compra" , null , ['class' => 'form-control' , 'placeholder' => 'Precio de Venta' ]) !!}
                </div>
                <div class="col-sm-3">
                    {!! Form::label("precio_venta","Precio de venta:") !!}
                    {!! Form::number( "precio_venta" , null , ['class' => 'form-control' , 'placeholder' => 'Precio de Venta' ]) !!}
                </div>
            </div>

        <div class="row">
            <div class="col-sm-9">
                    {!! Form::label("combustible","Combustible:") !!}
            <select class="selectpicker" id='combustible_id' name="combustible_id" value="" data-live-search="true" data-live-search-placeholder="BÃºsqueda" title="Seleccione">
                    @foreach ($combustibles as $combustible)
                    @if ( $combustible->id == $precio_combustible->combustible_id)
                    <option value="{{$combustible->id}}" selected>{{ $combustible->combustible}}</option>
                    @else
                    <option value="{{$combustible->id}}">{{ $combustible->combustible}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
        </div>
        <br>
        <div class="text-right m-t-15">
            <a class='btn btn-primary form-gradient-color form-button' href="{{ url('/precio_combustible') }}">Regresar</a>
            
            {!! Form::input('submit', 'submit', 'Editar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonUpdatePrecioCombustible']) !!}
        </div>
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
    </br>
    {!! Form::close() !!}
</div>
</div>

@endsection
@section('scripts')
{!! HTML::script('/../../sfi/sfi/js/precio_combustible/edit.js') !!}
@endsection