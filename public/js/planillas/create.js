$(document).ready(function() {

	$('#fecha').datetimepicker({
		format: 'DD-MM-YYYY',
		showClear: true,
		showClose: true
	});


	/*$("input[name='empleado_id']").focusout(function() {
		var codigo = $("input[name='empleado_id'] ").val();
		var url = "/empleados/get/?data=" + codigo;
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
	});*/

	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});

	var validator = $("#submit-ingresoplanilla").validate({
		ignore: [],
		onkeyup:false,
		rules: {
			fecha: {
				required : true
			}
		},
		messages: {
			fecha : {
				required : "Por favor, seleccione la fecha de planilla"
			}
		}
	});

});