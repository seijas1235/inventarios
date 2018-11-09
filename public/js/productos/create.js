$(document).ready(function() {

	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});
});

$.validator.addMethod("codigoUnico", function(value, element) {
	var valid = false;
	$.ajax({
		type: "GET",
		async: false,
		url: "/codigo-disponible",
		data: "codigo_barra=" + value,
		dataType: "json",
		success: function(msg) {
			valid = !msg;
		}
	});
	return valid;
}, "El codigo de barra ya está asignado a otro producto registrado en el sistema");


var validator = $("#ProductoForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		codigo_barra:{
			required: true,
			codigoUnico: true
		},

		nombre: {
			required : true
		},

		minimo: {
			required : true
		}
	},
	messages: {
		codigo_barra: {
			required: "Por favor, ingrese el codigo de barra del producto"
		},

		nombre: {
			required: "Por favor, ingrese el nombre del producto"
		},

		minimo: {
			required: "Por favor, ingrese el stock minimo del producto"
		}
	}
});


var db = {};

window.db = db;
db.detalle = [];

$("#ButtonProducto").click(function(event) {
	if ($('#ProductoForm').valid()) {
		saveContact();
	} else {
		validator.focusInvalid();
	}
});

function saveContact(button) {
	$("#ButtonProducto").attr('disabled', 'disabled');
	var l = Ladda.create(document.querySelector("#ButtonProducto"));
	l.start();
	var formData = $("#ProductoForm").serialize();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		url: "/productos/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			window.location = "/productos" 
		},
		always: function() {
			l.stop();
		},
		error: function() {
			alert("Ha ocurrido un problema, contacte a su administrador!!");
		}
		
	});
}