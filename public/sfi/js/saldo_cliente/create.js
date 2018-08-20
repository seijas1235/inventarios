$(document).ready(function() {

	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});
});


var validator = $("#SaldosClientesForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		mes_id: {
			required : true,
		},
		cliente_id: {
			required : true
		},
		saldo: {
			required : true,
		}
	},
	messages: {
		mes_id: {
			required: "Por favor, seleccione un mes"
		},
		cliente_id: {
			required : "Por favor, seleccione un cliente"
		},
		saldo: {
			required : "Por favor, ingrese el saldo para el cliente y mes seleccionado"
		}
	}
});



var db = {};

window.db = db;
db.detalle = [];


$("#ButtonSaldosClientes").click(function(event) {
	if ($('#SaldosClientesForm').valid()) {
		saveContact();
	} else {
		validator.focusInvalid();
	}
});



function saveContact(button) {
	$("#ButtonSaldosClientes").attr('disabled', 'disabled');
	var l = Ladda.create(document.querySelector("#ButtonSaldosClientes"));
	l.start();
	var formData = $("#SaldosClientesForm").serialize();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		url: "/sfi/saldos_clientes/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			window.location = "/sfi/saldos_clientes" 
		},
		always: function() {
			l.stop();
		},
		error: function() {
			alert("Ha ocurrido un error, contacte a su administrador");
		}
	});
}