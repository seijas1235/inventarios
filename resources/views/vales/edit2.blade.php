@extends('layouts.app')
@section('content')
<div id="content">
	<div class="container-custom">
		<!-- {!! Form::open(array('class' => 'form', 'id' => 'ProductoForm')) !!} -->
		{!! Form::open( array( 'id' => 'ValeForm') ) !!}
		<div class="row">
			<div class="col-sm-12">
				<h3 class="tittle-custom">Edición de Vales </h3>
				<line>
				</div>
			</div>
			<br>
			{!! Form::hidden( "vale_id" , $vale->id , ['class' => 'form-control' , 'disabled' ]) !!}
			<div class="row">
				<div class="col-sm-3">
					{!! Form::label("piloto","Piloto:") !!}
					{!! Form::text( "piloto" , $vale->piloto, ['class' => 'form-control' , 'placeholder' => 'Piloto']) !!}
				</div>
				<div class="col-sm-3">
					{!! Form::label("placa","Placa:") !!}
					{!! Form::text( "placa" , $vale->placa, ['class' => 'form-control' , 'placeholder' => 'Placa']) !!}
				</div>
				<div class="col-sm-3">
					{!! Form::label("cliente_id","Cliente:") !!}
					<select class="selectpicker" id='cliente_id' name="cliente_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
						@foreach ($clientes as $cl)
						@if ( $vale->cliente_id == $cl->id)
						<option value="{{$cl->id}}" selected="">{{$cl->cl_nombres}} {{$cl->cl_apellidos}} </option>
						@else
						<option value="{{$cl->id}}">{{$cl->cl_nombres}} {{$cl->cl_apellidos}} </option>
						@endif
						@endforeach
					</select>
				</div>
				<div class="col-sm-3">
					{!! Form::label("no_vale","No Vale:") !!}
					{!! Form::text( "no_vale" , $vale->no_vale, ['class' => 'form-control' , 'placeholder' => 'No_Vale' ]) !!}
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-3">
					{!! Form::label("tipo_vehiculo","Tipo Vehículo:") !!}
					<select class="selectpicker" id='tipo_vehiculo_id' name="tipo_vehiculo_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
						@foreach ($tipo_vehiculos as $tipo_vehiculo)
						@if ( $vale->tipo_vehiculo_id == $tipo_vehiculo->id)
						<option value="{{$tipo_vehiculo->id}}" selected="">{{$tipo_vehiculo->tipo_vehiculo}} </option>
						@else
						<option value="{{$tipo_vehiculo->id}}">{{$tipo_vehiculo->tipo_vehiculo}} </option>
						@endif
						@endforeach
					</select>
				</div>
				<div class="col-sm-3">
					{!! Form::label("fecha_corte","Fecha Corte:") !!}
					{!! Form::text( "fecha_corte" , $vale->fecha_corte, ['class' => 'form-control' , 'placeholder' => 'Fecha Corte' ]) !!}
				</div>
				<div class="col-sm-3">
					{!! Form::label("codigo_corte","Codigo Corte:") !!}
					{!! Form::text( "codigo_corte" , $vale->codigo_corte, ['class' => 'form-control' , 'placeholder' => 'Codigo Corte' ]) !!}
				</div>
				<div class="col-sm-3">
					{!! Form::label("total_vale","Total Vale:") !!}
					{!! Form::text( "total_vale" , $vale->total_vale, ['class' => 'form-control' , 'placeholder' => 'Total_Vale' ]) !!}
				</div>
			</div>
			<br>
			<div class="text-right m-t-15">
				<a class='btn btn-primary form-gradient-color form-button' href="{{ url('/vales') }}">Regresar</a>

				{!! Form::input('submit', 'submit', 'Guardar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonVale']) !!}
			</div>
			<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
		</br>
		{!! Form::close() !!}
	</div>
</div>


@endsection
@section('scripts')
{!! HTML::script('/../../sfi/sfi/js/vales/edit2.js') !!}
@endsection