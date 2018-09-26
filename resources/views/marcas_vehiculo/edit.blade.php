@extends('layouts.app')
@section('content')
<div id="content">
    <div class="container-custom">

        {!! Form::model($marca_vehiculo, ['method' => 'PATCH', 'action' => ['MarcasVehiculoController@update', $marca_vehiculo->id], 'id' => 'Marca_VehiculoUpdateForm']) !!}

        <div class="row">
            <div class="col-sm-12">
                <h3 class="tittle-custom"> Edición de Marca </h3>
            </div>
        </div>
        <br>
        <div class="row">
                <div class="col-sm-4">
                    {!! Form::label("nombre","Marca:") !!}
                    {!! Form::text( "nombre" , null , ['class' => 'form-control' , 'placeholder' => 'Marca de Vehiculo' ]) !!}
                </div>
        <br>
        <div class="text-right m-t-15">
            <a class='btn btn-primary form-gradient-color form-button' href="{{ url('/marcas_vehiculo') }}">Regresar</a>
            {!! Form::input('submit', 'submit', 'Editar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonUpdateMarca_Vehiculo']) !!}
        </div>
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
    </br>
    {!! Form::close() !!}
</div>
</div>

@endsection
@section('scripts')
{!! HTML::script('/js/marcas_vehiculo/edit.js') !!}
@endsection