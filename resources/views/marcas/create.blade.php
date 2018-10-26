@extends('layouts.app')
@section('content')
<div id="content">
	<div class="container-custom">
		{!! Form::open( array( 'id' => 'MarcaForm') ) !!}
		<div class="row">
			<div class="col-sm-12">
				<h3 class="tittle-custom"> Creación de Marcas</h3>
				<line>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-4">
					{!! Form::label("nombre","Marca:") !!}
					{!! Form::text( "nombre" , null , ['class' => 'form-control' , 'placeholder' => 'Nombre marca' ]) !!}
				</div>
				<div class="col-sm-4">
					{!! Form::label("tipo_marca_id","Tipo de Marca:") !!}
					<select class="selectpicker" id='tipo_marca_id' name="tipo_marca_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
						@foreach ($tipos_marcas as $tipo_marca)
						<option value="{{$tipo_marca->id}}">{{$tipo_marca->nombre}}</option>
						@endforeach
					</select>
				</div>
			</div>
			<br>
			<div class="text-right m-t-15">
				<a class='btn btn-primary form-gradient-color form-button' href="{{ url('/marcas') }}">Regresar</a>
				{!! Form::input('submit', 'submit', 'Guardar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonMarca']) !!}
			</div>
			<input type="hidden" name="_tokenMarca" id="tokenMarca" value="{{ csrf_token() }}">
		<br>
		{!! Form::close() !!}
	</div>
</div>
@endsection

@section('scripts')
{!! HTML::script('/js/marcas/create.js') !!}
@endsection