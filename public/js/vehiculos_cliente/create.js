$(document).ready(function() {

	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});
});

var validator = $("#VehiculoClienteForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		vehiculo_id: {
			required : true
		},

		cliente_id: {
			required : true
		}
	},
	messages: {
		vehiculo_id: {
			required: "Por favor, seleccione vehiuclo del cliente"
		},

		cliente_id: {
			required: "Por favor, seleccione cliente"
		}
	}
});


var db = {};

window.db = db;
db.detalle = [];

$("#ButtonCliente").click(function(event) {
	if ($('#VehiculoClienteForm').valid()) {
		saveContact();
	} else {
		validator.focusInvalid();
	}
});

function saveContact(button) {
	$("#ButtonCliente").attr('disabled', 'disabled');
	var l = Ladda.create(document.querySelector("#ButtonCliente"));
	l.start();
	var formData = $("#VehiculoClienteForm").serialize();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		url: "/vehiculos_cliente/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			window.location = "/vehiculos_cliente" 
		},
		always: function() {
			l.stop();
		},
		error: function() {
			alert("Ha ocurrido un problema, contacte a su administrador!!");
		}
		
	});
}