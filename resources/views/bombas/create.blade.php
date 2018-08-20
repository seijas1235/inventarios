@extends('layouts.app')
@section('content')
<div id="content">
	<div class="container-custom">
		<!-- {!! Form::open(array('class' => 'form', 'id' => 'ProductoForm')) !!} -->
		{!! Form::open( array( 'id' => 'BombaForm') ) !!}
		<div class="row">
			<div class="col-sm-12">
				<h3 class="tittle-custom"> Creación de Bombas </h3>
				<line>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-5">
					{!! Form::label("bomba","Bomba:") !!}
					{!! Form::text( "bomba" , null , ['class' => 'form-control' , 'placeholder' => 'Bomba' ]) !!}
				</div>
				<!-- <div class="col-sm-6">
					{!! Form::label("combustible_id","Combustible:") !!}
					<select class="selectpicker" id='combustible_id' name="combustible_id" value="" data-live-search="true" data-live-search-placeholder="Busqueda" title="Seleccione">
						@foreach ($combustibles as $combustible)
						<option value="{{$combustible->id}}">{{$combustible->combustible}}</option>
						@endforeach
					</select>
				</div> -->
			</div>
			<br>
			<div class="text-right m-t-15">
				<a class='btn btn-primary form-gradient-color form-button' href="{{ url('/bombas') }}">Regresar</a>

				{!! Form::input('submit', 'submit', 'Guardar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonBomba']) !!}
			</div>
			<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
		</br>
		{!! Form::close() !!}
	</div>
</div>
@endsection
@section('scripts')
{!! HTML::script('/../../sfi/sfi/js/bombas/create.js') !!}
@endsection