@extends('layouts.app')
@section('content')
<div id="content">
    <div class="container-custom">

        {!! Form::model($bomba, ['method' => 'PATCH', 'action' => ['BombaController@update', $bomba->id], 'id' => 'BombaUpdateForm']) !!}

        <div class="row">
            <div class="col-sm-12">
                <h3 class="tittle-custom"> Edicion de Bomba  </h3>
            </div>
        </div>
        <br>
        <div class="row">

            <div class="col-sm-5">
                    {!! Form::label("bomba","Bomba:") !!}
                    {!! Form::text( "bomba" , null , ['class' => 'form-control' , 'placeholder' => 'Bomba' ]) !!}
                </div>
        </div>
        <br>
        
        <br>
        <div class="text-right m-t-15">
            <a class='btn btn-primary form-gradient-color form-button' href="{{ url('/bombas') }}">Regresar</a>
            
            {!! Form::input('submit', 'submit', 'Editar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonUpdateBomba']) !!}
        </div>
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
    </br>
    {!! Form::close() !!}
</div>
</div>

@endsection
@section('scripts')
{!! HTML::script('/../../sfi/sfi/js/bombas/edit.js') !!}
@endsection