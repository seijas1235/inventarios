@extends('layouts.app')
@section('content')
<div id="content">
    <div class="container-custom">
        {!! Form::model($marca, ['method' => 'PATCH', 'action' => ['MarcasController@update', $marca->id], 'id' => 'MarcaUpdateForm']) !!}

        <div class="row">
            <div class="col-sm-12">
                <h3 class="tittle-custom">Edición de Marcas </h3>
            </div>
        </div>
        <br>

        <div class="row">
            <div class="col-sm-6">
                {!! Form::label("marca","Marca:") !!}
                {!! Form::text( "marca" , null , ['class' => 'form-control' , 'placeholder' => 'Marca' ]) !!}
            </div>
            <div class="col-sm-6">
            </div>
        </div>

        <br>
        <div class="text-right m-t-15">
            <a class='btn btn-primary form-gradient-color form-button' href="{{ url('/marcas') }}">Regresar</a>
            
            {!! Form::input('submit', 'submit', 'Editar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonUpdateMarca']) !!}
        </div>
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
    </br>
    {!! Form::close() !!}
</div>
</div>

@endsection
@section('scripts')
{!! HTML::script('/../../sfi_tecu/sfi/js/marcas/edit.js') !!}
@endsection