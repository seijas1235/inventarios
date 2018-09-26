@extends('layouts.app')
@section('content')
<div id="content">
	<div class="container-custom">
		<!-- {!! Form::open(array('class' => 'form', 'id' => 'ProductoForm')) !!} -->
		{!! Form::open( array( 'id' => 'ProductoForm') ) !!}
		<div class="row">
			<div class="col-sm-12">
				<h3 class="tittle-custom"> Creación de Productos </h3>
				<line>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-4">
					{!! Form::label("codigo_barra","Codigo de barra:") !!}
					{!! Form::text( "codigo_barra" , null , ['class' => 'form-control' , 'placeholder' => 'Codigo de barra']) !!}
				</div>
				<div class="col-sm-4">
					{!! Form::label("nombre","Nombre:") !!}
					{!! Form::text( "nombre" , null , ['class' => 'form-control' , 'placeholder' => 'Nombre']) !!}
				</div>
				<div class="col-sm-4">
					{!! Form::label("minimo","Stock Minimo:") !!}
					{!! Form::number( "minimo" , null , ['class' => 'form-control' , 'placeholder' => 'Stock minimo']) !!}
				</div>
			</div>
			<br>
			<div class="text-right m-t-15">
				<a class='btn btn-primary form-gradient-color form-button' href="{{ url('/productos') }}">Regresar</a>
				{!! Form::input('submit', 'submit', 'Guardar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonProducto']) !!}
			</div>
			<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
		<br>
		{!! Form::close() !!}
	</div>
</div>
@endsection

@section('scripts')
{!! HTML::script('/js/productos/create.js') !!}
@endsection