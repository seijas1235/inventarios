@extends('layouts.app')
@section('content')
<div id="content">
	<div class="container-custom">

	{!! Form::model($saldo_cliente, ['method' => 'PATCH', 'action' => ['SaldosClientesController@update', $saldo_cliente->id], 'id' => 'SaldosClientesUpdateForm']) !!}
		<div id="requisicion-id-val" style="display: none">{{$saldo_cliente->id}}</div>
		<div class="row">
			<div class="col-sm-12">
				<h3 class="tittle-custom">Edición de Registros de Saldo de Clientes </h3>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-sm-4">
				 {!! Form::label("mes_id","Mes:") !!}
                <select class="selectpicker" id='mes_id' name="mes_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
                    @foreach ($meses as $mes)
                    @if ( $mes->id == $saldo_cliente->mes_id)
                    <option value="{{$mes->id}}" selected>{{ $mes->mes}}</option>
                    @else
                    <option value="{{$mes->id}}">{{ $mes->mes}}</option>
                    @endif
                    @endforeach
                </select>
			</div>
			<div class="col-sm-4">
				 {!! Form::label("cliente","Cliente:") !!}
                <select class="selectpicker" id='cliente_id' name="cliente_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
                    @foreach ($clientes as $cls)
                    @if ( $cls->id == $saldo_cliente->cliente_id)
                    <option value="{{$cls->id}}" selected>{{ $cls->cl_nombres}} {{ $cls->cl_apellidos}}</option>
                    @else
                    <option value="{{$cls->id}}">{{ $cls->cl_nombres}} {{ $cls->cl_apellidos}}</option>
                    @endif
                    @endforeach
                </select>
			</div>
			<div class="col-sm-4">
				{!! Form::label("saldo","Saldo:") !!}
				{!! Form::number( "saldo" , null , ['class' => 'form-control' , 'placeholder' => 'Saldo' ]) !!}
			</div>
		</div>
		<br>
		<div class="text-right m-t-15">
			<a class='btn btn-primary form-gradient-color form-button' href="{{ url('/saldos_clientes') }}">Regresar</a>

			{!! Form::input('submit', 'submit', 'Editar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonUpdateSaldosClientes']) !!}
		</div>
		<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
	</br>
	{!! Form::close() !!}
</div>
</div>

@endsection
@section('scripts')
{!! HTML::script('/../../sfi/sfi/js/saldo_cliente/edit.js') !!}
@endsection