@extends('layouts.app')
@section('content')
<div id="content">
    <div class="container-custom">
        {!! Form::model($idp, ['method' => 'PATCH', 'action' => ['IdpController@update', $idp->id], 'id' => 'IDPUpdateForm']) !!}

        <div class="row">
            <div class="col-sm-12">
                <h3 class="tittle-custom">Edici®Æn de IDPs </h3>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-6">
                {!! Form::label("combustible_id","Combustible:") !!}
                <select class="selectpicker" id='combustible_id' name="combustible_id" value="" data-live-search="true" data-live-search-placeholder="B√∫squeda" title="Seleccione">
                    @foreach ($combustibles as $combustible)
                    @if ( $combustible->id == $idp->combustible_id)
                    <option value="{{$combustible->id}}" selected>{{ $combustible->combustible}}</option>
                    @else
                    <option value="{{$combustible->id}}">{{ $combustible->combustible}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="col-sm-6">
                {!! Form::label("costo_idp","Costo IDP por Gal®Æn:") !!}
                {!! Form::text( "costo_idp" , null , ['class' => 'form-control' , 'placeholder' => 'Costo de IDP por Gal√≥n' ]) !!}
            </div>
        </div>
        <br>
        <div class="text-right m-t-15">
            <a class='btn btn-primary form-gradient-color form-button' href="{{ url('/idp') }}">Regresar</a>
            
            {!! Form::input('submit', 'submit', 'Editar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonUpdateIDP']) !!}
        </div>
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
    </br>
    {!! Form::close() !!}
</div>
</div>

@endsection
@section('scripts')
{!! HTML::script('/../../sfi/sfi/js/idp/edit.js') !!}
@endsection