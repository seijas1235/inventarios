@extends('layouts.app')
@section('content')
<div id="content">
	<div class="container-custom">
		<!-- {!! Form::open(array('class' => 'form', 'id' => 'ClienteForm')) !!} -->
		{!! Form::open( array( 'id' => 'ClienteForm') ) !!}
		<div class="row">
			<div class="col-sm-12">
				<h3 class="tittle-custom"> Creación de Clientes </h3>
				<line>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-4">
					{!! Form::label("nit","NIT:") !!}
					{!! Form::text( "nit" , null , ['class' => 'form-control' , 'placeholder' => 'NIT' ]) !!}
				</div>
				<div class="col-sm-4">
				</div>
				<div class="col-sm-4">
					{!! Form::label("tipo_cliente_id","Tipo de Cliente:") !!}
					<select class="selectpicker" id='tipo_cliente_id' name="tipo_cliente_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
						@foreach ($tipos_clientes as $tipo_cliente)
						<option value="{{$tipo_cliente->id}}">{{$tipo_cliente->nombre}}</option>
						@endforeach
					</select>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-6">
					{!! Form::label("nombres","Nombres:") !!}
					{!! Form::text( "nombres" , null , ['class' => 'form-control' , 'placeholder' => 'Nombres' ]) !!}
				</div>
				<div class="col-sm-6">
					{!! Form::label("apellidos","Apellidos:") !!}
					{!! Form::text( "apellidos" , null , ['class' => 'form-control' , 'placeholder' => 'Apellidos' ]) !!}
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-4">
					{!! Form::label("telefonos","Telefonos:") !!}
					{!! Form::text( "telefonos" , null , ['class' => 'form-control' , 'placeholder' => 'Telefonos' ]) !!}
				</div>

				<div class="col-sm-8">
					{!! Form::label("direccion","Dirección:") !!}
					{!! Form::text( "direccion" , null , ['class' => 'form-control' , 'placeholder' => 'Dirección' ]) !!}
				</div>
			
			</div>
			<br>
			<div class="text-right m-t-15">
				<a class='btn btn-primary form-gradient-color form-button' href="{{ url('/clientes') }}">Regresar</a>
				{!! Form::input('submit', 'submit', 'Guardar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonCliente']) !!}
			</div>
			<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
		<br>
		{!! Form::close() !!}
	</div>
</div>
@endsection

@section('scripts')
{!! HTML::script('/js/clientes/create.js') !!}
@endsection