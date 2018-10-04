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
		$.getJSON( url , function ( result ) {
			if (result == 0 ) {
				$("input[name='nombre'] ").val("");
				$("input[name='codigo_barra'] ").val("");
				console.log(result);
			}
			else {
				$("input[name='nombre']").val(result[0].nombre);
				$("input[name='codigo_barra'] ").val(result[0].codigo_barra);
				console.log(result);
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

	var validator = $("#CompraForm").validate({
		ignore: [],
		onkeyup:false,
		rules: {
			fecha: {
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
			proveedor_id : {
				required : "Por favor, seleccione al proveedor de la factura",
			}
		}
	});

});