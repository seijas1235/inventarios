@extends('layouts.app')
@section('content')
<div id="content">
	<div class="container-custom">
		<!-- {!! Form::open(array('class' => 'form', 'id' => 'ProductoForm')) !!} -->
		{!! Form::open( array( 'id' => 'ReciboCForm') ) !!}
		<div class="row">
			<div class="col-sm-12">
				<h3 class="tittle-custom">Creación de Recibo de Caja 
				</h3>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-lg-6">
				<h4>Cliente:{{$cliente->cl_nombres}} {{$cliente->cl_apellidos}} </h4>
			</div>
			<div class="col-lg-6">
				<h4>User:{{$user->name}} </h4>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-lg-3">
				{!! Form::label("NIT","NIT:") !!}
				{!! Form::text( "nit" , $cliente->cl_nit, ['class' => 'form-control' , 'placeholder' => 'Nit', 'id' => ' nit']) !!}
			</div>
			<div class="col-lg-3">
				{!! Form::label("no_recibo_caja","No Recibo de Caja") !!}
				{!! Form::text( "no_recibo_caja" , null , ['class' => 'form-control']) !!}
			</div>
			<div class="col-lg-3">
				{!! Form::label("monto","Monto") !!}
				{!! Form::text( "monto" , $total , ['class' => 'form-control', 'disabled']) !!}
			</div>
			<div class="col-lg-3">
				{!! Form::label("fecha_recibo","Fecha Recibo:") !!}
				{!! Form::text( "fecha_recibo" , null , ['class' => 'form-control' , 'placeholder' => 'Fecha de Recibo', 'id' => 'fecha_recibo']) !!}
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-lg-4">
				{!! Form::label("tipo","Tipo Transacción:") !!}
				<select class="selectpicker" id='tipo_pago_id' name="tipo_pago_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
					@foreach ($tipos_pagos as $tipo_pago)
					<option value="{{$tipo_pago->id}}">{{$tipo_pago->tipo_pago}} </option>
					@endforeach
				</select>
			</div>
			<div class="col-lg-4">
				{!! Form::label("banco_id","Banco:") !!}
				<select class="selectpicker" id='banco_id' name="banco_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
					@foreach ($bancos as $banco)
					<option value="{{$banco->id}}">{{$banco->nombre}} </option>
					@endforeach
				</select>
			</div>
			<div class="col-lg-4">
				{!! Form::label("Cheque","No. Documento:") !!}
				{!! Form::number( "cheque" , "", ['class' => 'form-control' , 'placeholder' => 'No Documento', 'id' => ' cheque']) !!}
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-lg-4">
				{!! Form::label("saldo_anterior","Saldo Anterior:") !!}
				{!! Form::number( "saldo_anterior" , $saldo_anterior, ['class' => 'form-control' , 'placeholder' => '', 'id' => ' saldo_anterior', 'disabled']) !!}

			</div>
			<div class="col-lg-4">
				{!! Form::label("saldo_actual","Saldo Actual:") !!}
				{!! Form::number( "saldo_actual" , $saldo_actual, ['class' => 'form-control' ,   'disabled']) !!}
			</div>
			<div class="col-lg-4">
				{!! Form::label("total_pagado","Total Pagado:") !!}
				{!! Form::number( "total_pagado" , $total_pagado, ['class' => 'form-control']) !!}
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-sm-12">
				{!! Form::label("observaciones","Observaciones:") !!}
				{!! Form::text( "observaciones" , null , ['class' => 'form-control' , 'placeholder' => 'Observaciones' ]) !!}
			</div>
		</div>
		<hr>
		<div class="container">
			<div class="row">
				<table class="table text-center">
					<thead class="thead-inverse">
						<tr>
							<th>Vales </th>
							<th>Total</th> 
						</tr>
					</thead>
					<tbody>
						@foreach($valecitos as $vale) 
						<tr>
							<td> {{$vale->id }} </td>
							<td> Q.{{number_format($vale->total_por_pagar, 2)}} </td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
		<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
		<input type="hidden" name="cliente_id" id="cliente_id" value="{{ $cliente->id }}">
		<input type="hidden" name="selected" id="selected" value="{{ $valores }}">
		<input type="hidden" name="monto" id="monto" value="{{ $total }}">
		<input type="hidden" name="saldo_anterior" id="saldo_anterior" value="{{ $saldo_anterior }}">
		<input type="hidden" name="saldo_actual" id="saldo_actual" value="{{ $saldo_actual }}">
		<input type="hidden" name="total_recibo" id="total_recibo" value="{{ $total_pagado }}">
		<input type="hidden" name="isCheque" id="isCheque" value="">
		<div class="text-right m-t-15">
			{!! Form::input('submit', 'submit', 'Guardar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonFCambiaria']) !!}
		</div>
		{!! Form::close() !!}
	</div>
