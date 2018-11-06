@extends('layouts.app')
@section('content')
<div id="content">
	<div class="container-custom">
		{!! Form::open( array( 'id' => 'CorteCajaForm') ) !!}
		<div class="row">
			<div class="col-sm-12">
				<h3 class="tittle-custom"> Corte de Caja </h3>
				<line>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-4">
					{!! Form::label("fecha","Fecha Corte:") !!}
					{!! Form::date( "fecha" , null , ['class' => 'form-control' ]) !!}
				</div>
				<div class="col-sm-4">
					{!! Form::label("factura_inicial","Factura Inicial:") !!}
					{!! Form::text( "factura_inicial" , null , ['class' => 'form-control' , 'placeholder' => 'Factura Inicial', 'disabled' ]) !!}				
				</div>
				<div class="col-sm-4">
					{!! Form::label("factura_final","Factura Final:") !!}
					{!! Form::text( "factura_final" , null , ['class' => 'form-control' , 'placeholder' => 'Factura Final', 'disabled' ]) !!}				
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-3">
					{!! Form::label("efectivo","Efectivo:") !!}
					{!! Form::number( "efectivo" , null , ['class' => 'form-control' , 'placeholder' => '0.00', 'disabled' => true ]) !!}				
				</div>
				<div class="col-sm-3">
					{!! Form::label("credito","Credito:") !!}
					{!! Form::number( "credito" , null , ['class' => 'form-control' , 'placeholder' => '0.00', 'disabled' => true ]) !!}				
				</div>
				<div class="col-sm-3">
					{!! Form::label("voucher","Tarjeta:") !!}
					{!! Form::number( "voucher" , null , ['class' => 'form-control' , 'placeholder' => '0.00', 'disabled' => true ]) !!}				
				</div>
				<div class="col-sm-3">
					{!! Form::label("total","Total:") !!}
					{!! Form::number( "total" , null , ['class' => 'form-control' , 'placeholder' => '0.00', 'disabled' => true ]) !!}				
				</div>
			</div>
			<br>
			<div class="row">
			<div class="col-sm-12">
					
			</div>
			</div>
			<br>
			<div class="text-right m-t-15">
				<a class='btn btn-primary form-gradient-color form-button' href="{{ url('/cortes_caja') }}">Regresar</a>
				{{--{!! Form::input('Calcular', ['class' => 'btn btn-success form-gradient-color form-button', 'id'=>'ButtonCalcular']) !!}--}}
				<input type="button" value="Calcular" class="btn btn-success" id="ButtonCalcular">
				{!! Form::input('submit', 'submit', 'Guardar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonCorte']) !!}
			</div>
			<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
		<br>
		{!! Form::close() !!}
	</div>
</div>
@endsection

@section('scripts')
{!! HTML::script('/js/cortes_caja/create.js') !!}
@endsection