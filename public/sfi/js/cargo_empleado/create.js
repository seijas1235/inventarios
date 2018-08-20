$(document).ready(function() {

	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});
});

var validator = $("#CEForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		cargo_empleado: {
			required : true,
		}
	},
	messages: {
		cargo_empleado: {
			required: "Por favor, ingrese un cargo_empleado"
		}
	}
});


var db = {};

window.db = db;
db.detalle = [];

$("#ButtonCE").click(function(event) {
	if ($('#CEForm').valid()) {
		saveContact();
	} else {
		validator.focusInvalid();
	}
});

function saveContact(button) {
	$("#ButtonCE").attr('disabled', 'disabled');
	var l = Ladda.create(document.querySelector("#ButtonCE"));
	l.start();
	var formData = $("#CEForm").serialize();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		url: "/sfi/cargos/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			window.location = "/sfi/cargos" 
		},
		always: function() {
			l.stop();
		},
		error: function() {
			alert("Something went wrong, please try again!");
		}
		
	});
}