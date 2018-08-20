@extends('layouts.app')
@section('content')
<div id="content">
    <div class="container-custom">

        {!! Form::model($banco, ['method' => 'PATCH', 'action' => ['BancosController@update', $banco->id], 'id' => 'BancoUpdateForm']) !!}

        <div class="row">
            <div class="col-sm-12">
                <h3 class="tittle-custom"> Edici¨®n de Bancos  </h3>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-3">
                {!! Form::label("nombre","Banco:") !!}
                {!! Form::text( "nombre" , null , ['class' => 'form-control' , 'placeholder' => 'Banco' ]) !!}
            </div>
        </div>
        <br>
        
        <div class="text-right m-t-15">
            <a class='btn btn-primary form-gradient-color form-button' href="{{ url('/bancos') }}">Regresar</a>
            
            {!! Form::input('submit', 'submit', 'Editar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonUpdateBanco']) !!}
        </div>
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
    </br>
    {!! Form::close() !!}
</div>
</div>

@endsection
@section('scripts')
{!! HTML::script('/../../sfi/sfi/js/bancos/edit.js') !!}
@endsection