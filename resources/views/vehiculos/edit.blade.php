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
                {!! Form::label("marca_id","Marca de Vehiculo:") !!}
                <select class="selectpicker" id='marca_id' name="marca_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
                    @foreach ($marcas as $marca)
                    @if ( $marca->id == $vehiculo->marca_id)
                    <option value="{{$marca->id}}" selected>{{ $marca->nombre}}</option>
                    @else
                    <option value="{{$marca->id}}">{{ $marca->nombre}}</option>
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
                {!! Form::number( "kilometraje" , null , ['class' => 'form-control' , 'placeholder' => 'Kilometraje' ]) !!}
            </div>
            <div class="col-sm-3">
                {!! Form::label("linea","Linea:") !!}
                {!! Form::text( "linea" , null , ['class' => 'form-control' , 'placeholder' => 'Linea' ]) !!}
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-3">
                {!! Form::label("tipo_transmision_id","Tipo de Transmision:") !!}
                <select class="selectpicker" id='tipo_transmision_id' name="tipo_transmision_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
                    @foreach ($tipos_transmision as $tipo_transmision)
                    @if ( $tipo_transmision->id == $vehiculo->tipo_transmision_id)
                    <option value="{{$tipo_transmision->id}}" selected>{{ $tipo_transmision->nombre}}</option>
                    @else
                    <option value="{{$tipo_transmision->id}}">{{ $tipo_transmision->nombre}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="col-sm-3">
                {!! Form::label("cliente_id","Dueño:") !!}
                <select class="selectpicker" id='cliente_id' name="cliente_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
                    @foreach ($clientes as $cliente)
                    @if ( $cliente->id == $vehiculo->cliente_id)
                    <option value="{{$cliente->id}}" selected>{{ $cliente->nombres.' '.$cliente->apellidos}}</option>
                    @else
                    <option value="{{$cliente->id}}">{{ $cliente->nombres.' '.$cliente->apellidos}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="col-sm-3">
                {!! Form::label("chasis","Chasis:") !!}
                {!! Form::text( "chasis" , null , ['class' => 'form-control' , 'placeholder' => 'Chasis' ]) !!}
            </div>
            <div class="col-sm-3">
                {!! Form::label("vin","VIN:") !!}
                {!! Form::text( "vin" , null , ['class' => 'form-control' , 'placeholder' => 'VIN' ]) !!}
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-12">
                {!! Form::label("observaciones","Observacciones de inspeccion:") !!}
                {!! Form::textarea( "observaciones" , null , ['class' => 'form-control' , 'placeholder' => 'Observaciones de inspeccion', 'rows'=> '5' ]) !!}
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