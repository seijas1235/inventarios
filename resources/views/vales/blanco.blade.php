@extends('layouts.app')
@section('content')
<div id="content">
    <div class="container-custom">
        <!-- {!! Form::open(array('class' => 'form', 'id' => 'ProductoForm')) !!} -->
        {!! Form::open( array( 'id' => 'ValeForm') ) !!}
        <div class="row">
            <div class="col-sm-12">
                <h3 class="tittle-custom">Creacion de Vales </h3>
                <line>
                </div>
            </div>
            <br>

            <div class="row">
                <div class="col-sm-6">
                    {!! Form::label("cliente_id","Cliente:") !!}
                    <select class="selectpicker" id='cliente_id' name="cliente_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
                        @foreach ($clientes as $cliente)
                        <option value="{{$cliente->id}}">{{$cliente->cl_nombres}} {{$cliente->cl_apellidos}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-6">
                    {!! Form::label("cantidad","No. Vales:") !!}
                    {!! Form::number( "cantidad" , 0, ['class' => 'form-control' , 'placeholder' => 'Cantidad']) !!}
                </div>
            </div>
            </br>
            <div class="text-right m-t-15">
                <a class='btn btn-primary form-gradient-color form-button' href="{{ url('/vales') }}">Regresar</a>

                {!! Form::input('submit', 'submit', 'Guardar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonVale']) !!}
            </div>
            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
        </br>
        {!! Form::close() !!}
    </div>
</div>

@endsection
@section('scripts')
{!! HTML::script('/../../sfi_tecu/sfi/js/vales/blanco.js') !!}
@endsection