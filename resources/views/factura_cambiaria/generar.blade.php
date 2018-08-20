@extends('layouts.app')
@section('content')
<div id="content">
	<div class="container-custom">
		<!-- {!! Form::open(array('class' => 'form', 'id' => 'ProductoForm')) !!} -->
		{!! Form::open( array( 'id' => 'FacturaCForm') ) !!}
		<div class="row">
			<div class="col-sm-12">
				<h3 class="tittle-custom">Creación de Factura Cambiaria 
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
		<div class="row">
			<div class="col-lg-4">
				{!! Form::label("fecha_factura","Fecha:") !!}
				{!! Form::text( "fecha_factura" , null , ['class' => 'form-control' , 'placeholder' => 'Fecha de Factura', 'id' => 'fecha_factura']) !!}
			</div>
			<div class="col-lg-4">
				{!! Form::label("serie_id","Serie:") !!}
				<select class="selectpicker" id='serie_id' name="serie_id" value="" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione">
					@foreach ($series as $serie)
					<option value="{{$serie->id}}">{{$serie->serie}} </option>
					@endforeach
				</select>
			</div>
			<div class="col-lg-4">
				{!! Form::label("numero_factura","No. Factura:") !!}
				{!! Form::text( "numero_factura" , null , ['class' => 'form-control' , 'placeholder' => 'No. Factura', 'id' => 'numero_factura']) !!}
			</div>

			

		</div>
		<div class="row">
			<div class="col-lg-6">
				{!! Form::label("NIT","NIT:") !!}
				{!! Form::text( "nit" , $cliente->cl_nit, ['class' => 'form-control' , 'placeholder' => 'Nit', 'id' => ' nit']) !!}

			</div>
			<div class="col-lg-6">
				{!! Form::label("direccion","Dirección") !!}
				{!! Form::text( "direccion" , $cliente->cl_direccion , ['class' => 'form-control' , 'placeholder' => 'Fecha de Factura', 'id' => 'direccion']) !!}
			</div>
		</div>
		<hr>
		<div class="row">
			<table class="table text-center">
				<thead class="thead-inverse">
					<tr>
						<th>Producto</th>
						<th>Total</th> 
					</tr>
				</thead>
				<tbody>
					@foreach($records as $record) 
					<tr>
						@if ($record->tipo_producto_id == 2)
						<td> 
							{{App\combustible::find($record->combustible_id)->combustible}}
						</td>
						<td> Q.{{number_format($record->subtotal, 2)}} </td>

						@elseif ($record->tipo_producto_id == 	1)
						<td> 
							{{App\producto::find($record->producto_id)->nombre}}
						</td>
						<td> Q.{{number_format($record->subtotal, 2)}} </td>

						@endif
					</tr>
					@endforeach
				</tbody>
				
			</table>
		</div>
		<div class="row">
			<h3 class="text-center"> Q.{{$total}} </h3>
		</div>
		<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">

		<input type="hidden" name="cliente_id" id="cliente_id" value="{{ $cliente->id }}">

		<input type="hidden" name="selected" id="selected" value="{{ $valores }}">





		<div class="text-right m-t-15">
			{!! Form::input('submit', 'submit', 'Guardar', ['class' => 'btn btn-primary form-gradient-color form-button', 'id'=>'ButtonFCambiaria']) !!}
		</div>
		{!! Form::close() !!}
	</div>
</div>
<script>




$('#fecha_factura').datetimepicker({
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

var validator = $("#FacturaCForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		fecha_factura: {
			required : true,
		},
		numero_factura: {
			required : true,
			unicoNumero: true
		},
		serie_id: {
			required : true,
			unicoNumeroSerie: true
		},
		nit: {
			required : true,
		},
		direccion: {
			required : true,
		}

	},
	messages: {
		fecha_factura: {
			required: "Por favor, ingrese una fecha"
		},
		numero_factura: {
			required: "Por favor, ingrese un No. de Factura"
		},
		serie_id: {
			required: "Por favor, seleccione una serie",
			unicoNumeroSerie: "Seleccione otro número"
		},
		nit: {
			required: "Por favor, ingrese un NIT"
		},
		direccion: {
			required: "Por favor, ingrese una dirección"
		}
	}
});


$.validator.addMethod("unicoNumero", function(value, element) {
		var valid = false;
		var serie = $("#serie_id").val();
		$.ajax({
			type: "GET",
			async: false,
			url: "/factura-validation",
			data: "numero="+value + "&serie=" + serie,
			dataType:"json",
			success: function(msg)
			{
				valid = !msg;
			}
		});
		return valid;
	}, "Este número existe actualmente en el sistema");


$.validator.addMethod("unicoNumeroSerie", function(value, element) {
		var valid = false;
		var numero = $("#numero_factura").val();
		$.ajax({
			type: "GET",
			async: false,
			url: "/factura-validation",
			data: "numero="+numero + "&serie=" + value,
			dataType:"json",
			success: function(msg)
			{
				valid = !msg;
			}
		});
		return valid;
	}, " ");


$("#ButtonFCambiaria").click(function(event) {
	if ($('#FacturaCForm').valid()) {
		saveFactura();
	} else {
		validator.focusInvalid();
	}
});


function saveFactura(button) {
	$.LoadingOverlay("show");
	$("#ButtonFCambiaria").attr('disabled', 'disabled');
	var l = Ladda.create(document.querySelector("#ButtonFCambiaria"));
	l.start();
	// var direccion = $("input[name='direccion").val();
	// var numero_factura = $("input[name='numero_factura").val();
	// var serie_id = $("#serie_id").val();
	// var fecha_factura = $("input[name='fecha_factura").val();
	// var nit = $("input[name='nit").val();
	// var cliente_id = $("input[name='cliente_id").val();
	// var direccion = $("input[name='direccion").val();



	// var formData = {
	// 	direccion: direccion, 
	// 	numero_factura: numero_factura, 
	// 	serie_id: serie_id, 
	// 	fecha_factura : fecha_factura, 
	// 	nit: nit, 
	// 	cliente_id: cliente_id,
	// 	direccion: direccion
	// }

	var formData  = $("#FacturaCForm").serialize();

	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		url: "/factura_cambiaria/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			window.location = "/factura_cambiaria" 
		},
		always: function() {
			l.stop();
		},
		error: function() {
			$.LoadingOverlay("hide");
			alert("Something went wrong, please try again!");
		}
		
	});
}

</script>

@endsection
