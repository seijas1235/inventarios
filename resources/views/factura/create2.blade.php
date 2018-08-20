@extends('layouts.app')
@section('content')
<div id="content">
	<div class="container-custom">
		<!-- {!! Form::open(array('class' => 'form', 'id' => 'ProductoForm')) !!} -->
		{!! Form::open( array( 'id' => 'Factura2Form') ) !!}
		<div class="row">
			<div class="col-sm-12">
				<h3 class="tittle-custom">Creación de Factura Manual
				</h3>
			</div>
		</div>
		<hr>

		<div class="row">
			<div class="col-sm-4">
				{!! Form::label("nit","NIT:") !!}
				{!! Form::text( "nit" , null , ['class' => 'form-control' , 'placeholder' => 'NIT', 'id' => 'nit']) !!}
			</div>
			<div class="col-sm-8">
				{!! Form::label("cliente","Cliente:") !!}
				{!! Form::text( "cliente" , null , ['class' => 'form-control' , 'placeholder' => 'Cliente', 'id' => 'cliente']) !!}
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-sm-12">
				{!! Form::label("direccion","Dirección:") !!}
				{!! Form::text( "direccion" , null , ['class' => 'form-control' , 'placeholder' => 'Direccion', 'id' => 'direccion']) !!}
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-lg-4">
				{!! Form::label("fecha_factura","Fecha factura:") !!}
				{!! Form::text( "fecha_factura" , null , ['class' => 'form-control' , 'placeholder' => 'Fecha de Factura', 'id' => 'fecha_factura']) !!}
			</div>
			<div class="col-lg-4">
				{!! Form::label("serie_id","Serie:") !!}
				<select class="selectpicker" id='serie_id' name="serie_id" value="" data-live-search="true" data-live-search-placeholder="Busqueda" title="Seleccione">
					@foreach ($series as $serie)
					<option value="{{$serie->id}}">{{$serie->serie}} </option>
					@endforeach
				</select>
			</div>
			<div class="col-lg-4">
				{!! Form::label("no_factura","No. Factura:") !!}
				{!! Form::text( "no_factura" , null , ['class' => 'form-control' , 'placeholder' => 'No. Factura', 'id' => 'no_factura']) !!}
			</div>
		</div>
		<hr>
		<br>
		<div class="row">
			<div class="col-lg-12">
				<strong>
					<div class="col-lg-3">
						Tipo de Gasolina
					</div>
					<div class="col-lg-3">
						Precio
					</div>
					<div class="col-lg-3">
						Cantidad de Galones
					</div>
					<div class="col-lg-3">
						Total
					</div>
				</strong>

				<div class="col-lg-3">
					Gasolina Super
				</div>
				<div class="col-lg-3">
					{!! Form::number( "super" , $super->precio_venta , ['class' => 'form-control' , 'placeholder' => '0.00' ]) !!}
				</div>
				<div class="col-lg-3">    
					{!! Form::number( "cant_super" , 0.00 , ['class' => 'form-control' , 'placeholder' => '0.00' ]) !!} 
				</div>
				<div class="col-lg-3">
					{!! Form::number( "total_super" , 0.00 , ['class' => 'form-control' , 'placeholder' => '0.00', 'disabled' => true ]) !!}
				</div>

				<div class="col-lg-3">
					Diesel
				</div>
				<div class="col-lg-3">
					{!! Form::number( "disel" , $disel->precio_venta , ['class' => 'form-control' , 'placeholder' => '0.00' ]) !!}
				</div>
				<div class="col-lg-3">
					{!! Form::number( "cant_disel" , 0.00 , ['class' => 'form-control' , 'placeholder' => '0.00' ]) !!}
				</div>
				<div class="col-lg-3">
					{!! Form::number( "total_disel" , 0.00 , ['class' => 'form-control' , 'placeholder' => '0.00', 'disabled' => true ]) !!}
				</div>

				<div class="col-lg-3">
					Gasolina Regular
				</div>
				<div class="col-lg-3">
					{!! Form::number( "regular" , $regular->precio_venta, ['class' => 'form-control' , 'placeholder' => '0.00' ]) !!}
				</div>
				<div class="col-lg-3">
					{!! Form::number( "cant_regular" , 0.00 , ['class' => 'form-control' , 'placeholder' => '0.00' ]) !!}
				</div>
				<div class="col-lg-3">
					{!! Form::number( "total_regular" , 0.00 , ['class' => 'form-control' , 'placeholder' => '0.00', 'disabled' => true ]) !!}
				</div>


				<div class="col-lg-3">
					Lubricantes
				</div>
				<div class="col-lg-3">
					
				</div>
				<div class="col-lg-3">
					
				</div>
				<div class="col-lg-3">
					{!! Form::number( "total_lubs" , 0.00 , ['class' => 'form-control' , 'placeholder' => '0.00' ]) !!}
				</div>


				<div class="col-lg-3">
					Otros
				</div>
				<div class="col-lg-3">
					
				</div>
				<div class="col-lg-3">
					
				</div>
				<div class="col-lg-3">
					{!! Form::number( "total_otros" , 0.00 , ['class' => 'form-control' , 'placeholder' => '0.00' ]) !!}
				</div>
				<br>
				<br>
				<div class="col-lg-6 text-right" style="margin-top: 20px;">
					<span>Total:</span>
				</div>
				<div class="col-lg-6 text-right" style="margin-top: 15px;">
					{!! Form::number( "total" , 0 , ['class' => 'form-control' , 'placeholder' => '0.00', 'disabled' => true ]) !!}
				</div>
			</div>

		</div>
	</div>
	<br>
	<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
	<div class="text-right m-t-15">
		{!! Form::input('submit', 'submit', 'Guardar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonFac2']) !!}
	</div>
	{!! Form::close() !!}
</div>
</div>

@endsection
@section('scripts')
{!! HTML::script('/../../sfi_tecu/sfi/js/factura/create2.js') !!}
@endsection
