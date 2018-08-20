@extends('layouts.app')
@section('content')
<div id="content">
    <div class="container-custom">

        {!! Form::model($producto, ['method' => 'PATCH', 'action' => ['ProductosController@update', $producto->id], 'id' => 'ProductoUpdateForm']) !!}
        <div id="producto-id-val" style="display: none">{{$producto->id}}</div>
        <div class="row">
            <div class="col-sm-12">
                <h3 class="tittle-custom">Edición de Productos </h3>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-6">
                {!! Form::label("codigobarra","Código de Barra:") !!}
                {!! Form::text( "codigobarra" , null , ['class' => 'form-control', 'placeholder' => 'Código de Barra' ]) !!}
            </div>

            <div class="col-sm-6">
                {!! Form::label("nombre","Producto:") !!}
                {!! Form::text( "nombre" , null , ['class' => 'form-control' , 'placeholder' => 'Nombre de Producto' ]) !!}
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-12">
                {!! Form::label("aplicacion","Aplicación:") !!}
                {!! Form::text( "aplicacion" , null , ['class' => 'form-control' , 'placeholder' => 'Marcas y Modelos de Aplicación' ]) !!}
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-3">
                {!! Form::label("marca","Marca:") !!}
                <select class="selectpicker" id='marca_id' name="marca_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
                    @foreach ($marca as $marcas)
                    @if ( $marcas->id == $producto->marca_id)
                    <option value="{{$marcas->id}}" selected>{{ $marcas->marca}}</option>
                    @else
                    <option value="{{$marcas->id}}">{{ $marcas->marca}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="col-sm-9">
                {!! Form::label("descripcion","Descripción:") !!}
                {!! Form::text( "descripcion" , null , ['class' => 'form-control' , 'placeholder' => 'Descripcion' ]) !!}
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-3">
                {!! Form::label("no_serie","No de Serie:") !!}
                {!! Form::text( "no_serie" , null , ['class' => 'form-control' , 'placeholder' => 'No de Serie' ]) !!}
            </div>
            <div class="col-sm-3">
                {!! Form::label("tipo_producto","Tipo Producto:") !!}
                <select class="selectpicker" id='tipo_producto_id' name="tipo_producto_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
                    @foreach ($tipo_producto as $tipos_productos)
                    @if ( $tipos_productos->id == $producto->tipo_producto_id)
                    <option value="{{$tipos_productos->id}}" selected>{{ $tipos_productos->tipo_producto}}</option>
                    @else
                    <option value="{{$tipos_productos->id}}">{{ $tipos_productos->tipo_producto}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="col-sm-2">
                {!! Form::label("precio_venta","Precio de venta:") !!}
                {!! Form::number( "precio_venta" , null , ['class' => 'form-control' , 'placeholder' => 'Precio de Venta' ]) !!}
            </div>
            <div class="col-sm-2">
                {!! Form::label("precio_compra","Precio de compra:") !!}
                {!! Form::number( "precio_compra" , null , ['class' => 'form-control' , 'placeholder' => 'Precio de Compra' ]) !!}
            </div>
            <div class="col-sm-2">
                {!! Form::label("estado_producto","Estado Producto:") !!}
                <select class="selectpicker" id='estado_producto_id' name="estado_producto_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
                    @foreach ($estado_producto as $estados_productos)
                    @if ( $estados_productos->id == $producto->estado_producto_id)
                    <option value="{{$estados_productos->id}}" selected>{{ $estados_productos->estado_producto}}</option>
                    @else
                    <option value="{{$estados_productos->id}}">{{ $estados_productos->estado_producto}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
        </div>
        <br>
        <div class="text-right m-t-15">
            <a class='btn btn-primary form-gradient-color form-button' href="{{ url('/productos') }}">Regresar</a>
            
            {!! Form::input('submit', 'submit', 'Editar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonUpdateProducto']) !!}
        </div>
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
    </br>
    {!! Form::close() !!}
</div>
</div>

@endsection
@section('scripts')
{!! HTML::script('/../../sfi_tecu/sfi/js/productos/edit.js') !!}
@endsection