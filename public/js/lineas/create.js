$(document).ready(function() {

	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});
});


var validator = $("#LineaForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		linea: {
			required : true
		},
		marca_id: {
			required : true
		},
	},
	messages: {
		linea: {
			required: "Por favor, ingrese el nombre de Linea"
		},
		marca_id: {
			required: "Por favor, seleccione la marca"
		},
		
	}
});


var db = {};

window.db = db;
db.detalle = [];

$("#ButtonLinea").click(function(event) {
	if ($('#LineaForm').valid()) {
		saveLinea();
	} else {
		validator.focusInvalid();
	}
});

function saveLinea(button) {
	$("#ButtonLinea").attr('disabled', 'disabled');
	var l = Ladda.create(document.querySelector("#ButtonLinea"));
	l.start();
	var formData = $("#LineaForm").serialize();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		url: "/lineas/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			window.location = "/lineas" 
		},
		always: function() {
			l.stop();
		},
		error: function() {
			alert("Ha ocurrido un problema, contacte a su administrador!!");
		}
		
	});
}