$(document).ready(function() {

	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});
});

var validator = $("#TVForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		tipo_vehiculo: {
			required : true,
		}
	},
	messages: {
		tipo_vehiculo: {
			required: "Por favor, ingrese un tipo de vehículo"
		}
	}
});


var db = {};

window.db = db;
db.detalle = [];

$("#ButtonTV").click(function(event) {
	if ($('#TVForm').valid()) {
		saveContact();
	} else {
		validator.focusInvalid();
	}
});

function saveContact(button) {
	$("#ButtonTV").attr('disabled', 'disabled');
	var l = Ladda.create(document.querySelector("#ButtonTV"));
	l.start();
	var formData = $("#TVForm").serialize();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		url: "/sfi/tipo_vehiculo/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			window.location = "/sfi/tipo_vehiculo" 
		},
		always: function() {
			l.stop();
		},
		error: function() {
			alert("Something went wrong, please try again!");
		}
		
	});
}