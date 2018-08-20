@extends('layouts.app')
@section('content')
<div id="content">
	<div class="container-custom">
		<!-- {!! Form::open(array('class' => 'form', 'id' => 'ProductoForm')) !!} -->
		{!! Form::open( array( 'id' => 'GastosForm') ) !!}
		<div class="row">
			<div class="col-sm-12">
				<h3 class="tittle-custom"> Registro de Gastos </h3>
				<line>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-3">
					{!! Form::label("fecha_corte","Fecha Corte:") !!}
					{!! Form::text( "fecha_corte" , null , ['class' => 'form-control' , 'placeholder' => 'Fecha Corte' ]) !!}
				</div>
				<div class="col-sm-3">
					{!! Form::label("codigo_corte","Codigo Corte:") !!}
					{!! Form::text( "codigo_corte" , null , ['class' => 'form-control' , 'placeholder' => 'Codigo Corte' ]) !!}
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-4">
					{!! Form::label("documento","Documento:") !!}
					{!! Form::text( "documento" , null , ['class' => 'form-control' , 'placeholder' => 'Documento' ]) !!}
				</div>
				<div class="col-sm-4">
					{!! Form::label("no_documento","No Documento:") !!}
					{!! Form::text( "no_documento" , null , ['class' => 'form-control' , 'placeholder' => 'No Documento' ]) !!}
				</div>
				<div class="col-sm-4">
					{!! Form::label("monto","Monto:") !!}
					{!! Form::text( "monto" , null , ['class' => 'form-control' , 'placeholder' => 'Monto' ]) !!}
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-12">
					{!! Form::label("descripcion","Descripcion:") !!}
					{!! Form::text( "descripcion" , null , ['class' => 'form-control' , 'placeholder' => 'Descripcion' ]) !!}
				</div>
			</div>
			<br>
			<div class="text-right m-t-15">
				<a class='btn btn-primary form-gradient-color form-button' href="{{ url('/gastos') }}">Regresar</a>

				{!! Form::input('submit', 'submit', 'Guardar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonGastos']) !!}
			</div>
			<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
		</br>
		{!! Form::close() !!}
	</div>
</div>
@endsection
@section('scripts')
{!! HTML::script('/../../sfi_tecu/sfi/js/gastos/create.js') !!}
@endsection