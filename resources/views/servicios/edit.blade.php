@extends('layouts.app')
@section('content')
<div id="content">
    <div class="container-custom">

        {!! Form::model($servicio, ['method' => 'PATCH', 'action' => ['ServiciosController@update', $servicio->id], 'id' => 'ServicioUpdateForm']) !!}

        <div class="row">
            <div class="col-sm-12">
                <h3 class="tittle-custom"> Edición de servicio </h3>
            </div>
        </div>
        <br>
        <div class="row">
                <div class="col-sm-4">
                    {!! Form::label("nombre","Nombre servicio") !!}
                    {!! Form::text( "nombre" , null , ['class' => 'form-control' , 'placeholder' => 'servicio' ]) !!}
                </div>

                <div class="col-sm-4">
                        {!! Form::label("precio","Precio:") !!}
                        {!! Form::text( "precio" , null , ['class' => 'form-control' , 'placeholder' => 'precio' ]) !!}
                </div>
                <div class="col-sm-4">
                    {!! Form::label("maquinaria_equipo_id","Maquinaria utilizada:") !!}
                    <select class="form-control select2" multiple="multiple" 
                            data-placeholder="Seleccione una o mas maquinarias"
                            style="width: 100%;" name="maquinarias[]">
                            @foreach($maquinarias as $maquinaria)
                            <option {{collect(old('maquinarias', $servicio->maquinarias->pluck('id') ))->contains($maquinaria->id)? 'selected' : '' }} value="{{$maquinaria->id}}">{{$maquinaria->nombre}}</option>
                          @endforeach  
                    </select>
                </div>
            </div>
        <br>
        <div class="text-right m-t-15">
            <a class='btn btn-primary form-gradient-color form-button' href="{{ url('/servicios') }}">Regresar</a>
            {!! Form::input('submit', 'submit', 'Editar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonUpdateServicio']) !!}
        </div>
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
    </br>
    {!! Form::close() !!}
</div>
</div>

@endsection
@section('scripts')
{!! HTML::script('/js/servicios/edit.js') !!}
@endsection