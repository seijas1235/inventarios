@extends('layouts.app')
@section('content')
<div id="page-wrapper">
    <div id="page-inner">

        {!! Form::model($proveedor, ['method' => 'PATCH', 'action' => ['ProveedoresController@update', $proveedor->id], 'id' => 'ProveedorUpdateForm']) !!}

        <div class="row">
            <div class="row">
                <div class="col-sm-12">
                <h3 class="tittle-custom"> Actualización de Proveedores </h3>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-3">
                    {!! Form::label("nit","NIT:") !!}
                    {!! Form::number( "nit" , null , ['class' => 'form-control' , 'placeholder' => 'NIT' ]) !!}
                </div>
                <div class="col-sm-9">
                    {!! Form::label("nombre","Nombre Comercial:") !!}
                    {!! Form::text( "nombre_comercial" , null , ['class' => 'form-control' , 'placeholder' => 'Nombre Comercial' ]) !!}
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-6">
                    {!! Form::label("representante","Representante:") !!}
                    {!! Form::text( "representante" , null , ['class' => 'form-control' , 'placeholder' => 'Representante' ]) !!}
                </div>
                <div class="col-sm-3">
                    {!! Form::label("telefonos","Teléfonos:") !!}
                    {!! Form::number( "telefonos" , null , ['class' => 'form-control' , 'placeholder' => 'Tel茅fonos' ]) !!}
                </div>
                <div class="col-sm-3">
                    {!! Form::label("cuentac","Nomenclatura Contable:") !!}
                    {!! Form::text( "cuentac" , null , ['class' => 'form-control' , 'placeholder' => 'Nomenclatura Contable' ]) !!}
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-12">
                    {!! Form::label("direccion","Dirección:") !!}
                    {!! Form::text( "direccion" , null , ['class' => 'form-control' , 'placeholder' => 'Direccion' ]) !!}
                </div>
            </div>
            
        </br>
        <div class="text-right m-t-15">
            <a class='btn btn-primary form-gradient-color form-button' href="{{ url('/proveedores') }}">Regresar</a>
            
            {!! Form::input('submit', 'submit', 'Editar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonUpdateProveedor']) !!}
        </div>
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
    </br>
    {!! Form::close() !!}
</div>
</div>

@endsection
@section('scripts')
{!! HTML::script('/../../sfi_tecu/sfi/js/proveedores/edit.js') !!}
@endsection