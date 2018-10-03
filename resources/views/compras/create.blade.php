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

				<div class="col-sm-4">
					{!! Form::label("Total","Total:") !!}
					{!! Form::text( "Total" , null , ['class' => 'form-control' , 'placeholder' => 'Total' ]) !!}
				</div>
			</div>
			<hr>
			
			<div class="container">
				<h1> Buscar Producto </h1>
				<div class="row">
				   <div class="col-lg-4">
						 {{ Form::label ('codigo_barra', 'Codigo de Barra') }}
						 {!! Form::text( "codigo_barra" , null , ['class' => 'form-control' , 'placeholder' => 'Dirección', 'id'=>'codigo_barra' ]) !!}
						 <a href="#" id="BtnEnviar">Aceptar</a> 
						 <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
				   </div>
				   <div id="respuesta" class="col-lg-5">
				   </div>
				</div>
			 </div>

			
			<br>
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
@endsection