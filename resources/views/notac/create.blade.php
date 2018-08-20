@extends('layouts.app')
@section('content')
<div id="content">
	<div class="container-custom">
		<!-- {!! Form::open(array('class' => 'form', 'id' => 'ProductoForm')) !!} -->
		{!! Form::open( array( 'id' => 'NotaCForm') ) !!}
		<div class="row">
			<div class="col-sm-12">
				<h3 class="tittle-custom"> Creación de Nota de Credito </h3>
				<line>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-6">
					{!! Form::label("cliente_id","Cliente:") !!}
					<select class="selectpicker" id='cliente_id' name="cliente_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
						@foreach ($clientes as $cliente)
						<option value="{{$cliente->id}}">{{ $cliente->cl_nombres}} {{ $cliente->cl_apellidos}}</option>
						@endforeach
					</select>
				</div>
				<div class="col-sm-6">
					{!! Form::label("tipo_id","Tipo de Nota:") !!}
					<select class="selectpicker" id='tipo_id' name="tipo_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
						<option value="1"> Nota de Crédito por Descuento </option>
						<option value="3"> Nota de Crédito por Pronto Pago </option>
						<option value="4"> Nota de Crédito por Refacturación </option>

					</select>
				</div>
			</div>
			</br>
			<div class="text-right m-t-15">
				<a class='btn btn-primary form-gradient-color form-button' href="{{ url('/nota_credito') }}">Regresar</a>

				{!! Form::input('button', 'button', 'Guardar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonTipoNota']) !!}
			</div>
			<br>

			<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
		</br>
		{!! Form::close() !!}
	</div>
</div>

@endsection
@section('scripts')
{!! HTML::script('/sfi/js/notac/tipo.js') !!}
@endsection
