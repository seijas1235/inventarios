@extends('layouts.app')
@section('content')
<div id="content">
	<div class="container-custom">
		<br>
		<h3 class="text-center"> Seleccione un cliente: </h3>

		<div class="row">

			<div class="col-sm-12">
				{!! Form::label("cliente_id","Cliente:") !!}
				<select class="selectpicker" id='cliente_id' name="cliente_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
					@foreach ($clientes as $cliente)
					<option value="{{$cliente->id}}">{{$cliente->cl_nombres}} {{$cliente->cl_apellidos}}</option>
					@endforeach
				</select>
			</div>
		</div>
		 <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
		 </br>
		<div class="text-right">
		<div id="siguientePaso" class="btn btn-primary">
		Siguiente Paso
		</div>

	</div>


</div>

@endsection
@section('scripts')
{!! HTML::script('/sfi/js/factura_cambiaria/create2.js') !!}
@endsection