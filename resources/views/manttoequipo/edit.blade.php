@extends('layouts.app')
@section('content')
<div id="content">
    <div class="container-custom">

        {!! Form::model($manttoequipo, ['method' => 'PATCH', 'action' => ['ManteminientoEquiposController@update', $manttoequipo->id], 'id' => 'ManttoEquipoUpdateForm']) !!}

        <div class="row">
            <div class="col-sm-12">
                <h3 class="tittle-custom"> Modificacion de Mantenimientos Realizados </h3>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-4"></div>               
            <div class="col-sm-4">
                {!! Form::label("maquinaria_id","Maquinaria :") !!}
                <select class="selectpicker" id='maquinaria_id' name="maquinaria_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
                    @foreach ($maquinarias as $maquinaria)
                    @if ( $maquinaria->id == $manttoequipo->maquinaria_id)
                    <option value="{{$maquinaria->id}}" selected>{{ $maquinaria->nombre}}</option>
                    @else
                    <option value="{{$maquinaria->id}}">{{ $maquinaria->nombre}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="col-sm-4"></div>
            <div class="col-sm-4">
                {!! Form::label("fecha_servicio","Fecha Servicio:") !!}
                {!! Form::text( "fecha_servicio" , null , ['class' => 'form-control' , 'placeholder' => 'Fecha Servicio:' ]) !!}
            </div>
        </div>
        <br>
 
        <br>

        <div class="row">
            <div class="col-sm-4">
                {!! Form::label("labadas_servicio","Cantidad de labadas Realizadas:") !!}
                {!! Form::number( "labadas_servicio" , null , ['class' => 'form-control' , 'placeholder' => 'Cantidad de Labadas Realizadas' ]) !!}
            </div>
            <div class="col-sm-4 ">
                {!! Form::label("labadas_proximo_servicio","Cantidad de labadas Para Proximo Servicio:") !!}
                {!! Form::text( "labadas_proximo_servicio" , null , ['class' => 'form-control' , 'placeholder' => 'Cantidad de labadas Para Proximo Servicio' ]) !!}
            </div>
                 
            <div class="col-sm-4">
                {!! Form::label("fecha_proximo_servicio","Fecha Proximo Servicio:") !!}
                {!! Form::text( "fecha_proximo_servicio" , null , ['class' => 'form-control' , 'placeholder' => 'Fecha Proximo Servicio' ]) !!}
            </div>
        
        </div>
        <br>
        <div class="row">
            <div class="col-sm-12">
                {!! Form::label("descripcion","Descripcion:") !!}
                {!! Form::text( "descripcion" , null , ['class' => 'form-control' , 'placeholder' => 'Descripcion' ]) !!}
            </div>    
        </div>  
        <br>
        <div class="text-right m-t-15">
            <a class='btn btn-primary form-gradient-color form-button' href="{{ url('/mantto_equipos') }}">Regresar</a>
            {!! Form::input('submit', 'submit', 'Editar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonUpdateManttoEquipo']) !!}
        </div>
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
    </br>
    {!! Form::close() !!}
</div>
</div>

@endsection
@section('scripts')
{!! HTML::script('/js/manttoequipo/edit.js') !!}
@endsection