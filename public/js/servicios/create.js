$(document).ready(function() {

	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});
});

$('.select2').select2({
});

var validator = $("#ServicioForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		nombre: {
			required : true
		},
		precio: {
			required : true
		}
	},
	messages: {
		nombre: {
			required: "Por favor, ingrese el nombre de un servicio"
		},
		precio: {
			required: "Por favor, ingrese el Sueldo"
		}
	}
});


var db = {};

window.db = db;
db.detalle = [];

$("#ButtonServicio").click(function(event) {
	if ($('#ServicioForm').valid()) {
		saveContact();
	} else {
		validator.focusInvalid();
	}
});

function saveContact(button) {
	$("#ButtonServicio").attr('disabled', 'disabled');
	var l = Ladda.create(document.querySelector("#ButtonServicio"));
	l.start();
	var formData = $("#ServicioForm").serialize();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		url: "/servicios/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			window.location = "/servicios" 
		},
		always: function() {
			l.stop();
		},
		error: function() {
			alert("Ha ocurrido un problema, contacte a su administrador!!");
		}
		
	});
}