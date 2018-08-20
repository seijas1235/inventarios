@extends('layouts.app')
@section('content')
<div id="content">
	<div class="container-custom">
		<!-- {!! Form::open(array('class' => 'form', 'id' => 'ProductoForm')) !!} -->
		{!! Form::open( array( 'id' => 'TVForm') ) !!}
		<div class="row">
			<div class="col-sm-12">
				<h3 class="tittle-custom">Creación de Tipos de Vehiculos </h3>
				<line>
				</div>
			</div>
			<br>

			<div class="row">
				<div class="col-sm-6">
					{!! Form::label("tipo_vehiculo","Tipo de Vehículo:") !!}
					{!! Form::text( "tipo_vehiculo" , null , ['class' => 'form-control' , 'placeholder' => 'Tipo de Vehículo' ]) !!}
				</div>
				<div class="col-sm-6">
				</div>
			</div>
			
			<br>
			<div class="text-right m-t-15">
				<a class='btn btn-primary form-gradient-color form-button' href="{{ url('/tipo_vehiculo') }}">Regresar</a>

				{!! Form::input('submit', 'submit', 'Guardar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonTV']) !!}
			</div>
			<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
		</br>
		{!! Form::close() !!}
	</div>
</div>

@endsection
@section('scripts')
{!! HTML::script('/../../sfi/sfi/js/tipo_vehiculo/create.js') !!}
@endsection