@extends('layouts.app')
@section('content')
<div id="content">
	<div class="container-custom">
		<div class="row">
			<div class="col-sm-12">
				<h3 class="tittle-custom"> Creación de Compras </h3>
				<line>
				</div>
		</div>
			<br>
			<div class="row">
				<div class="col-sm-3">
					{!! Form::label("edo_ingreso_id","Estado:") !!}
					{!! Form::text( "edo_ingreso_id" , "Activo", ['class' => 'form-control' , 'disabled' ]) !!}
				</div>
				<div class="col-sm-3">
					{!! Form::label("fecha_ingreso","Fecha Compra:") !!}
					{!! Form::text( "fecha_ingreso" , null , ['class' => 'form-control' , 'placeholder' => 'Fecha', 'id' => 'fecha_ingreso' ]) !!}
				</div>
			</div>	
			<br>
			<div class="row">
				<div class="col-sm-3">
					{!! Form::label("proveedor_id","Proveedor:") !!}
					<select class="selectpicker" id='proveedor_id' name="proveedor_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
						@foreach ($proveedores as $proveedor)
						<option value="{{$proveedor->id}}">{{$proveedor->nombre}}</option>
						@endforeach
					</select>
				</div>

				<div class="col-sm-3">
					{!! Form::label("fecha_factura","Fecha factura:") !!}
					{!! Form::text( "fecha_factura" , null , ['class' => 'form-control' , 'placeholder' => 'Fecha', 'id' => 'fecha_factura' ]) !!}
				</div>

				<div class="col-sm-3">
					{!! Form::label("serie_factura","No. Serie:") !!}
					{!! Form::text( "serie_factura" , null , ['class' => 'form-control' , 'placeholder' => 'No. Serie' ]) !!}
				</div>

				<div class="col-sm-3">
					{!! Form::label("num_factura","No. Factura:") !!}
					{!! Form::text( "num_factura" , null , ['class' => 'form-control' , 'placeholder' => 'No. Factura' ]) !!}
				</div>	
			</div>
			<hr>

			<div class="row">
				<div class="col-sm-3">
					{!! Form::label("codigo_barra","Codigo de Barra:") !!}
					{!! Form::hidden("producto_id" , null , ['class' => 'form-control' , 'disabled']) !!}
					{!! Form::hidden("subtotal" , null , ['class' => 'form-control' , 'disabled']) !!}
					{!! Form::text( "codigo_barra" , null , ['class' => 'form-control' , 'placeholder' => 'Codigo Barra' ]) !!}
				</div>

				<div class="col-sm-3">
					{!! Form::label("nombre","Descripcion del Producto:") !!}
					{!! Form::text( "nombre" , null , ['class' => 'form-control' , 'disabled','placeholder' => 'Descripcion del producto' ]) !!}
				</div>

				<div class="col-sm-2">
					{!! Form::label("cantidad_ingreso","Cantidad:") !!}
					{!! Form::text( "cantidad" , null , ['class' => 'form-control' , 'placeholder' => 'Cantidad' ]) !!}
				</div>

				<div class="col-sm-2">
					{!! Form::label("precio_compra","Precio Compra:") !!}
					{!! Form::text( "precio_compra" , null , ['class' => 'form-control' , 'placeholder' => 'Precio Compra' ]) !!}
				</div>

				<div class="col-sm-2">
						{!! Form::label("precio_venta","Precio Venta:") !!}
						{!! Form::text( "precio_venta" , null , ['class' => 'form-control' , 'placeholder' => 'Precio venta' ]) !!}
					</div>
			</div>

			<br>
				<div class="row">
				</div>
				<div class="text-right m-t-15">
					{!! Form::button('Agregar Nuevo Producto' , ['class' => 'btn btn-success' ,'id' => 'addDetalle', 'data-loading-text' => 'Processing...' ]) !!}
				</div>				
			<br>
			<div id="compradetalle-grid">

			</div>
			<br>
			<div class="col-sm-4" id="total">
				<h3>{!! Form::label("total","Total:") !!}</h3>
				{!! Form::text( "total" , null, ['class' => 'form-control', 'id' => 'total', 'disabled']) !!}
			</div>
			<div class="text-right m-t-15">
				<a class='btn btn-primary form-gradient-color form-button' href="{{ url('/compras') }}">Regresar</a>
				{!! Form::submit('Agregar Nueva Compra' , ['class' => 'btn btn-success btn-submit-ingresoproducto', 'id' => 'ButtonDetalle', 'data-loading-text' => 'Processing...' ]) !!}
			</div>
			<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
		<br>
	</div>
</div>

@endsection

@section('scripts')

{!! HTML::script('/js/compras/create.js') !!}
{!! HTML::script('/js/compras/grid.js') !!}

@endsection