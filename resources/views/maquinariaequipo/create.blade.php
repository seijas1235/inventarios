@extends('layouts.app')
@section('content')
<div id="content">
	<div class="container-custom">
		{!! Form::open( array( 'id' => 'MaquinariaEquipoForm') ) !!}
		<div class="row">
			<div class="col-sm-12">
				<h3 class="tittle-custom"> Creación de MAquinarias/Equipo </h3>
				<line>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-4">
					{!! Form::label("nombre","Nombre:") !!}
					{!! Form::text( "nombre" , null , ['class' => 'form-control' , 'placeholder' => 'Nombre del equipo' ]) !!}
				</div>
				<div class="col-sm-4"></div>
				<div class="col-sm-4">
					{!! Form::label("marca","Marca:") !!}
					{!! Form::text( "marca" , null , ['class' => 'form-control' , 'placeholder' => 'Marca del equipo' ]) !!}
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-4">
					{!! Form::label("labadas_limite","Labadas Limite:") !!}
					{!! Form::text( "labadas_limite" , null , ['class' => 'form-control' , 'placeholder' => 'Labadas Maximas a realizar' ]) !!}
				</div>
				<div class="col-sm-4">
					{!! Form::label("fecha_adquisicion","Fecha de Adquisicion:") !!}
					{!! Form::text( "fecha_adquisicion" , null , ['class' => 'form-control' , 'placeholder' => 'Fecha Adquisicion' ]) !!}
				</div>
				<div class="col-sm-4">
						{!! Form::label("precio_costo","Precio Costo:") !!}
						{!! Form::text( "precio_costo" , null , ['class' => 'form-control' , 'placeholder' => 'Precio Compra' ]) !!}
				</div>
			</div>
			<br>
			<div class="text-right m-t-15">
				<a class='btn btn-primary form-gradient-color form-button' href="{{ url('/maquinarias_equipo') }}">Regresar</a>
				{!! Form::input('submit', 'submit', 'Guardar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonMaquinariaEquipo']) !!}
			</div>
			<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
		</br>
		{!! Form::close() !!}
	</div>
</div>
@endsection

@section('scripts')
{!! HTML::script('/js/maquinariaequipo/create.js') !!}
@endsection