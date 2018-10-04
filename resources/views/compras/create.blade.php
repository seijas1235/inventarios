@extends('layouts.app')
@section('content')
<div id="content">
	<div class="container-custom">
		<!-- {!! Form::open(array('class' => 'form', 'id' => 'CompraForm')) !!} -->
		{!! Form::open( array( 'id' => 'CompraForm') ) !!}
		<div class="row">
			<div class="col-sm-12">
				<h3 class="tittle-custom"> Creación de Compras </h3>
				<line>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-4">
					{!! Form::label("proveedor_id","Proveedor:") !!}
					<select class="selectpicker" id='proveedor_id' name="proveedor_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
						@foreach ($proveedores as $proveedor)
						<option value="{{$proveedor->id}}">{{$proveedor->nombre}}</option>
						@endforeach
					</select>
				</div>

				<div class="col-sm-4">
					{!! Form::label("fecha","Fecha:") !!}
					{!! Form::text( "fecha" , null , ['class' => 'form-control' , 'placeholder' => 'Fecha' ]) !!}
				</div>
			</div>
			<hr>

			<div class="row">
				<div class="col-sm-3">
					{!! Form::label("codigo_barra","Codego de Barra:") !!}
					{!! Form::text( "codigo_barra" , null , ['class' => 'form-control' , 'placeholder' => 'Codigo Barra' ]) !!}
				</div>

				<div class="col-sm-3">
					{!! Form::label("nombre","Descripcion del Producto:") !!}
					{!! Form::text( "nombre" , null , ['class' => 'form-control' , 'disabled','placeholder' => 'Descripcion del producto' ]) !!}
				</div>

				<div class="col-sm-3">
					{!! Form::label("cantidad","Cantidad:") !!}
					{!! Form::text( "cantidad" , null , ['class' => 'form-control' , 'placeholder' => 'Cantidad' ]) !!}
				</div>

				<div class="col-sm-3">
					{!! Form::label("precio_costo","Precio Compra:") !!}
					{!! Form::text( "precio_costo" , null , ['class' => 'form-control' , 'placeholder' => 'Precio Costo' ]) !!}
				</div>
			</div>

			<br>
				<div class="row">
				</div>
				<div class="text-right m-t-15">
					{!! Form::button('Agregar Nuevo Producto' , ['class' => 'btn btn-success' ,'id' => 'addDetalle', 'data-loading-text' => 'Processing...' ]) !!}
				</div>				
			<br>
			<div id="detallecompra-grid"></div>
			<br>
			<div class="col-sm-4" id="total">
				<h3>{!! Form::label("total","Total:") !!}</h3>
				{!! Form::text( "total" , null, ['class' => 'form-control', 'id' => 'total', 'disabled']) !!}
			</div>
			<div class="text-right m-t-15">
				<a class='btn btn-primary form-gradient-color form-button' href="{{ url('/compras') }}">Regresar</a>
				{!! Form::input('submit', 'submit', 'Guardar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonCompra']) !!}
			</div>
			<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
		<br>
		{!! Form::close() !!}
	</div>
</div>
@endsection

@section('scripts')
{!! HTML::script('/js/compras/create.js') !!}
{!! HTML::script('/js/compras/grid.js') !!}
@endsection