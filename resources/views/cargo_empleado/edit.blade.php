@extends('layouts.app')
@section('content')
<div id="content">
    <div class="container-custom">
        {!! Form::model($cargo, ['method' => 'PATCH', 'action' => ['CargoEmpleadoController@update', $cargo->id], 'id' => 'CEUpdateForm']) !!}

        <div class="row">
            <div class="col-sm-12">
            <h3 class="tittle-custom">Edici¨®n de Cargos de Empleado </h3>
            </div>
        </div>
        <br>

        <div class="row">
         <div class="col-sm-6">
            {!! Form::label("cargo_empleado","Cargo Empleado:") !!}
            {!! Form::text( "cargo_empleado" , null , ['class' => 'form-control' , 'placeholder' => 'Cargo Empleado' ]) !!}
        </div>
        <div class="col-sm-6">
        </div>
    </div>

    <br>
    <div class="text-right m-t-15">
        <a class='btn btn-primary form-gradient-color form-button' href="{{ url('/cargos') }}">Regresar</a>

        {!! Form::input('submit', 'submit', 'Editar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonUpdateCE']) !!}
    </div>
    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
</br>
{!! Form::close() !!}
</div>
</div>

@endsection
@section('scripts')
{!! HTML::script('/../../sfi/sfi/js/cargo_empleado/edit.js') !!}
@endsection