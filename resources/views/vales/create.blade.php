@extends('layouts.app')
@section('content')
<div id="content">
	<div class="container-custom">
		<!-- {!! Form::open(array('class' => 'form', 'id' => 'ProductoForm')) !!} -->
		{!! Form::open( array( 'id' => 'ValeForm') ) !!}
		<div class="row">
			<div class="col-sm-12">
				<h3 class="tittle-custom">Creación de Vales </h3>
				<line>
				</div>
			</div>
			<br>

			<div class="row">
				<div class="col-sm-3">
					{!! Form::label("cliente_id","Cliente:") !!}
					<select class="selectpicker" id='cliente_id' name="cliente_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
						@foreach ($clientes as $cliente)
						<option value="{{$cliente->id}}">{{$cliente->cl_nombres}} {{$cliente->cl_apellidos}}</option>
						@endforeach
					</select>
				</div>
				<div class="col-sm-3">
					{!! Form::label("bomba_id","Bomba:") !!}
					<select class="selectpicker" id='bomba_id' name="bomba_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
						@foreach ($bombas as $bomba)
						<option value="{{$bomba->id}}">{{$bomba->bomba}} </option>
						@endforeach
					</select>
				</div>
				<div class="col-sm-3">
					{!! Form::label("piloto","Piloto:") !!}
					{!! Form::text( "piloto" , '', ['class' => 'form-control' , 'placeholder' => 'Piloto']) !!}
				</div>
				<div class="col-sm-3">
					{!! Form::label("placa","Placa:") !!}
					{!! Form::text( "placa" , '', ['class' => 'form-control' , 'placeholder' => 'Placa']) !!}
				</div>
			</div>
			<div class="row">
				<div class="col-sm-3">
					{!! Form::label("Vale","No. Vale:") !!}
					{!! Form::number( "no_vale" , null , ['class' => 'form-control' , 'id' => 'no_vale']) !!}
				</div>
				<div class="col-sm-3">
					{!! Form::label("tipo_vehiculo","Tipo Vehículo:") !!}
					<select class="selectpicker" id='tipo_vehiculo_id' name="tipo_vehiculo_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
						@foreach ($tipo_vehiculos as $tipo_vehiculo)
						<option value="{{$tipo_vehiculo->id}}">{{$tipo_vehiculo->tipo_vehiculo}} </option>
						@endforeach
					</select>
				</div>
				<div class="col-sm-3">
					{!! Form::label("fecha_corte","Fecha Corte:") !!}
					{!! Form::text( "fecha_corte" , null , ['class' => 'form-control' , 'placeholder' => 'Fecha Corte' ]) !!}
				</div>
				<div class="col-sm-3">
					{!! Form::label("codigo_corte","Codigo Corte:") !!}
					{!! Form::text( "codigo_corte" , null , ['class' => 'form-control' , 'placeholder' => 'Codigo Corte' ]) !!}
				</div>
				
			</div>
			<div class="row">
			<div class="col-sm-3"> <strong>
					{!! Form::label("total_vale","Total Vale:") !!}  </strong>
					<div class="input-group">
						<span class="input-group-addon"> <strong> Q</span>
						{!! Form::number( "total_vale" , 0, ['class' => 'form-control' , 'disabled', 'placeholder' => '0.00' ]) !!} </strong>
					</div>
				</div>
			</div>
			<hr>
			<h5> Agregar Producto</h5>
			<div class="row">
				<div class="col-sm-3">
					{!! Form::label("producto","Producto:") !!}
					<select class="selectpicker" id='producto_id' name="producto_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
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
					<div class="input-group">
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
		</br>
		<hr>
		<h5> Agregar Combustible </h5>
		<div class="row">
			<div class="col-lg-12" hidden="true">
				{!! Form::label("has_orden","Cantidad en Quetzales:") !!}
			</br>
			<input style="width: 200px;" type="checkbox" checked data-toggle="toggle" data="quetzales" id="quetzales" data-on="Quetzales" data-off="Galones">
		</div>
		<div class="col-sm-3">
			{!! Form::label("combustible_id","Combustible:") !!}
			<select class="selectpicker" id='combustible_id' name="combustible_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
			</select>
		</div>
		<div class="col-sm-2">
			{!! Form::label("total_vale","Cantidad:") !!}
			{!! Form::number( "cantidad_c" , 1, ['class' => 'form-control' , 'placeholder' => 'Total Vale' ]) !!}
		</div>
		<div class="col-sm-2">
			{!! Form::label("subtotal","Precio por Galón:") !!}
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
			{!! Form::hidden( "combustible_id" , null , ['class' => 'form-control' , 'disabled' ]) !!}
			<div class="col-sm-2 text-right">
				{!! Form::input('submit', 'submit', 'Agregar', ['class' => 'btn btn-danger form-gradient-color form-button2', 'id'=>'ButtonCombustible']) !!}
			</div>
		</div>
	</br>
	<hr>
	<h3> Detalle del Vale</h3>
	<br>
	<div id="detalle-grid"></div>
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
{!! HTML::script('/../../sfi/sfi/js/vales/create.js') !!}
@endsection