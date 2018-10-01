@extends('layouts.app')
@section('content')
<div id="content">
    <div class="container-custom">

        {!! Form::model($serie, ['method' => 'PATCH', 'action' => ['SeriesController@update', $serie->id], 'id' => 'SerieUpdateForm']) !!}

        <div class="row">
            <div class="col-sm-12">
                <h3 class="tittle-custom"> Edición de Series de Documentos </h3>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-4 form-group ">
                {!! Form::label("resolucion","Resolucion:") !!}
                {!! Form::text( "resolucion" , null , ['class' => 'form-control' , 'placeholder' => 'Resolucion:' ]) !!}
                
            </div>
            <div class="col-sm-4"></div>
            <div class="col-sm-4">
                {!! Form::label("serie","Serie:") !!}
                {!! Form::text( "serie" , null , ['class' => 'form-control' , 'placeholder' => 'Serie:' ]) !!}
            </div>
           
            </div>
            <br>
            <div class="row">
                <div class="col-sm-4">
                    {!! Form::label("fecha_resolucion","Fecha Resolucion:") !!}
                    {!! Form::text( "fecha_resolucion" , null , ['class' => 'form-control' , 'placeholder' => 'Fecha Resolucion' ]) !!}
                </div>
                
                <div class="col-sm-4">
                    {!! Form::label("fecha_vencimiento","Fecha de Vencimiento:") !!}
                    {!! Form::text( "fecha_vencimiento" , null , ['class' => 'form-control' , 'placeholder' => 'Fecha de Vencimiento' ]) !!}
                </div>
                <div class="col-sm-4">
                    {!! Form::label("estado_id","Estado:") !!}
                    <select class="selectpicker" id='estado_id' name="estado_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
                        @foreach ($estados as $estado)
                        @if ( $estado->id == $serie->estado_id)
                        <option value="{{$estado->id}}" selected>{{ $estado->estado}}</option>
                        @else
                        <option value="{{$estado->id}}">{{ $estado->estado}}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <br>
        <div class="row">
            <div class="col-sm-4">
                {!! Form::label("documento_id","Documento:") !!}
                <select class="selectpicker" id='documento_id' name="documento_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
                    @foreach ($documentos as $documento)
                    @if ( $documento->id == $serie->documento_id)
                    <option value="{{$documento->id}}" selected>{{ $documento->descripcion}}</option>
                    @else
                    <option value="{{$documento->id}}">{{ $documento->descripcion}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
                    
            <div class="col-sm-4">
                {!! Form::label("inicio","Numero Inicio:") !!}
                {!! Form::text( "inicio" , null , ['class' => 'form-control' , 'placeholder' => 'Numero Inicio' ]) !!}
            </div>
            <div class="col-sm-4">
                {!! Form::label("fin","Numero Fin:") !!}
                {!! Form::text( "fin" , null , ['class' => 'form-control' , 'placeholder' => 'Numero Fin' ]) !!}
            </div>
        </div>
        <br>
        <div class="text-right m-t-15">
            <a class='btn btn-primary form-gradient-color form-button' href="{{ url('/series') }}">Regresar</a>
            {!! Form::input('submit', 'submit', 'Editar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonUpdateSerie']) !!}
        </div>
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
    </br>
    {!! Form::close() !!}
</div>
</div>

@endsection
@section('scripts')
{!! HTML::script('/js/series/edit.js') !!}
@endsection