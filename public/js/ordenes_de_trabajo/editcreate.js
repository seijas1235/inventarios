$(document).ready(function() {

	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});
});

var validator = $("#CreateUpdateForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		cliente_id: {
			required: true
		},
		vehiculo_id:{
			required: true
		},
		fecha_hora: {
			required : true
		},
		resp_recepcion: {
			required : true
		},

		fecha_prometida: {
			required : true
		}

	},
	messages: {
		cliente_id: {
			required: "Por favor, seleccione cliente"
		},
		vehiculo_id: {
			required: "Por favor, seleccione vehiculo"
		},
		fecha_hora: {
			required: "Por favor, ingrese fecha y hora"
		},
		resp_recepcion: {
			required: "Por favor, ingrese nombre responsable recepcion"
		},

		fecha_prometida: {
			required: "Por favor, ingrese fecha prometida"
		}
	}
});

/*
var db = {};

window.db = db;
db.detalle = [];

$("#ButtonOrdenDeTrabajo").click(function(event) {
	if ($('#OrdenDeTrabajoForm').valid()) {
		saveContact();
	} else {
		validator.focusInvalid();
	}
});

function saveContact(button) {
	$("#ButtonOrdenDeTrabajo").attr('disabled', 'disabled');
	var l = Ladda.create(document.querySelector("#ButtonOrdenDeTrabajo"));
	l.start();
	var formData = $("#OrdenDeTrabajoForm").serialize();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		url: "/ordenes_de_trabajo/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			window.location = "/ordenes_de_trabajo/create2"
		},
		always: function() {
			l.stop();
		},
		error: function() {
			alert("Ha ocurrido un problema, contacte a su administrador!!");
		}
		
	});
}*/