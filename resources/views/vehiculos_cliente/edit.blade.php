@extends('layouts.app')
@section('content')
<div id="content">
    <div class="container-custom">

        {!! Form::model($vehiculo_cliente, ['method' => 'PATCH', 'action' => ['VehiculosClienteController@update', $vehiculo_cliente->id], 'id' => 'VehiculoClienteUpdateForm']) !!}

        <div class="row">
            <div class="col-sm-12">
                <h3 class="tittle-custom"> Edición de Asignacion </h3>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-4">
                {!! Form::label("cliente_id","Cliente:") !!}
                <select class="selectpicker" id='cliente_id' name="cliente_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
                    @foreach ($clientes as $cliente)
                    @if($cliente->id == $vehiculo_cliente->cliente_id)
                    <option value="{{$cliente->id}}" selected>{{$cliente->nombres}}</option>
                    @else
                    <option value="{{$cliente->id}}">{{$cliente->nombres}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="col-sm-4">
                {!! Form::label("vehiculo_id","Vehiculo:") !!}
                <select class="selectpicker" id='vehiculo_id' name="vehiculo_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
                    @foreach ($vehiculos as $vehiculo)
                    @if ( $vehiculo->id == $vehiculo_cliente->vehiculo_id)
                    <option value="{{$vehiculo->id}}" selected>{{ $vehiculo->placa}}</option>
                    @else
                    <option value="{{$vehiculo->id}}">{{ $vehiculo->placa}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
        </div>
        <br>
        <div class="text-right m-t-15">
            <a class='btn btn-primary form-gradient-color form-button' href="{{ url('/vehiculos_cliente') }}">Regresar</a>
            {!! Form::input('submit', 'submit', 'Editar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonUpdateVehiculoCliente']) !!}
        </div>
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
    <br>
    {!! Form::close() !!}
</div>
</div>

@endsection
@section('scripts')
{!! HTML::script('/js/vehiculos_cliente/edit.js') !!}
@endsection