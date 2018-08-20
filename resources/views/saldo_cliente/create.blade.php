@extends('layouts.app')
@section('content')
<div id="page-wrapper">
	<div id="page-inner">
		{!! Form::open( array( 'id' => 'SaldosClientesForm') ) !!}
		<div class="row">
			<div class="col-sm-12">
				<h3 class="tittle-custom"> Registro de Saldos para Clientes </h3>
				<line>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-4">
					{!! Form::label("mes_id","Mes:") !!}
					<select class="selectpicker" id='mes_id' name="mes_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
						@foreach ($meses as $mes)
						<option value="{{$mes->id}}">{{$mes->mes}}</option>
						@endforeach
					</select>
				</div>
				<div class="col-sm-4">
					{!! Form::label("cliente_id","Cliente:") !!}
					<select class="selectpicker" id='cliente_id' name="cliente_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
						@foreach ($clientes as $cls)
						<option value="{{$cls->id}}">{{$cls->cl_nombres}} {{$cls->cl_apellidos}}</option>
						@endforeach
					</select>
				</div>
				<div class="col-sm-4">
					{!! Form::label("saldo","Saldo:") !!}
					{!! Form::number( "saldo" , null , ['class' => 'form-control' , 'placeholder' => 'Saldo' ]) !!}
				</div>
			</div>
		</br>
		<div class="text-right m-t-15">
			<a class='btn btn-primary form-gradient-color form-button' href="{{ url('/saldos_clientes') }}">Regresar</a>

			{!! Form::input('submit', 'submit', 'Guardar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonSaldosClientes']) !!}
		</div>
		<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
	</br>
	{!! Form::close() !!}
</div>
</div>
@endsection
@section('scripts')
{!! HTML::script('/../../sfi/sfi/js/saldo_cliente/create.js') !!}
@endsection