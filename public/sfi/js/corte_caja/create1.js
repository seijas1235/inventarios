$(".corte-button").click(function(event) {
	if ($('#CodCorteForm').valid()) {
		event.preventDefault();
		var codigo = $('input[name="codigo_corte"]').val();
		window.location = String("/sfi_tecu/corte_caja_get?codigo="+ codigo);
	} else {
		validator.focusInvalid();
	}

});


$.validator.addMethod("corteunico", function(value, element) {
	var valid = false;
	$.ajax({
		type: "GET",
		async: false,
		url: "/sfi_tecu/corte-disponible",
		data: "codigocorte=" + value,
		dataType: "json",
		success: function(msg) {
			valid = !msg;
		}
	});
	return valid;
}, "El codigo de corte diario ya existe; ingrese un codigo para iniciar el corte diario, que no haya sido creado antes");




var validator = $("#CodCorteForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		codigo_corte: {
			required : true,
			corteunico:true,
		}
	},
	messages: {
		codigo_corte: {
			required : "Por favor, ingrese un codigo para iniciar el corte diario, que no haya sido creado antes"
		}
	}
});