@extends('layouts.app')
@section('content')
<div id="content">
	<div class="container-custom">
		<!-- {!! Form::open(array('class' => 'form', 'id' => 'ProductoForm')) !!} -->
		{!! Form::open( array( 'id' => 'BloqClienteForm') ) !!}
		<div class="row">
			<div class="col-sm-12">
				<h3 class="tittle-custom"> Bloqueo y Desbloqueo de Clientes </h3>
				<line>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-9">
					{!! Form::label("cliente","Cliente:") !!}
					<select class="selectpicker" id='cliente' name="cliente" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
						@foreach ($clientes as $cliente)
						<option value="{{$cliente->id}}">{{$cliente->cl_nit}}  -  {{$cliente->cl_nombres}} {{$cliente->cl_apellidos}}</option>
						@endforeach
					</select>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-3">
					{!! Form::label("cl_nit","NIT:") !!}
					{!! Form::text( "cl_nit" , null , ['class' => 'form-control' , 'placeholder' => 'NIT' ]) !!}
				</div>
				<div class="col-sm-6">
					{!! Form::label("tipo_cliente","Tipo Cliente:") !!}
					{!! Form::text( "tipo_cliente" , null , ['class' => 'form-control' , 'placeholder' => 'Tipo Cliente' ]) !!}
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
				<div class="col-sm-12">
					{!! Form::label("cl_direccion","Dirección:") !!}
					{!! Form::text( "cl_direccion" , null , ['class' => 'form-control' , 'placeholder' => 'Dirección' ]) !!}
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
				<div class="col-sm-3">
					{!! Form::label("saldo","Saldo:") !!}
					{!! Form::text( "saldo" , null , ['class' => 'form-control' , 'placeholder' => 'Saldo' ]) !!}
				</div>
				<div class="col-sm-3">
					{!! Form::label("estado","Estado:") !!}
					{!! Form::text( "estado" , null , ['class' => 'form-control' , 'placeholder' => 'Estado' ]) !!}
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-12">
					{!! Form::label("razon","Razón:") !!}
					{!! Form::text( "razon" , null , ['class' => 'form-control' , 'placeholder' => 'Razón' ]) !!}
				</div>
			</div>
			<br>
			<div class="text-right m-t-15">
				<a class='btn btn-primary form-gradient-color form-button' href="{{ url('/home') }}">Regresar</a>

				{!! Form::input('submit', 'submit', 'Bloquear', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonClienteBloq']) !!}

				{!! Form::input('submit', 'submit', 'Desbloquear', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonClienteDes']) !!}
			</div>
			<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
		</br>
		{!! Form::close() !!}
	</div>
</div>
@endsection
@section('scripts')
{!! HTML::script('/../../sfi/sfi/js/clientes/bloq.js') !!}
@endsection