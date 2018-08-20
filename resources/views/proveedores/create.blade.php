@extends('layouts.app')
@section('content')
<div id="page-wrapper">
	<div id="page-inner">
		<!-- {!! Form::open(array('class' => 'form', 'id' => 'ProductoForm')) !!} -->
		{!! Form::open( array( 'id' => 'ProveedorForm') ) !!}
		<div class="row">
			<div class="col-sm-12">
				<h3 class="tittle-custom"> Creación de Proveedores </h3>
				<line>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-3">
					{!! Form::label("nit","NIT:") !!}
					{!! Form::number( "nit" , null , ['class' => 'form-control' , 'placeholder' => 'NIT' ]) !!}
				</div>
				<div class="col-sm-9">
					{!! Form::label("nombre","Nombre Comercial:") !!}
					{!! Form::text( "nombre_comercial" , null , ['class' => 'form-control' , 'placeholder' => 'Nombre Comercial' ]) !!}
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-6">
					{!! Form::label("representante","Representante:") !!}
					{!! Form::text( "representante" , null , ['class' => 'form-control' , 'placeholder' => 'Representante' ]) !!}
				</div>
				<div class="col-sm-3">
					{!! Form::label("telefonos","Teléfonos:") !!}
					{!! Form::number( "telefonos" , null , ['class' => 'form-control' , 'placeholder' => 'Teléfonos' ]) !!}
				</div>
				<div class="col-sm-3">
					{!! Form::label("cuentac","Nomenclatura Contable:") !!}
					{!! Form::text( "cuentac" , null , ['class' => 'form-control' , 'placeholder' => 'Nomenclatura Contable' ]) !!}
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-12">
					{!! Form::label("direccion","Dirección:") !!}
					{!! Form::text( "direccion" , null , ['class' => 'form-control' , 'placeholder' => 'Dirección' ]) !!}
				</div>
			</div>
			
		</br>
		<div class="text-right m-t-15">
			<a class='btn btn-primary form-gradient-color form-button' href="{{ url('/proveedores') }}">Regresar</a>

			{!! Form::input('submit', 'submit', 'Guardar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonProveedor']) !!}
		</div>
		<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
	</br>
	{!! Form::close() !!}
</div>
</div>
@endsection
@section('scripts')
{!! HTML::script('/../../sfi_tecu/sfi/js/proveedores/create.js') !!}
@endsection