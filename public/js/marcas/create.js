$(document).ready(function() {

	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});
});


var validator = $("#MarcaForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		nombre: {
			required : true
		},
		tipo_marca_id: {
			required : true
		},
	},
	messages: {
		nombre: {
			required: "Por favor, ingrese el nombre de una Marca"
		},
		tipo_marca_id: {
			required: "Por favor, seleccione tipo de marca"
		},
		
	}
});


var db = {};

window.db = db;
db.detalle = [];

$("#ButtonMarca").click(function(event) {
	if ($('#MarcaForm').valid()) {
		saveContact();
	} else {
		validator.focusInvalid();
	}
});

function saveContact(button) {
	$("#ButtonMarca").attr('disabled', 'disabled');
	var l = Ladda.create(document.querySelector("#ButtonMarca"));
	l.start();
	var formData = $("#MarcaForm").serialize();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		url: "/marcas/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			window.location = "/marcas" 
		},
		always: function() {
			l.stop();
		},
		error: function() {
			alert("Ha ocurrido un problema, contacte a su administrador!!");
		}
		
	});
}