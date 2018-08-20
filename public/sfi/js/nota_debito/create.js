$(document).ready(function() {

	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});
});


var validator = $("#NotasDebitosForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		fecha: {
			required : true,
		},
		cliente_id: {
			required : true
		},
		total: {
			required : true
		},
		descripcion: {
			required: true
		}
	},
	messages: {
		fecha: {
			required: "Por favor, seleccione una fecha"
		},
		cliente_id: {
			required : "Por favor, seleccione un cliente"
		},
		total: {
			required : "Por favor, ingrese un total de la nota de crédito"
		},
		descripcion: {
			required: "Por favor, ingrese una observación o razón de porque se genera la nota de crédito"
		}
	}
});


$('#fecha').datetimepicker({
    format: 'YYYY-MM-DD',
    showClear: true,
    showClose: true
});


var db = {};

window.db = db;
db.detalle = [];

$("#ButtonNotasDebitos").click(function(event) {
	if ($('#NotasDebitosForm').valid()) {
		saveContact();
	} else {
		validator.focusInvalid();
	}
});

function saveContact(button) {
	$("#ButtonNotasDebitos").attr('disabled', 'disabled');
	var l = Ladda.create(document.querySelector("#ButtonNotasDebitos"));
	l.start();
	var formData = $("#NotasDebitosForm").serialize();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		url: "/sfi_tecu/nota_debito2/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			window.location = "/sfi_tecu/nota_debito2" 
		},
		always: function() {
			l.stop();
		},
		error: function() {
			alert("Un error ha ocurrido, por favor contacte a su administrador!");
		}
		
	});
}