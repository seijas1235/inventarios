@extends('layouts.app')
@section('content')
<div id="content">
	<div class="container-custom">
		{!! Form::open( array( 'id' => 'OrdenDeTrabajoForm') ) !!}
		<div class="row">
			<div class="col-sm-12">
				<h3 class="tittle-custom"> Orden de Trabajo </h3>
				<line>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-4">
					{!! Form::label("fecha_hora","Fecha y hora:") !!}
					<input type="datetime-local" class="form-control" name="fecha_hora">	
				</div>
				<div class="col-sm-4">
					{!! Form::label("resp_recepcion","Responsable de la recepcion:") !!}
					{!! Form::text( "resp_recepcion" , null , ['class' => 'form-control' , 'placeholder' => 'Responsable de la recepcion' ]) !!}
				</div>
				<div class="col-sm-4">
					{!! Form::label("fecha_prometida","Fecha prometida:") !!}
					{!! Form::date( "fecha_prometida" , null , ['class' => 'form-control' , 'placeholder' => 'Fecha y Hora' ]) !!}
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-6">
					{!! Form::label("cliente_id","Cliente:") !!}
					<select class="selectpicker" id='cliente_id' name="cliente_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
						@foreach ($clientes as $cliente)
						<option value="{{$cliente->id}}">{{$cliente->nombres.''.$cliente->apellidos}}</option>
						@endforeach
					</select>
				</div>
				<div class="col-sm-6">
					{!! Form::label("vehiculo_id","Vehiculo:") !!}
					<select class="selectpicker" id='vehiculo_id' name="vehiculo_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
						@foreach ($vehiculos as $vehiculo)
						<option value="{{$vehiculo->id}}">{{$vehiculo->placa}}</option>
						@endforeach
					</select>
				</div>
			</div>
			<br>
			<div class="row">
			
			</div>
			<br>
			<div class="text-right m-t-15">
				<a class='btn btn-primary form-gradient-color form-button' href="{{ url('/ordenes_de_trabajo') }}">Regresar</a>
				{!! Form::input('submit', 'submit', 'Siguiente', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonOrdenDeTrabajo']) !!}
			</div>
			<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
		<br>
		{!! Form::close() !!}
	</div>
</div>
@endsection

@section('scripts')
{!! HTML::script('/js/ordenes_de_trabajo/create.js') !!}
@endsection