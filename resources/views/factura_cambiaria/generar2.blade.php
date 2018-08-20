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
						Galones de Gasolina Super
					</div>
					<div class="col-lg-3">
						{!! Form::number( "super" , $precio_super , ['class' => 'form-control' , 'placeholder' => '0.00' ]) !!}
					</div>
					<div class="col-lg-3">    
						{!! Form::number( "galones_super" , null , ['class' => 'form-control' , 'placeholder' => '0.00' ]) !!} 
					</div>
					<div class="col-lg-3">
						{!! Form::number( "total_super" , null , ['class' => 'form-control' , 'placeholder' => '0.00', 'disabled' => true ]) !!}
					</div>
					<div class="col-lg-3">
						Galones de Gasolina Diesel
					</div>
					<div class="col-lg-3">
						{!! Form::number( "disel" , $precio_disel , ['class' => 'form-control' , 'placeholder' => '0.00' ]) !!}
					</div>
					<div class="col-lg-3">

						{!! Form::number( "galones_disel" , null , ['class' => 'form-control' , 'placeholder' => '0.00' ]) !!}
					</div>
					<div class="col-lg-3">
						{!! Form::number( "total_disel" , null , ['class' => 'form-control' , 'placeholder' => '0.00', 'disabled' => true ]) !!}
					</div>
					<div class="col-lg-3">
						Galones de Gasolina Regular
					</div>
					<div class="col-lg-3">
						{!! Form::number( "regular" , $precio_regular, ['class' => 'form-control' , 'placeholder' => '0.00' ]) !!}</div>
						<div class="col-lg-3">

							{!! Form::number( "galones_regular" , null , ['class' => 'form-control' , 'placeholder' => '0.00' ]) !!}

						</div>
						<div class="col-lg-3">
							{!! Form::number( "total_regular" , null , ['class' => 'form-control' , 'placeholder' => '0.00', 'disabled' => true ]) !!}
						</div>
						<br>
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

				<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">

				<input type="hidden" name="cliente_id" id="cliente_id" value="{{ $cliente->id }}">



			</br>

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
				url: "/factura-validation/",
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
				url: "/factura-validation/",
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

			var has_super =true;
			var has_regular = true;
			var has_disel = true;

			var cliente_id = $("#cliente_id").val();
			var monto = $("input[name='total").val();
			var galones_super = $("input[name='galones_super").val();
			if (galones_super == 0 || galones_super == null) {
				var has_super = false;
			}

			var total_super = $("input[name='total_super").val();
			var total_regular = $("input[name='total_regular").val();


			var galones_regular = $("input[name='galones_regular").val();
			if (galones_regular == 0 || galones_regular == null) {
				var has_regular = false;
			}

			var total_disel = $("input[name='total_disel").val();
			var galones_disel = $("input[name='galones_disel").val();
			if (galones_disel == 0 || galones_disel == null) {
				var has_disel = false;
			}


			var detalle = [];


			if (has_super) {
				detalle.push({ combustible_id: 5, cantidad: galones_super, subtotal: total_super});
			}
			if (has_regular) {
				detalle.push({ combustible_id: 6, cantidad: galones_regular, subtotal: total_regular});
			}
			if (has_disel) {
				detalle.push({ combustible_id: 4, cantidad: galones_disel, subtotal: total_disel});
			}

			var l = Ladda.create(document.querySelector("#ButtonFCambiaria"));
			l.start();

			var numero_factura = $("input[name='numero_factura").val();
			var serie_id = $("#serie_id").val();
			var fecha_factura = $("input[name='fecha_factura").val();
			var nit = $("input[name='nit").val();
			var cliente_id = $("input[name='cliente_id").val();
			var direccion = $("input[name='direccion").val();
			var total = $("input[name='total").val();


			var formData = {
				total: total,
				detalle : detalle,
				direccion: direccion, 
				numero_factura: numero_factura, 
				serie_id: serie_id, 
				fecha_factura : fecha_factura, 
				nit: nit, 
				cliente_id: cliente_id,
				direccion: direccion
			} 


			$.ajax({
				type: "POST",
				headers: {'X-CSRF-TOKEN': $('#token').val()},
				url: "/factura_cambiaria/save2",
				data: formData,
				dataType: "json",
				success: function(data) {
					window.location = "/factura_cambiaria" 
				},
				always: function() {
					l.stop();
				},
				error: function() {
					alert("Something went wrong, please try again!");
				}

			});
		}

		$("input[name='galones_super").change(function () {


			var old_total = $("input[name='total']").val();
			var precio = $("input[name='super']").val();

			if (old_total > 0) {
				$("input[name='total']").val(old_total - $("input[name='total_super']").val());
			}


			$("input[name='total_super']").val(precio * $("input[name='galones_super").val());

			var total = parseInt($("input[name='total']").val());

			$("input[name='total']").val(total +  parseInt($("input[name='total_super']").val()));


		});


		$("input[name='super").change(function () {


			var old_total = $("input[name='total']").val();
			var galones = $("input[name='galones_super']").val();

			if (old_total > 0) {
				$("input[name='total']").val(old_total - $("input[name='total_super']").val());
			}


			$("input[name='total_super']").val(galones * $("input[name='super").val());

			var total = parseInt($("input[name='total']").val());

			$("input[name='total']").val(total +  parseInt($("input[name='total_super']").val()));


		});




		$("input[name='galones_regular").change(function () {

			var old_total = $("input[name='total']").val();
			var precio = $("input[name='regular']").val();

			if (old_total > 0) {
				$("input[name='total']").val(old_total - $("input[name='total_regular']").val());
			}


			$("input[name='total_regular']").val(precio * $("input[name='galones_regular").val());

			var total = parseInt($("input[name='total']").val());

			$("input[name='total']").val(total +  parseInt($("input[name='total_regular']").val()));

		});



		$("input[name='regular").change(function () {

			var old_total = $("input[name='total']").val();
			var regular = $("input[name='galones_regular']").val();

			if (old_total > 0) {
				$("input[name='total']").val(old_total - $("input[name='total_regular']").val());
			}


			$("input[name='total_regular']").val(regular * $("input[name='regular").val());

			var total = parseInt($("input[name='total']").val());

			$("input[name='total']").val(total +  parseInt($("input[name='total_regular']").val()));

		});



		$("input[name='galones_disel").change(function () {
			var old_total = $("input[name='total']").val();
			var precio = $("input[name='disel']").val();


			if (old_total > 0) {
				$("input[name='total']").val(old_total - $("input[name='total_disel']").val());
			}

			$("input[name='total_disel']").val(precio * $("input[name='galones_disel").val());

			var total = parseInt($("input[name='total']").val());

			$("input[name='total']").val(total +  parseInt($("input[name='total_disel']").val()));

		});


		$("input[name='disel").change(function () {
			var old_total = $("input[name='total']").val();
			var disel = $("input[name='galones_disel']").val();


			if (old_total > 0) {
				$("input[name='total']").val(old_total - $("input[name='total_disel']").val());
			}

			$("input[name='total_disel']").val(disel * $("input[name='galones_disel").val());

			var total = parseInt($("input[name='total']").val());

			$("input[name='total']").val(total +  parseInt($("input[name='total_disel']").val()));

		});

	</script>

	@endsection
