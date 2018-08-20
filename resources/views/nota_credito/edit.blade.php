@extends('layouts.app')
@section('content')
<div id="content">
    <div class="container-custom">

        {!! Form::model($nota_credito, ['method' => 'PATCH', 'action' => ['NotasCreditosController@update', $nota_credito->id], 'id' => 'NotasCreditosUpdateForm']) !!}

        <div class="row">
            <div class="col-sm-12">
                <h3 class="tittle-custom"> Edición de Nota de Crédito  </h3>
            </div>
        </div>
        <br>
        <div class="row">
                <div class="col-sm-4">
                    {!! Form::label("fecha","Fecha Nota Crédito:") !!}
                    {!! Form::text( "fecha" , null , ['class' => 'form-control' , 'placeholder' => 'Fecha Nota Crédito' ]) !!}
                </div>
                <div class="col-sm-4">
                    {!! Form::label("cliente_id","Cliente:") !!}
                    <select class="selectpicker" id='cliente_id' name="cliente_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
                    @foreach ($clientes as $cls)
                    @if ( $cls->id == $nota_credito->cliente_id)
                    <option value="{{$cls->id}}" selected>{{$cls->cl_nombres}} {{$cls->cl_apellidos}}</option>
                    @else
                    <option value="{{$cls->id}}">{{$cls->cl_nombres}} {{$cls->cl_apellidos}}</option>
                    @endif
                    @endforeach
                </select>
                </div>
                <div class="col-sm-4">
                    {!! Form::label("total","Total:") !!}
                    {!! Form::number( "total" , null , ['class' => 'form-control' , 'placeholder' => 'Total' ]) !!}
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-12">
                    {!! Form::label("descripcion","Observaciones:") !!}
                    {!! Form::text( "descripcion" , null , ['class' => 'form-control' , 'placeholder' => 'Observaciones' ]) !!}
                </div>
            </div>
        <br>
        <div class="text-right m-t-15">
            <a class='btn btn-primary form-gradient-color form-button' href="{{ url('/nota_credito2') }}">Regresar</a>
            
            {!! Form::input('submit', 'submit', 'Editar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonUpdateNotasCreditos']) !!}
        </div>
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
    </br>
    {!! Form::close() !!}
</div>
</div>

@endsection
@section('scripts')
{!! HTML::script('/../../sfi_tecu/sfi/js/nota_credito/edit.js') !!}
@endsection