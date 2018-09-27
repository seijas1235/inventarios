$(document).ready(function() {

	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});
});



var validator = $("#VehiculoForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		placa: {
			required : true
		},
		aceite: {
			required : true
		},
		tipo_vehiculo_id: {
			required : true
		},
		kilometraje: {
			required : true
		},

		año: {
			required : true
		}
	},
	messages: {
		placa: {
			required: "Por favor, ingrese el numero de placa"
		},
		aceite: {
			required : "Por favor, ingrese el aceite que utiliza el vehiculo"
		},
		tipo_vehiculo_id: {
			required : "Por favor, seleccione el tipo de vehiculo"
		},
		kilometraje: {
			required : "Por favor, ingrese el ultimo kilometraje del vehiculo"
		},

		año: {
			required : "Por favor, ingrese el año del vehiculo"
		}
	}
});


var db = {};

window.db = db;
db.detalle = [];

$("#ButtonVehiculo").click(function(event) {
	if ($('#VehiculoForm').valid()) {
		saveContact();
	} else {
		validator.focusInvalid();
	}
});

function saveContact(button) {
	$("#ButtonVehiculo").attr('disabled', 'disabled');
	var l = Ladda.create(document.querySelector("#ButtonVehiculo"));
	l.start();
	var formData = $("#VehiculoForm").serialize();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		url: "/vehiculos/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			window.location = "/vehiculos" 
		},
		always: function() {
			l.stop();
		},
		error: function() {
			alert("Ha ocurrido un problema, contacte a su administrador!!");
		}
		
	});
}