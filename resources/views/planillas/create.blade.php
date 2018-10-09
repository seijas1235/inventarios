@extends('layouts.app')
@section('content')
<div id="content">
	<div class="container-custom">
		<div class="row">
			<div class="col-sm-12">
				<h3 class="tittle-custom"> Creación de Planilla </h3>
				<line>
				</div>
		</div>
			<br>
			<div class="row">
				<div class="col-sm-3">
					{!! Form::label("fecha","Fecha:") !!}
					{!! Form::text( "fecha" , null , ['class' => 'form-control' , 'placeholder' => 'Fecha', 'id' => 'fecha' ]) !!}
				</div>
			</div>	
			<br>

			<hr>
			<div class="row">
				<div class="col-sm-3">
					{!! Form::label("Codigo","Codigo de empleado:") !!}
					{!! Form::text( "empleado_id" , null , ['class' => 'form-control' , 'placeholder' => 'Codigo Empleado' ]) !!}
					{!! Form::hidden("subtotal" , null , ['class' => 'form-control' , 'disabled']) !!}
				</div>

				<div class="col-sm-3">
					{!! Form::label("nombre","Nombres") !!}
					{!! Form::text( "nombre" , null , ['class' => 'form-control' , 'disabled','placeholder' => 'Nombres' ]) !!}
				</div>

				<div class="col-sm-3">
					{!! Form::label("apellido","Apellidos:") !!}
					{!! Form::text( "apellido" , null , ['class' => 'form-control' ,'disabled', 'placeholder' => 'Apellidos' ]) !!}
				</div>

				<div class="col-sm-3">
					{!! Form::label("sueldo","Sueldo:") !!}
					{!! Form::text( "sueldo" , null , ['class' => 'form-control' ,'disabled', 'placeholder' => 'SUeldo' ]) !!}
				</div>

			</div>
			<br>

			<div class="row">
				<div class="col-sm-3">
					{!! Form::label("horas_extra","Horas Extra:") !!}
					{!! Form::text( "horas_extra" , null , ['class' => 'form-control' , 'placeholder' => 'Horas Extra' ]) !!}
				</div>
				<div class="col-sm-3">
					{!! Form::label("monto_hora_extra","Monto Horas Extra:") !!}
					{!! Form::text( "monto_hora_extra" , null , ['class' => 'form-control' , 'placeholder' => 'Monto' ]) !!}
				</div>
				<div class="col-sm-3">
					{!! Form::label("igss","IGSS:") !!}
					{!! Form::text( "igss" , null , ['class' => 'form-control' , 'placeholder' => 'IGSS' ]) !!}
				</div>
				<div class="col-sm-3">
					{!! Form::label("isr","ISR:") !!}
					{!! Form::text( "isr" , null , ['class' => 'form-control' , 'placeholder' => 'ISR' ]) !!}
				</div>				

			</div>

			<br>
	
				<div class="text-right m-t-15">
					{!! Form::button('Agregar Nuevo Empleado' , ['class' => 'btn btn-success' ,'id' => 'addDetalle', 'data-loading-text' => 'Processing...' ]) !!}
				</div>				
			<br>
			<hr>

			<div id="planilla-grid">

			</div>
			<br>
			<div class="col-sm-4" id="total">
				<h3>{!! Form::label("total","Total:") !!}</h3>
				{!! Form::text( "total" , null, ['class' => 'form-control', 'id' => 'total', 'disabled']) !!}
			</div>
			<div class="text-right m-t-15">
				<a class='btn btn-primary form-gradient-color form-button' href="{{ url('/planillas') }}">Regresar</a>
				{!! Form::submit('Registrar Planilla' , ['class' => 'btn btn-success btn-submit-ingresoplanilla', 'id' => 'ButtonDetalle', 'data-loading-text' => 'Processing...' ]) !!}
			</div>
			<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
		<br>
	</div>
</div>

@endsection

@section('scripts')

{!! HTML::script('/js/planillas/create.js') !!}
{!! HTML::script('/js/planillas/grid.js') !!}

@endsection