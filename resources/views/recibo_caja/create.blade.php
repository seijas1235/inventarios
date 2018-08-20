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

		<h3 class="text-center"> Seleccione uno o más vales:
		</h3>
		<table id="example" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap" cellspacing="0" width="100%">
		</table>
		 <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">

		<div class="text-right">
		<div id="siguientePaso" class="btn btn-primary">
		Siguiente Paso
		</div>

	</div>
</div>

@endsection
@section('scripts')
{!! HTML::script('/../../sfi/sfi/js/recibo_caja/create.js') !!}
@endsection