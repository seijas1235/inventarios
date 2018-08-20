@extends('layouts.app')
@section('content')
<div id="content">
	<div class="container-custom">
		<!-- {!! Form::open(array('class' => 'form', 'id' => 'ProductoForm')) !!} -->
		{!! Form::open( array( 'id' => 'BombaCombustibleForm') ) !!}
		<div class="row">
			<div class="col-sm-12">
				<h3 class="tittle-custom"> Asignación de Combustible a Bombas </h3>
				<line>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-6">
					{!! Form::label("bomba_id","Bomba:") !!}
					<select class="selectpicker" id='bomba_id' name="bomba_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
						@foreach ($bombas as $bomba)
						<option value="{{$bomba->id}}">{{$bomba->bomba}}</option>
						@endforeach
					</select>
				</div>
				<div class="col-sm-6">
					{!! Form::label("combustible_id","Combustible:") !!}
					<select class="selectpicker" id='combustible_id' name="combustible_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
						@foreach ($combustibles as $combustible)
						<option value="{{$combustible->id}}">{{$combustible->combustible}}</option>
						@endforeach
					</select>
				</div>
			</div>
			<br>
			<div class="text-right m-t-15">
				<a class='btn btn-primary form-gradient-color form-button' href="{{ url('/bombas_combustibles') }}">Regresar</a>

				{!! Form::input('submit', 'submit', 'Guardar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonBombaCombustible']) !!}
			</div>
			<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
		</br>
		{!! Form::close() !!}
	</div>
</div>
@endsection
@section('scripts')
{!! HTML::script('/../../sfi/sfi/js/bombas_combustibles/create.js') !!}
@endsection