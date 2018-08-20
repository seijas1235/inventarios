@extends('layouts.app')
@section('content')
<div id="content">
	<div class="container-custom">
		{!! Form::open( array( 'id' => 'VouchersForm') ) !!}
		<div class="row">
			<div class="col-sm-12">
				<h3 class="tittle-custom"> Registro de Vouchers de Tarjetas </h3>
				<line>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-4">
					{!! Form::label("fecha_corte","Fecha Corte:") !!}
					{!! Form::text( "fecha_corte" , null , ['class' => 'form-control' , 'placeholder' => 'Fecha Corte' ]) !!}
				</div>
				<div class="col-sm-4">
					{!! Form::label("codigo_corte","Codigo Corte:") !!}
					{!! Form::text( "codigo_corte" , null , ['class' => 'form-control' , 'placeholder' => 'Codigo Corte' ]) !!}
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-6">
					{!! Form::label("no_lote","No de Lote:") !!}
					{!! Form::text( "no_lote" , null , ['class' => 'form-control' , 'placeholder' => 'No de Lote' ]) !!}
				</div>
				<div class="col-sm-6">
					{!! Form::label("total","Total Voucher:") !!}
					{!! Form::text( "total" , null , ['class' => 'form-control' , 'placeholder' => 'Total Voucher' ]) !!}
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-12">
					{!! Form::label("observaciones","Observaciones:") !!}
					{!! Form::text( "observaciones" , null , ['class' => 'form-control' , 'placeholder' => 'Observaciones' ]) !!}
				</div>
			</div>
			<br>
			<div class="text-right m-t-15">
				<a class='btn btn-primary form-gradient-color form-button' href="{{ url('/vouchers') }}">Regresar</a>

				{!! Form::input('submit', 'submit', 'Guardar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonVouchers']) !!}
			</div>
			<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
		</br>
		{!! Form::close() !!}
	</div>
</div>
@endsection
@section('scripts')
{!! HTML::script('/../../sfi/sfi/js/vouchers/create.js') !!}
@endsection