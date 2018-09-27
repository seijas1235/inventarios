@extends('layouts.app')
@section('content')
<div id="content">
    <div class="container-custom">

        {!! Form::model($vehiculo, ['method' => 'PATCH', 'action' => ['VehiculosController@update', $vehiculo->id], 'id' => 'VehiculoUpdateForm']) !!}

        <div class="row">
            <div class="col-sm-12">
                <h3 class="tittle-custom"> Edición de Vehiculos </h3>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-4">
                {!! Form::label("placa","No Placa:") !!}
                {!! Form::text( "placa" , null , ['class' => 'form-control' , 'placeholder' => 'No Placa' ]) !!}
            </div>
            <div class="col-sm-4">
                {!! Form::label("aceite_caja","Aceite Caja:") !!}
                {!! Form::text( "aceite_caja" , null , ['class' => 'form-control' , 'placeholder' => 'Aceite Recomendado' ]) !!}
                
            </div>
            <div class="col-sm-4">
                {!! Form::label("aceite_motor","Aceite Motor:") !!}
                {!! Form::text( "aceite_motor" , null , ['class' => 'form-control' , 'placeholder' => 'Aceite Recomendado' ]) !!}
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-4">
                {!! Form::label("tipo_vehiculo_id","Tipo de Vehiculo:") !!}
                <select class="selectpicker" id='tipo_vehiculo_id' name="tipo_vehiculo_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
                    @foreach ($tipos_vehiculos as $tipo_vehiculo)
                    @if ( $tipo_vehiculo->id == $vehiculo->tipo_vehiculo_id)
                    <option value="{{$tipo_vehiculo->id}}" selected>{{ $tipo_vehiculo->nombre}}</option>
                    @else
                    <option value="{{$tipo_vehiculo->id}}">{{ $tipo_vehiculo->nombre}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="col-sm-4">
                {!! Form::label("marca_vehiculo_id","Marca de Vehiculo:") !!}
                <select class="selectpicker" id='marca_vehiculo_id' name="marca_vehiculo_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
                    @foreach ($marcas_vehiculos as $marca_vehiculo)
                    @if ( $marca_vehiculo->id == $vehiculo->marca_vehiculo_id)
                    <option value="{{$marca_vehiculo->id}}" selected>{{ $marca_vehiculo->nombre}}</option>
                    @else
                    <option value="{{$marca_vehiculo->id}}">{{ $marca_vehiculo->nombre}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="col-sm-4">
                {!! Form::label("fecha_ultimo_servicio","Fecha Ultimo Servicio:") !!}
                {!! Form::text( "fecha_ultimo_servicio" , null , ['class' => 'form-control' , 'placeholder' => 'Fecha Ultimo Servicio' ]) !!}
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-3">
                {!! Form::label("año","Año:") !!}
                {!! Form::text( "año" , null , ['class' => 'form-control' , 'placeholder' => 'Año' ]) !!}
            </div>
            <div class="col-sm-3">
                {!! Form::label("color","Color:") !!}
                {!! Form::text( "color" , null , ['class' => 'form-control' , 'placeholder' => 'Color' ]) !!}
            </div>
            <div class="col-sm-3">
                {!! Form::label("kilometraje","Kilometraje:") !!}
                {!! Form::text( "kilometraje" , null , ['class' => 'form-control' , 'placeholder' => 'Kilometraje' ]) !!}
            </div>
        </div>
    <br>
    <div class="text-right m-t-15">
        <a class='btn btn-primary form-gradient-color form-button' href="{{ url('/vehiculos') }}">Regresar</a>
        {!! Form::input('submit', 'submit', 'Editar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonUpdateVehiculo']) !!}
    </div>
    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
</br>
{!! Form::close() !!}
</div>
</div>
@endsection

@section('scripts')
{!! HTML::script('/js/vehiculos/edit.js') !!}
@endsection