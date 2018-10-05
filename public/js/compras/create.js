$(document).ready(function() {

	$('#fecha_factura').datetimepicker({
		format: 'DD-MM-YYYY',
		showClear: true,
		showClose: true
	});

	$('#fecha_ingreso').datetimepicker({
		format: 'DD-MM-YYYY',
		showClear: true,
		showClose: true
	});


	$("#cantidad_ingreso").keypress(function(evt) {
		var charCode = (evt.which) ? evt.which : event.keyCode
		if (charCode < 48 || charCode > 57)  return false;
		return true;
	});

	/*$("input[name='codigo_barra']").bind("enterKey",function(e){
		var codigo = $("input[name='codigo_barra'] ").val();
		var url = "/productos/get/?data=" + codigo;
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
		$("input[name='cantidad']").focus();
	 });

	 $("input[name='codigo_barra']").keyup(function(e){
		 if(e.keyCode == 13)
		 {
			 $(this).trigger("enterKey");
		 }
	 });*/

	$("input[name='codigo_barra']").focusout(function() {
		var codigo = $("input[name='codigo_barra'] ").val();
		var url = "/productos/get/?data=" + codigo;
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
			fecha_ingreso: {
				required : true
			},
			serie_factura : {
				required : true
			},
			num_factura : {
				required : true
			},
			fecha_factura : {
				required : true
			},
			proveedor_id : {
				required : true,
			}

		},
		messages: {
			fecha_ingreso : {
				required : "Por favor, seleccione la fecha de ingreso"
			},
			serie_factura : {
				required : "Por favor, ingrese la serie de la factura"
			},
			num_factura : {
				required : "Por favor, ingrese el numero de la factura"
			},
			fecha_factura : {
				required : "Por favor, seleccione la fecha de la factura"
			},
			proveedor_id : {
				required : "Por favor, seleccione al proveedor de la factura",
			}
		}
	});

});