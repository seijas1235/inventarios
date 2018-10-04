$(document).ready(function() {

	$('#fecha').datetimepicker({
		format: 'DD-MM-YYYY',
		showClear: true,
		showClose: true
	});

	$("#cantidad").keypress(function(evt) {
		var charCode = (evt.which) ? evt.which : event.keyCode
		if (charCode < 48 || charCode > 57)  return false;
		return true;
	});

	$("input[name='codigo_barra']").focusout(function() {
		var codigo = $("input[name='codigo_barra'] ").val();
		var url = "/productos/get/?data=" + codigo;
		/*var url = "../pos_v2/productos/get/?data=" + codigo;*/
		$.getJSON( url , function ( result ) {
			if (result == 0 ) {
				$("input[name='nombre'] ").val("");
				$("input[name='producto_id'] ").val("");
			}
			else {
				$("input[name='nombre'] ").val(result[0].nombre);
				$("input[name='producto_id'] ").val(result[0].prod_id);
			}
		});
	});


	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});



	var validator = $("#submit-ingresoproducto").validate({
		ignore: [],
		onkeyup:false,
		rules: {
			fecha: {
				required : true
			},
			num_factura : {
				required : true
			},
			proveedor_id : {
				required : true,
			}

		},
		messages: {
			fecha : {
				required : "Por favor, seleccione la fecha de ingreso"
			},
			num_factura : {
				required : "Por favor, ingrese el numero de la factura"
			},
			proveedor_id : {
				required : "Por favor, seleccione al proveedor de la factura",
			}
		}
	});




});