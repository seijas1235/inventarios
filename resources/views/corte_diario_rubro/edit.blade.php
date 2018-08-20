@extends('layouts.app')
@section('content')
<div id="content">
    <div class="container-custom">

    {!! Form::model($rubro, ['method' => 'PATCH', 'action' => ['CorteDiarioRubroController@update', $rubro->id], 'id' => 'CDRubroUpdateForm']) !!}

        <div class="row">
            <div class="col-sm-12">
                <h3 class="tittle-custom"> Edición de Rubros para Cortes Diarios </h3>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-5">
                {!! Form::label("rubro","Rubro:") !!}
                {!! Form::text( "rubro" , null , ['class' => 'form-control' , 'placeholder' => 'Rubro' ]) !!}
            </div>
        </div>
        <br>
        
        <div class="text-right m-t-15">
            <a class='btn btn-primary form-gradient-color form-button' href="{{ url('/cdrubros') }}">Regresar</a>
            
            {!! Form::input('submit', 'submit', 'Editar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonUpdateCDRubro']) !!}
        </div>
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
    </br>
    {!! Form::close() !!}
</div>
</div>

@endsection
@section('scripts')
{!! HTML::script('/sfi/js/corte_diario_rubro/edit.js') !!}
@endsection