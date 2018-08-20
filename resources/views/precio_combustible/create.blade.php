@extends('layouts.app')
@section('content')
<div id="content">
	<div class="container-custom">
		<!-- {!! Form::open(array('class' => 'form', 'id' => 'ProductoForm')) !!} -->
		{!! Form::open( array( 'id' => 'PrecioCombustibleForm') ) !!}
		<div class="row">
			<div class="col-sm-12">
				<h3 class="tittle-custom"> Creaci¨®n de Precio Combustible </h3>
				<line>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-3">
					{!! Form::label("precio_compra","Precio de compra:") !!}
					{!! Form::number( "precio_compra" , null , ['class' => 'form-control' , 'placeholder' => 'Precio de Venta' ]) !!}
				</div>
				<div class="col-sm-3">
					{!! Form::label("precio_venta","Precio de venta:") !!}
					{!! Form::number( "precio_venta" , null , ['class' => 'form-control' , 'placeholder' => 'Precio de Venta' ]) !!}
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-6">
					{!! Form::label("combustible","Combustible:") !!}
					<select class="selectpicker" id='combustible_id' name="combustible_id" value="" data-live-search="true" data-live-search-placeholder="BÃºsqueda" title="Seleccione">
						@foreach ($combustibles as $combustible)
						<option value="{{$combustible->id}}">{{ $combustible->combustible}}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="text-right m-t-15">
				<a class='btn btn-primary form-gradient-color form-button' href="{{ url('/productos') }}">Regresar</a>

				{!! Form::input('submit', 'submit', 'Guardar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonPrecioCombustible']) !!}
			</div>
			<br>

			<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
		</br>
		{!! Form::close() !!}
	</div>
</div>

@endsection
@section('scripts')
{!! HTML::script('/../../sfi/sfi/js/precio_combustible/create.js') !!}
@endsection