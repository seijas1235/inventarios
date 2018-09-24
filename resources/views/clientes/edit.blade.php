@extends('layouts.app')
@section('content')
<div id="content">
    <div class="container-custom">

        {!! Form::model($cliente, ['method' => 'PATCH', 'action' => ['ClientesController@update', $cliente->id], 'id' => 'ClienteUpdateForm']) !!}

        <div class="row">
            <div class="col-sm-12">
                <h3 class="tittle-custom"> Edición de Clientes </h3>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-4">
                {!! Form::label("nit","NIT:") !!}
                {!! Form::text( "nit" , null , ['class' => 'form-control' , 'placeholder' => 'NIT' ]) !!}
            </div>
            <div class="col-sm-4">
            </div>
            <div class="col-sm-4">
                {!! Form::label("tipo_cliente_id","Tipo de Cliente:") !!}
                <select class="selectpicker" id='tipo_cliente_id' name="tipo_cliente_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
                    @foreach ($tipos_clientes as $tipo_cliente)
                    @if ( $tipo_cliente->id == $cliente->tipo_cliente_id)
                    <option value="{{$tipo_cliente->id}}" selected>{{ $tipo_cliente->nombre}}</option>
                    @else
                    <option value="{{$tipo_cliente->id}}">{{ $tipo_cliente->nombre}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-6">
                {!! Form::label("nombre","Nombres:") !!}
                {!! Form::text( "nombre" , null , ['class' => 'form-control' , 'placeholder' => 'Nombre' ]) !!}
            </div>
            <div class="col-sm-6">
                {!! Form::label("record_compra","Record de compras:") !!}
                {!! Form::text( "record_compra" , null , ['class' => 'form-control' , 'placeholder' => 'Record de compra' ]) !!}
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-4">
                {!! Form::label("telefono","Teléfono:") !!}
                {!! Form::number( "telefono" , null , ['class' => 'form-control' , 'placeholder' => 'Telefono' ]) !!}
            </div>
            <div class="col-sm-8">
                {!! Form::label("descuento","% Descuento:") !!}
                {!! Form::text( "descuento" , null , ['class' => 'form-control' , 'placeholder' => 'Porcentaje de Descuento' ]) !!}
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-12">
                {!! Form::label("direccion","Dirección:") !!}
                {!! Form::text( "direccion" , null , ['class' => 'form-control' , 'placeholder' => 'Dirección' ]) !!}
            </div>
        </div>
        <br>
        <div class="text-right m-t-15">
            <a class='btn btn-primary form-gradient-color form-button' href="{{ url('/clientes') }}">Regresar</a>
            {!! Form::input('submit', 'submit', 'Editar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonUpdateCliente']) !!}
        </div>
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
    </br>
    {!! Form::close() !!}
</div>
</div>

@endsection
@section('scripts')
{!! HTML::script('/js/clientes/edit.js') !!}
@endsection