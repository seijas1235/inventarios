@extends('layouts.app')
@section('content')
<style>
	.form-control {
		font-size: 20px;
	}
</style>
<div id="content">
	<div class="container-custom">
		<!-- {!! Form::open(array('class' => 'form', 'id' => 'ProductoForm')) !!} -->
		{!! Form::open( array( 'id' => 'ValeForm') ) !!}
		<div class="row">
			<div class="col-sm-12">
				<h3 class="tittle-custom">Creaci®Æn de Vales </h3>
				<line>
				</div>
				{!! Form::hidden( "total_vale" , 0 , ['class' => 'form-control',  'id' => 'total_vale', 'disabled' ]) !!}
			</div>
			<br>
			<div class="cliente">
				<div class="row">
					<div class="col-sm-12"> 
						<h3>
							{!! Form::label("cliente_id","Cliente:") !!}
							{{App\cliente::find($vale->cliente_id)->cl_nombres}} 
							{{App\cliente::find($vale->cliente_id)->cl_apellidos}} 
						</h3>
					</div>
{!! Form::hidden( "cliente_id" , $vale->cliente_id , ['class' => 'form-control' , 'disabled' ]) !!}
{!! Form::hidden( "vale_id" , $vale->id , ['class' => 'form-control' , 'disabled' ]) !!}

				</div>
				<div class="row">
					<div class="col-sm-6">
						{!! Form::label("piloto","Piloto:") !!}
						{!! Form::text( "piloto" , '', ['class' => 'form-control' , 'placeholder' => 'Piloto']) !!}
					</div>
					<div class="col-sm-6">
						{!! Form::label("placa","Placa:") !!}
						{!! Form::text( "placa" , '', ['class' => 'form-control' , 'placeholder' => 'Placa']) !!}
					</div>
				</div>
				<br>
				<div class="text-right m-t-15">
					<a class='btn btn-primary form-gradient-color btn-lg form-button' id="SelecCliente">Seleccionar</a>
				</div>
			</div>
		</br>
		<div class="row hidden botones">
			@foreach ($bombas as $bomba)
			<div class="col-lg-3">
				<a style="margin-bottom: 1em;" id="{{$bomba->id}}" class="btn btn-success btn-lg btn-block gasolinaButton">{{$bomba->bomba}}</a>
			</div>
			@endforeach

		</div>

		<div class="row hidden producto">
			<div class="col-sm-3">
				{!! Form::label("producto","Producto:") !!}
				<select class="selectpicker" id='producto_id' name="producto_id" value="" data-live-search="true" data-live-search-placeholder="B√∫squeda" title="Seleccione">
					@foreach ($productos as $producto)
					<option value="{{$producto->id}}">{{$producto->nombre}} </option>
					@endforeach
				</select>
			</div>
			<div class="col-sm-2">
				{!! Form::label("total_vale","Cantidad:") !!}
				{!! Form::number( "cantidad_p" , 1, ['class' => 'form-control' , 'placeholder' => 'Cantidad']) !!}
			</div>
			<div class="col-sm-2">
				{!! Form::label("subtotal","Precio:") !!}
				<div class="input-group">			{!! Form::hidden( "combustible_id" , null , ['class' => 'form-control' , 'disabled' ]) !!}
					<span class="input-group-addon">Q</span>
					{!! Form::number( "precio_p" , null , ['class' => 'form-control' , 'disabled', 'placeholder' => '0.00' ]) !!}
				</div>
			</div>
			<div class="col-sm-3">
				{!! Form::label("subtotal","Subtotal:") !!}
				<div class="input-group">
					<span class="input-group-addon">Q</span>
					{!! Form::number( "subtotal_p" , null , ['class' => 'form-control' , 'disabled', 'placeholder' => '0.00' ]) !!}
				</div>
				{!! Form::hidden( "precio_compra_p" , null , ['class' => 'form-control' , 'disabled', 'placeholder' => '0.00' ]) !!}
			</div>
			<div class="col-sm-2 text-right">

				{!! Form::input('submit', 'submit', 'Agregar', ['class' => 'btn btn-danger form-gradient-color form-button2', 'id'=>'ButtonProducto']) !!}
			</div>
		</div>


		<div class="row hidden gasolina">
			<div class="col-sm-2 text-right">
				<a id="addProducto" class="btn btn-success btn-lg btn-block"> Agregar Producto </a>
			</div>
			<div class="col-sm-2 text-right">
				<a id="cambiarBomba" class="btn btn-success btn-lg btn-block"> Cambiar Bomba </a>
			</div>
			<div class="col-lg-12">
				{!! Form::label("has_orden","Cantidad en Quetzales:") !!}
			</br>
			<input type="checkbox" checked data-toggle="toggle" data="quetzales" id="quetzales" data-on="Si" data-off="No">
		</div>
		<div class="col-sm-3">
			{!! Form::label("combustible_id","Combustible:") !!}
			<select class="selectpicker" id='combustible_id' name="combustible_id" value="" data-live-search="true" data-live-search-placeholder="B√∫squeda" title="Seleccione">
			</select>
		</div>
		<div class="col-sm-2">
			{!! Form::label("total_vale","Cantidad:") !!}
			{!! Form::number( "cantidad_c" , 1, ['class' => 'form-control' , 'placeholder' => 'Total Vale' ]) !!}
		</div>
		<div class="col-sm-2">
			{!! Form::label("subtotal","Precio por Gal√≥n:") !!}
			<div class="input-group">
				<span class="input-group-addon">Q</span>
				{!! Form::number( "precio_c" , null , ['class' => 'form-control' , 'disabled', 'placeholder' => '0.00' ]) !!}
			</div>		</div>
			<div class="col-sm-3">
				{!! Form::label("subtotal","Subtotal:") !!}
				<div class="input-group">
					<span class="input-group-addon">Q</span>
					{!! Form::number( "subtotal_c" , null , ['class' => 'form-control' , 'disabled', 'placeholder' => '0.00' ]) !!}
				</div>
			</div>
			{!! Form::hidden( "precio_compra_c" , null , ['class' => 'form-control' , 'disabled' ]) !!}
			{!! Form::hidden( "combustible_id" , null , ['class' => 'form-control' , 'id' => 'combustible_id', 'disabled' ]) !!}
			{!! Form::hidden( "bomba_id" , null , ['class' => 'form-control',  'id' => 'bomba_id', 'disabled' ]) !!}
			<div class="col-sm-2 text-right">
				{!! Form::input('submit', 'submit', 'Agregar', ['class' => 'btn btn-danger form-gradient-color form-button2', 'id'=>'ButtonCombustible']) !!}
			</div>
		</div>
		<br>

		<div id="detalle">
			<hr>
			<h3> Detalle del Vale</h3>
			<br>
			<div id="detalle-grid"></div>
		</div>
	</br>
	<div class="text-right m-t-15">
		<a class='btn btn-primary form-gradient-color form-button' href="{{ url('/vales') }}">Regresar</a>

		{!! Form::input('submit', 'submit', 'Guardar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonVale']) !!}
	</div>

	<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
</div>
</div>
{!! Form::close() !!}
</div>
</div>

@endsection
@section('scripts')
{!! HTML::script('/../../sfi/sfi/js/vales/edit.js') !!}
@endsection
