@extends('layouts.app')
@section('content')
<div id="content">
	<div class="container-custom">
		{!! Form::open( array( 'id' => 'ServicioForm') ) !!}
		<div class="row">
			<div class="col-sm-12">
				<h3 class="tittle-custom"> Creación de Servicio </h3>
				<line>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-4">
					{!! Form::label("nombre","Nombre Servicio:") !!}
					{!! Form::text( "nombre" , null , ['class' => 'form-control' , 'placeholder' => 'Nombre servicio' ]) !!}
				</div>
				<div class="col-sm-4">
					{!! Form::label("precio","Precio:") !!}
					{!! Form::text( "precio" , null , ['class' => 'form-control' , 'placeholder' => 'Precio' ]) !!}
	
				</div>
				<div class="col-sm-4">
					<div class="form-group">
					{!! Form::label("maquinaria_equipo_id","Maquinaria utilizada:") !!}
					<select class="form-control select2" multiple="multiple" 
							data-placeholder="Seleccione una o mas maquinarias"
							style="width: 100%;" name="maquinarias[]">
							@foreach($maquinarias as $maquinaria)
							<option value="{{$maquinaria->id}}">{{$maquinaria->nombre}}</option>
							@endforeach
					</select>
					</div>
				</div>
			</div>
			<br>
			<div class="text-right m-t-15">
				<a class='btn btn-primary form-gradient-color form-button' href="{{ url('/servicios') }}">Regresar</a>
				{!! Form::input('submit', 'submit', 'Guardar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonServicio']) !!}
			</div>
			<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
		<br>
		{!! Form::close() !!}
	</div>
</div>
@endsection

@section('scripts')
{!! HTML::script('/js/servicios/create.js') !!}
@endsection