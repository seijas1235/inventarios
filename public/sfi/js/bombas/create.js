$(document).ready(function() {

	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});
});




var validator = $("#BombaForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		bomba: {
			required : true,
		},
		combustible_id: {
			required : true,
		}
	},
	messages: {
		bomba: {
			required: "Por favor, ingrese un identificador para la bomba"
		},
		combustible_id: {
			required: "Por favor seleccione un combustible"
		}
	}
});


var db = {};

window.db = db;
db.detalle = [];

$("#ButtonBomba").click(function(event) {
	if ($('#BombaForm').valid()) {
		saveContact();
	} else {
		validator.focusInvalid();
	}
});

function saveContact(button) {
	$("#ButtonBomba").attr('disabled', 'disabled');
	var l = Ladda.create(document.querySelector("#ButtonBomba"));
	l.start();
	var formData = $("#BombaForm").serialize();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		url: "/sfi/bombas/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			window.location = "/sfi/bombas" 
		},
		always: function() {
			l.stop();
		},
		error: function() {
			alert("Un error ha ocurrido, ´por favoor contacte a su administrador!");
		}
		
	});
}