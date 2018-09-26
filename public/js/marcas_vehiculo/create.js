$(document).ready(function() {

	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});
});


var validator = $("#Marca_VehiculoForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		nombre: {
			required : true
		},
	},
	messages: {
		nombre: {
			required: "Por favor, ingrese el nombre de una Marca"
		},
		
	}
});


var db = {};

window.db = db;
db.detalle = [];

$("#ButtonMarca_Vehiculo").click(function(event) {
	if ($('#Marca_VehiculoForm').valid()) {
		saveContact();
	} else {
		validator.focusInvalid();
	}
});

function saveContact(button) {
	$("#ButtonMarca_Vehiculo").attr('disabled', 'disabled');
	var l = Ladda.create(document.querySelector("#ButtonMarca_Vehiculo"));
	l.start();
	var formData = $("#Marca_VehiculoForm").serialize();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		url: "/marcas_vehiculo/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			window.location = "/marcas_vehiculo" 
		},
		always: function() {
			l.stop();
		},
		error: function() {
			alert("Ha ocurrido un problema, contacte a su administrador!!");
		}
		
	});
}