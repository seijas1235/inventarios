@extends('layouts.app')
@section('content')
<div id="content">
    <div class="container-custom">

    {!! Form::model($medida, ['method' => 'PATCH', 'action' => ['MedidasTanquesController@update', $medida->id], 'id' => 'MedidasUpdateForm']) !!}
        <div class="row">
            <div class="col-sm-12">
                <h3 class="tittle-custom"> Edición de Registro de Medidas de Tanque  </h3>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-4">
                {!! Form::label("fecha_medida","Fecha Medida:") !!}
                {!! Form::text( "fecha_medida" , null , ['class' => 'form-control' , 'placeholder' => 'Fecha Medida' ]) !!}
            </div>
            <div class="col-sm-4">
            </div>
            <div class="col-sm-4">
                {!! Form::label("empleado_idl","Medido por:") !!}
                <select class="selectpicker" id='empleado_id' name="empleado_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
                    @foreach ($empleados as $emps)
                    @if ( $emps->id == $medida->empleado_id)
                    <option value="{{$emps->id}}" selected>{{$emps->emp_nombres}} {{$emps->emp_apellidos}}</option>
                    @else
                    <option value="{{$emps->id}}">{{$emps->emp_nombres}} {{$emps->emp_apellidos}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-4">
                {!! Form::label("med_regla_superl","Medida Regla Super:") !!}
                {!! Form::text( "med_regla_super" , null , ['class' => 'form-control' , 'placeholder' => 'Medida Regla Super' ]) !!}
            </div>
            <div class="col-sm-4">
                {!! Form::label("med_regla_regularl","Medida Regla Regular:") !!}
                {!! Form::text( "med_regla_regular" , null , ['class' => 'form-control' , 'placeholder' => 'Medida Regla Regular' ]) !!}
            </div>
            <div class="col-sm-4">
                {!! Form::label("med_regla_diesell","Medida Regla Diesel:") !!}
                {!! Form::text( "med_regla_diesel" , null , ['class' => 'form-control' , 'placeholder' => 'Medida Regla Diesel' ]) !!}
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-4">
                {!! Form::label("med_tabla_superl","Medida Tabla Super:") !!}
                {!! Form::text( "med_tabla_super" , null , ['class' => 'form-control' , 'placeholder' => 'Medida Tabla Super' ]) !!}
            </div>
            <div class="col-sm-4">
                {!! Form::label("med_tabla_regularl","Medida Tabla Regular:") !!}
                {!! Form::text( "med_tabla_regular" , null , ['class' => 'form-control' , 'placeholder' => 'Medida Tabla Regular' ]) !!}
            </div>
            <div class="col-sm-4">
                {!! Form::label("med_tabla_diesell","Medida Tabla Diesel:") !!}
                {!! Form::text( "med_tabla_diesel" , null , ['class' => 'form-control' , 'placeholder' => 'Medida Tabla Diesel' ]) !!}
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-12">
                {!! Form::label("observacionesl","Observaciones:") !!}
                {!! Form::text( "observaciones" , null , ['class' => 'form-control' , 'placeholder' => 'Observaciones' ]) !!}
            </div>
        </div>
        <br>
        <div class="text-right m-t-15">
            <a class='btn btn-primary form-gradient-color form-button' href="{{ url('/medidas') }}">Regresar</a>
            
            {!! Form::input('submit', 'submit', 'Editar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonUpdateMedidas']) !!}
        </div>
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
    </br>
    {!! Form::close() !!}
</div>
</div>

@endsection
@section('scripts')
{!! HTML::script('/../../sfi_tecu/sfi/js/medidas/edit.js') !!}
@endsection