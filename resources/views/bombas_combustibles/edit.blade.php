@extends('layouts.app')
@section('content')
<div id="content">
    <div class="container-custom">

        {!! Form::model($bomba_combustible, ['method' => 'PATCH', 'action' => ['Bomba_CombustibleController@update', $bomba_combustible->id], 'id' => 'BombaCombustibleUpdateForm']) !!}

        <div class="row">
            <div class="col-sm-12">
                <h3 class="tittle-custom"> Edición de Combustible y Bomba  </h3>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-6">
                {!! Form::label("bomba_id","Bomba:") !!}
                <select class="selectpicker" id='bomba_id' name="bomba_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
                    @foreach ($bombas as $bomba)
                    @if ( $bomba->id == $bomba_combustible->bomba_id)
                    <option value="{{$bomba->id}}" selected>{{$bomba->bomba}}</option>
                    @else
                    <option value="{{$bomba->id}}">{{$bomba->bomba}}</option>
                    @endif
                    @endforeach
                </select>
            </div>

            <div class="col-sm-6">
                {!! Form::label("combustible_id","Combustible:") !!}
                <select class="selectpicker" id='combustible_id' name="combustible_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
                    @foreach ($combustibles as $combustible)
                    @if ( $combustible->id == $bomba_combustible->combustible_id)
                    <option value="{{$combustible->id}}" selected>{{$combustible->combustible}}</option>
                    @else
                    <option value="{{$combustible->id}}">{{$combustible->combustible}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            <br>
        </div>
        
        <br>
        <div class="text-right m-t-15">
            <a class='btn btn-primary form-gradient-color form-button' href="{{ url('/bombas_combustibles') }}">Regresar</a>
            
            {!! Form::input('submit', 'submit', 'Editar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonUpdateBombaCombustible']) !!}
        </div>
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
    </br>
    {!! Form::close() !!}
</div>
</div>

@endsection
@section('scripts')
{!! HTML::script('/../../sfi/sfi/js/bombas_combustibles/edit.js') !!}
@endsection