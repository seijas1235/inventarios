@extends('layouts.app')
@section('content')
<div id="content">
	<div class="container-custom">
		{!! Form::open( array( 'id' => 'LineaForm') ) !!}
		<div class="row">
			<div class="col-sm-12">
				<h3 class="tittle-custom"> Creación de Lineas de Vehiculo</h3>
				<line>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-4">
					{!! Form::label("linea","Linea:") !!}
					{!! Form::text( "linea" , null , ['class' => 'form-control' , 'placeholder' => 'Nombre Linea' ]) !!}
				</div>
				<div class="col-sm-4">
					{!! Form::label("marca_id","Marca:") !!}
					<select class="selectpicker" id='marca_id' name="marca_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
						@foreach ($marcas as $marca)
						@if($marca->tipo_marca_id== 1 or $marca->tipo_marca_id== 2 )
						<option value="{{$marca->id}}">{{$marca->nombre}}</option>
						@endif
						@endforeach
					</select>
				</div>
			</div>
			<br>
			<div class="text-right m-t-15">
				<a class='btn btn-primary form-gradient-color form-button' href="{{ url('/lineas') }}">Regresar</a>
				{!! Form::input('submit', 'submit', 'Guardar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonLinea']) !!}
			</div>
			<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
		<br>
		{!! Form::close() !!}
	</div>
</div>
@endsection

@section('scripts')
{!! HTML::script('/js/lineas/create.js') !!}
@endsection