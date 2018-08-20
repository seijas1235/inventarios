@extends('layouts.app')
@section('content')
<div id="content">
	<div class="container-custom">
		{!! Form::open( array( 'id' => 'CorteCForm') ) !!}
		<div class="row">
			<div class="col-sm-12">
				<h2 class="tittle-custom"> Corte de Caja </h2>
				<line>
				</div>
			</div>
			<hr>
			<h4 class="tittle-custom"> Venta de Lubricantes </h4>
			<br>
			<div class="row">
				<div class="col-lg-4">
					{!! Form::label("lubricantes","Total de Lubricantes:") !!}
					{!! Form::text( "lubricantes" , 0 , ['class' => 'form-control' , 'placeholder' => 'Total de Lubricantes', 'id' => 'lubricantes']) !!}
				</div>
				<div class="col-lg-4">
					{!! Form::label("codigo_corte","Código Corte:") !!}
					{!! Form::number( "codigo_corte" , $cod, ['class' => 'form-control' , 'placeholder' => '0.00', 'disabled' => true ]) !!}
				</div>
				<div class="col-sm-4">
					{!! Form::label("fecha_corte","Fecha Corte:") !!}
					{!! Form::text( "fecha_corte" , null , ['class' => 'form-control' , 'placeholder' => 'Fecha Corte' ]) !!}
				</div>
			</div>
			<hr>
			<h4 class="tittle-custom"> Venta de Combustibles según Fusion</h4>
			<br>
			<div class="row">
				<div class="col-lg-12">
					<strong>
						<div class="col-lg-3">
							Tipo de Combustible
						</div>
						<div class="col-lg-3">
							
						</div>
						<div class="col-lg-3">
							Cantidad de Galones
						</div>
						<div class="col-lg-3">
							Total
						</div>
					</strong>
					<br>
					<br>


					<div class="col-lg-3">
						Super
					</div>
					<div class="col-lg-3">
						
					</div>
					<div class="col-lg-3">    
						{!! Form::number( "gal_super" , null , ['class' => 'form-control' , 'placeholder' => '0.00' ]) !!} 
					</div>
					<div class="col-lg-3">
						{!! Form::number( "total_super" , null , ['class' => 'form-control' , 'placeholder' => '0.00' ]) !!}
					</div>


					<div class="col-lg-3">
						Regular
					</div>
					<div class="col-lg-3">
						
					</div>
					<div class="col-lg-3">
						{!! Form::number( "gal_regular" , null , ['class' => 'form-control' , 'placeholder' => '0.00' ]) !!}
					</div>
					<div class="col-lg-3">
						{!! Form::number( "total_regular" , null , ['class' => 'form-control' , 'placeholder' => '0.00' ]) !!}
					</div>


					<div class="col-lg-3">
						Diesel
					</div>
					<div class="col-lg-3">
						
					</div>
					<div class="col-lg-3">
						{!! Form::number( "gal_diesel" , null , ['class' => 'form-control' , 'placeholder' => '0.00' ]) !!}
					</div>
					<div class="col-lg-3">
						{!! Form::number( "total_diesel" , null , ['class' => 'form-control' , 'placeholder' => '0.00' ]) !!}
					</div>

					<div class="col-lg-3">
						Totales
					</div>
					<div class="col-lg-3">
						
					</div>
					<div class="col-lg-3">
						{!! Form::number( "galones" , null , ['class' => 'form-control' , 'placeholder' => '0.00', 'disabled' => true ]) !!}
					</div>
					<div class="col-lg-3">
						{!! Form::number( "combustible" , null , ['class' => 'form-control' , 'placeholder' => '0.00', 'disabled' => true ]) !!}
					</div>
					<br>
				</div>
			</div>
			<br>
			<hr>
			<h4 class="tittle-custom"> Ventas del Turno</h4>
			<br>
			<div class="row">
				<div class="col-lg-3">
					{!! Form::label("deposito_grande","Depósito Grande:") !!}
					{!! Form::number( "deposito_grande" , 0 , ['class' => 'form-control' , 'placeholder' => '0.00' ]) !!}
				</div>
				<div class="col-lg-3">
					{!! Form::label("deposito_colas","Depósito Colas:") !!}
					{!! Form::number( "deposito_colas" , 0 , ['class' => 'form-control' , 'placeholder' => '0.00' ]) !!}
				</div>
				<div class="col-lg-3">
					{!! Form::label("deposito_posterior","Depósito Posterior:") !!}
					{!! Form::number( "deposito_posterior" , 0 , ['class' => 'form-control' , 'placeholder' => '0.00' ]) !!}
				</div>
				<div class="col-lg-3">
					{!! Form::label("total_efectivo","Total Efectivo:") !!}
					{!! Form::number( "total_efectivo" , 0 , ['class' => 'form-control' , 'placeholder' => '0.00', 'disabled' => true ]) !!}
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-lg-3">
					@foreach ($vales as $vale)
					{!! Form::label("vales","Vales:") !!}
					{!! Form::number( "vales" , $vale->Tot_Vale, ['class' => 'form-control' , 'placeholder' => '0.00', 'disabled' => true ]) !!}
					@endforeach
				</div>
				<div class="col-lg-3">
					@foreach ($vouchers as $vou)
					{!! Form::label("tarjeta","Tarjeta VISA:") !!}
					{!! Form::number( "tarjeta" , $vou->Tot_Voucher , ['class' => 'form-control' , 'placeholder' => '0.00', 'disabled' => true ]) !!}
					@endforeach
				</div>
				<div class="col-lg-3">
					@foreach ($gastos as $gasto)
					{!! Form::label("gastos","Gastos:") !!}
					{!! Form::number( "gastos" , $gasto->Tot_Gasto , ['class' => 'form-control' , 'placeholder' => '0.00', 'disabled' => true ]) !!}
					@endforeach
				</div>
				<div class="col-lg-3">
					@foreach ($anticipos as $anti)
					{!! Form::label("anticipo_empleado","Anticipos a Empleados:") !!}
					{!! Form::number( "anticipo_empleado" , $anti->Tot_anti , ['class' => 'form-control' , 'placeholder' => '0.00', 'disabled' => true ]) !!}
					@endforeach
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-lg-3">
					{!! Form::label("gastos_bg","Gastos BG:") !!}
					{!! Form::number( "gastos_bg" , $total_gastos_bg , ['class' => 'form-control' , 'placeholder' => '0.00', 'disabled' => true ]) !!}
				</div>
				<div class="col-lg-3">
					@foreach ($faltantes as $falta)
					{!! Form::label("faltantes","Faltantes Efectivo:") !!}
					{!! Form::number( "faltantes" , $falta->Tot_falta , ['class' => 'form-control' , 'placeholder' => '0.00', 'disabled' => true ]) !!}
					@endforeach
				</div>
				<div class="col-lg-3">
					{!! Form::label("devoluciones","Devoluciones:") !!}
					{!! Form::number( "devoluciones" , 0 , ['class' => 'form-control' , 'placeholder' => '0.00' ]) !!}
				</div>
				<div class="col-lg-3">
					{!! Form::label("calibraciones","Calibraciones:") !!}
					{!! Form::number( "calibraciones" , 0 , ['class' => 'form-control' , 'placeholder' => '0.00' ]) !!}
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-lg-3">
					@foreach ($cupones as $cupon)
					{!! Form::label("cupones","Cupones PUMA:") !!}
					{!! Form::number( "cupones" , $cupon->Tot_cup , ['class' => 'form-control' , 'placeholder' => '0.00', 'disabled' => true ]) !!}
					@endforeach
				</div>
				<div class="col-lg-3">
				</div>
				<div class="col-lg-3">
				</div>
				<div class="col-lg-3">
				</div>
			</div>
			<hr>
			<h4 class="tittle-custom"> Resultado Corte de Caja </h4>
			<br>
			<div class="row">
				<div class="col-lg-4">
					{!! Form::label("total_ventas","Total Ventas:") !!}
					{!! Form::number( "total_ventas" , null , ['class' => 'form-control' , 'placeholder' => '0.00', 'disabled' => true ]) !!}
				</div>
				<div class="col-lg-4">
				</div>
				<div class="col-lg-4">
					{!! Form::label("total_ventas_turno","Total Ventas del Turno:") !!}
					{!! Form::number( "total_ventas_turno" , $total_venta , ['class' => 'form-control' , 'placeholder' => '0.00', 'disabled' => true ]) !!}
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-lg-4">
					{!! Form::label("resultado_turno","Resultado Turno:") !!}
					{!! Form::text( "resultado_turno" , null , ['class' => 'form-control' , 'placeholder' => '0.00', 'disabled' => true ]) !!}
				</div>
				<div class="col-lg-4">
				</div>
				<div class="col-lg-4">
					{!! Form::label("resultado_q","Resultado Turno Q:") !!}
					{!! Form::number( "resultado_q" , null , ['class' => 'form-control' , 'placeholder' => '0.00', 'disabled' => true ]) !!}
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-lg-12">
					{!! Form::label("observaciones","Observaciones:") !!}
					{!! Form::text( "observaciones" , null , ['class' => 'form-control' , 'placeholder' => 'Ingresar números de boleta de depósito' ]) !!}
				</div>
			</div>
		</div>
		<br>
	</br>
	<div class="text-right m-t-15">
		<a class='btn btn-primary form-gradient-color form-button' href="{{ url('/corte_caja') }}">Regresar</a>

		<a class='btn-add-new-record btn btn-success btn-title border-radius btn-calcular'">Calcular</a>

		{!! Form::input('submit', 'submit', 'Guardar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonCorte']) !!}
	</div>
	<br>
	<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
</br>
{!! Form::close() !!}
</div>
</div>

@endsection
@section('scripts')
{!! HTML::script('/../../sfi_tecu/sfi/js/corte_caja/create.js') !!}
@endsection