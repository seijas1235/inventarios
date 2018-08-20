@extends('layouts.app')
@section('content')
<div id="content">
	<div class="container-custom">
		<!-- {!! Form::open(array('class' => 'form', 'id' => 'ProductoForm')) !!} -->
		{!! Form::open( array( 'id' => 'ClienteForm') ) !!}
		<div class="row">
			<div class="col-sm-12">
				<h3 class="tittle-custom"> Creación de Clientes </h3>
				<line>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-3">
					{!! Form::label("cl_nit","NIT:") !!}
					{!! Form::text( "cl_nit" , null , ['class' => 'form-control' , 'placeholder' => 'NIT' ]) !!}
				</div>
				<div class="col-sm-3">
					{!! Form::label("tipo_cliente_id","Tipo de Cliente:") !!}
					<select class="selectpicker" id='tipo_cliente_id' name="tipo_cliente_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
						@foreach ($tipos_clientes as $tipo_cliente)
						<option value="{{$tipo_cliente->id}}">{{$tipo_cliente->tipo_cliente}}</option>
						@endforeach
					</select>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-6">
					{!! Form::label("cl_nombres","Nombres:") !!}
					{!! Form::text( "cl_nombres" , null , ['class' => 'form-control' , 'placeholder' => 'Nombres' ]) !!}
				</div>
				<div class="col-sm-6">
					{!! Form::label("cl_apellidos","Apellidos:") !!}
					{!! Form::text( "cl_apellidos" , null , ['class' => 'form-control' , 'placeholder' => 'Apellidos' ]) !!}
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-3">
				{!! Form::label("cl_telefonos","Teléfonos:") !!}
					{!! Form::number( "cl_telefonos" , null , ['class' => 'form-control' , 'placeholder' => 'Teléfonos' ]) !!}
				</div>
				<div class="col-sm-3">
				{!! Form::label("cl_montomaximo","Monto Máximo:") !!}
					{!! Form::number( "cl_montomaximo" , null , ['class' => 'form-control' , 'placeholder' => 'Monto Máximo' ]) !!}
				</div>
				<div class="col-sm-6">
				{!! Form::label("cl_mail","Correo Electrónico:") !!}
					{!! Form::text( "cl_mail" , null , ['class' => 'form-control' , 'placeholder' => 'Correo Electrónico' ]) !!}
				</div>
			</div>
			<br>
			<div class="row">
			<div class="col-sm-8">
					{!! Form::label("cl_direccion","Dirección:") !!}
					{!! Form::text( "cl_direccion" , null , ['class' => 'form-control' , 'placeholder' => 'Dirección' ]) !!}
				</div>
				<div class="col-sm-3">
				{!! Form::label("cl_cuentac","Nomenclatura Contable:") !!}
					{!! Form::text( "cl_cuentac" , null , ['class' => 'form-control' , 'placeholder' => 'Nomenclatura Contable' ]) !!}
				</div>
			</div>
			<br>
			<div class="text-right m-t-15">
				<a class='btn btn-primary form-gradient-color form-button' href="{{ url('/clientes') }}">Regresar</a>

				{!! Form::input('submit', 'submit', 'Guardar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonCliente']) !!}
			</div>
			<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
		</br>
		{!! Form::close() !!}
	</div>
</div>
@endsection
@section('scripts')
{!! HTML::script('/../../sfi/sfi/js/clientes/create.js') !!}
@endsection