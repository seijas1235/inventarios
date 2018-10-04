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
					{!! Form::text( "fecha" , null , ['class' => 'form-control' , 'placeholder' => 'Fecha', 'id' => 'fecha' ]) !!}
				</div>

				<div class="col-sm-4">
					{!! Form::label("num_factura","No. Factura:") !!}
					{!! Form::text( "num_factura" , null , ['class' => 'form-control' , 'placeholder' => 'No. Factura' ]) !!}
				</div>
			</div>
			<hr>

			<div class="row">
				<div class="col-sm-3">
					{!! Form::label("codigo_barra","Codego de Barra:") !!}
					{!! Form::hidden("producto_id" , null , ['class' => 'form-control' , 'disabled']) !!}
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
					{!! Form::label("precio_compra","Precio Costo:") !!}
					{!! Form::text( "precio_compra" , null , ['class' => 'form-control' , 'placeholder' => 'Precio Costo' ]) !!}
				</div>
			</div>

			<br>
				<div class="row">
				</div>
				<div class="text-right m-t-15">
					{!! Form::button('Agregar Nuevo Producto' , ['class' => 'btn btn-success' ,'id' => 'addDetalle', 'data-loading-text' => 'Processing...' ]) !!}
				</div>				
			<br>
			<div id="detallecompra-grid">


				<div class="title m-b-md">
					Laravel
				</div>
				<label for="txtNombre">Nombre</label>
				<input type="text" id="txtNombre">
				
				<label for="txtCantidad">Nombre</label>
				<input type="text" id="txtCantidad">
				<button type="button" id="btnEnviar">Enviar</button>
				<br>
				<table id="detalle">
					<thead>
						<th>Nombre</th>
						<th>Cantidad</th>
					</thead>
				
					<tfoot>
						<th></th>
						<th>Total</th>
					</tfoot>
				
					<tbody>
				
					</tbody>
				</table>
			</div>
			<br>
			<div class="col-sm-4" id="total">
				<h3>{!! Form::label("total","Total:") !!}</h3>
				{!! Form::text( "total" , null, ['class' => 'form-control', 'id' => 'total', 'disabled']) !!}
			</div>
			<div class="text-right m-t-15">
				<a class='btn btn-primary form-gradient-color form-button' href="{{ url('/compras') }}">Regresar</a>
				{!! Form::submit('Agregar Nueva Compra' , ['class' => 'btn btn-success btn-submit-ingresoproducto', 'id' => 'ButtonCompra', 'data-loading-text' => 'Processing...' ]) !!}
			</div>
			<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
		<br>
	</div>
</div>

@endsection

@section('scripts')
{!! HTML::script('/js/compras/create.js') !!}
{!! HTML::script('/js/compras/grid.js') !!}
{!! HTML::script('/js/compras/prueba.js') !!}
@endsection