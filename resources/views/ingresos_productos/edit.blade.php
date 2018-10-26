@extends('layouts.app')
@section('content')
<div id="content">
    <div class="container-custom">

        {!! Form::model($compra, ['method' => 'PATCH', 'action' => ['ComprasController@update', $compra->id], 'id' => 'CompraUpdateForm']) !!}

        <div class="row">
            <div class="col-sm-12">
                <h3 class="tittle-custom"> Edición de Compra </h3>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-3">
                {!! Form::label("serie_factura","Serie:") !!}
                {!! Form::text( "serie_factura" , null , ['class' => 'form-control' , 'placeholder' => 'Serie' ]) !!}
            </div>
            <div class="col-sm-3">
                {!! Form::label("num_factura","No.Factura:") !!}
                {!! Form::text( "num_factura" , null , ['class' => 'form-control' , 'placeholder' => 'numero factura' ]) !!}
            </div>
            <div class="col-sm-3">
                {!! Form::label("proveedor_id","Tipo de Cliente:") !!}
                <select class="selectpicker" id='proveedor_id' name="proveedor_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
                    @foreach ($proveedores as $proveedor)
                    @if ( $proveedor->id == $compra->proveedor_id)
                    <option value="{{$proveedor->id}}" selected>{{ $proveedor->nombre}}</option>
                    @else
                    <option value="{{$proveedor->id}}">{{ $proveedor->nombre}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="col-sm-3">
                {!! Form::label("fecha_factura","Fecha factura:") !!}
                {!! Form::date( "fecha_factura" , null , ['class' => 'form-control' , 'id'=>'fecha_factura' ]) !!}
            </div>
        </div>
        <br>
        <br>
        <div class="text-right m-t-15">
            <a class='btn btn-primary form-gradient-color form-button' href="{{ url('/compras') }}">Regresar</a>
            {!! Form::input('submit', 'submit', 'Editar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonUpdateCompra']) !!}
        </div>
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
    </br>
    {!! Form::close() !!}
</div>
</div>
@endsection

@section('scripts')
{!! HTML::script('/js/compras/edit.js') !!}
@endsection
