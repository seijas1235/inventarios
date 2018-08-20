@extends('layouts.app')
@section('content')
<div id="content">
    <div class="container-custom">
        {!! Form::model($empleado, ['method' => 'PATCH', 'action' => ['EmpleadosController@update', $empleado->id], 'id' => 'EmpleadoUpdateForm']) !!}
        <div class="row">
            <div class="col-sm-12">
                <h3 class="tittle-custom"> Edición de Empleados </h3>
                <div id="empleado-id-val" style="display: none">{{$empleado->id}}</div>

            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-3">
                {!! Form::label("emp_cui","CUI-DPI:") !!}
                {!! Form::number( "emp_cui" , null , ['class' => 'form-control' , 'placeholder' => 'CUI-DPI' ]) !!}
            </div>
            <div class="col-sm-3">
                {!! Form::label("cargo_empleado_id","Cargo:") !!}
                <select class="selectpicker" id='cargo_empleado_id' name="cargo_empleado_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
                    @foreach ($cargo_empleado as $cargos_empleado)
                    @if ( $cargos_empleado->id == $empleado->cargo_empleado_id)
                    <option value="{{$cargos_empleado->id}}" selected>{{ $cargos_empleado->cargo_empleado}}</option>
                    @else
                    <option value="{{$cargos_empleado->id}}">{{ $cargos_empleado->cargo_empleado}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="col-sm-3">
            </div>
            <div class="col-sm-3">
                
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-6">
                {!! Form::label("emp_nombres","Nombres:") !!}
                {!! Form::text( "emp_nombres" , null , ['class' => 'form-control' , 'placeholder' => 'Nombres' ]) !!}
            </div>
            <div class="col-sm-6">
                {!! Form::label("emp_apellidos","Apellidos:") !!}
                {!! Form::text( "emp_apellidos" , null , ['class' => 'form-control' , 'placeholder' => 'Apellidos' ]) !!}
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-3">
                {!! Form::label("emp_telefonos","Teléfonos:") !!}
                {!! Form::number( "emp_telefonos" , null , ['class' => 'form-control' , 'placeholder' => 'Telefonos' ]) !!}
            </div>
            <div class="col-sm-9">
                {!! Form::label("emp_direccion","Dirección:") !!}
                {!! Form::text( "emp_direccion" , null , ['class' => 'form-control' , 'placeholder' => 'Dirección' ]) !!}
            </div>
        </div>
        <br>
        <div class="text-right m-t-15">
            <a class='btn btn-primary form-gradient-color form-button' href="{{ url('/empleados') }}">Regresar</a>
            
            {!! Form::input('submit', 'submit', 'Editar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonUpdateEmpleado']) !!}
        </div>
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
    </br>
    {!! Form::close() !!}
</div>
</div>
@endsection
@section('scripts')
{!! HTML::script('/../../sfi/sfi/js/empleados/edit.js') !!}
@endsection