</div>
<script>


	$('#fecha_recibo').datetimepicker({
		format: 'DD-MM-YYYY',
		showClear: true,
		showClose: true
	});


	$(document).ready(function() {

		$(document).on("keypress", 'form', function (e) {
			var code = e.keyCode || e.which;
			if (code == 13) {
				e.preventDefault();
				return false;
			}
		});
	});



	$.validator.addMethod("recibounico", function(value, element) {
		var valid = false;
		$.ajax({
			type: "GET",
			async: false,
			url: "/sfi/recibo-disponible",
			data: "no_recibo_caja=" + value,
			dataType: "json",
			success: function(msg) {
				valid = !msg;
			}
		});
		return valid;
	}, "El No de Recibo de Caja ya fue ingresado antes, ingrese un numero de recibo que no se haya registrado");



	var validator = $("#ReciboCForm").validate({
		ignore: [],
		onkeyup:false,
		rules: {
			fecha_recibo: {
				required : true,
			},
			cheque: {
				required : {
					depends: function(element) 
					{
						return  ($("#tipo_pago_id").val() != 1); 
					}
				}
			},
			tipo_pago_id : {
				required : true,
			},
			banco_id: {
				required : {
					depends: function(element) 
					{
						return ($("#tipo_pago_id").val() != 1); 
					}
				}
			},
			nit: {
				required : true,
			}, 
			no_recibo_caja: {
				required : true,
				recibounico: true
			}, 
			total_pagado : {
				max :  (parseFloat($("#total_recibo").val()))
			}


		},
		messages: {
			fecha_recibo: {
				required: "Por favor, ingrese una fecha"
			},
			cheque: {
				required: "Por favor, ingrese un No. de Documento"
			},
			banco_id: {
				required: "Por favor, seleccione un banco"
			},
			nit: {
				required: "Por favor, ingrese un NIT"
			},
			no_recibo_caja: {
				required: "Por favor, ingrese el numero de recibo de caja"
			},
			total_pagado : {
				max: "El valor a pagar sobrepasa el total del recibo"
			}
		}
	});


	$("#ButtonFCambiaria").click(function(event) {
		if ($('#ReciboCForm').valid()) {
			saveFactura();
		} else {
			validator.focusInvalid();
		}
	});


	function saveFactura(button) {
		$("#ButtonFCambiaria").attr('disabled', 'disabled');


		var l = Ladda.create(document.querySelector("#ButtonFCambiaria"));
		l.start();

		var formData  = $("#ReciboCForm").serialize();
		$.LoadingOverlay("show");
		$.ajax({
			type: "POST",
			headers: {'X-CSRF-TOKEN': $('#token').val()},
			url: "/sfi/recibo_caja/save",
			data: formData,
			dataType: "json",
			success: function(data) {
				window.location = "/sfi/recibo_caja" 
			},
			always: function() {
				l.stop();
				$.LoadingOverlay("hide");
			},
			error: function() {
				alert("Something went wrong, please try again!");
			}

		});
	}

</script>

@endsection