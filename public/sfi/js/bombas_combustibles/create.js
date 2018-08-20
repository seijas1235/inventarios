$(document).ready(function() {

	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});
});




var validator = $("#BombaCombustibleForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		bomba_id: {
			required : true,
		},
		combustible_id: {
			required : true,
		}
	},
	messages: {
		bomba_id: {
			required: "Por favor, seleccione una bomba"
		},
		combustible_id: {
			required: "Por favor seleccione un combustible"
		}
	}
});


var db = {};

window.db = db;
db.detalle = [];

$("#ButtonBombaCombustible").click(function(event) {
	if ($('#BombaCombustibleForm').valid()) {
		saveContact();
	} else {
		validator.focusInvalid();
	}
});

function saveContact(button) {
	$("#ButtonBombaCombustible").attr('disabled', 'disabled');
	var l = Ladda.create(document.querySelector("#ButtonBombaCombustible"));
	l.start();
	var formData = $("#BombaCombustibleForm").serialize();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		url: "/sfi/bombas_combustibles/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			window.location = "/sfi/bombas_combustibles" 
		},
		always: function() {
			l.stop();
		},
		error: function() {
			alert("Un error ha ocurrido, ´por favoor contacte a su administrador!");
		}
		
	});
}