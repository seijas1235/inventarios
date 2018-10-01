$(document).ready(function() {

	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});
});
$('#fecha_resolucion').datetimepicker({
    format: 'YYYY-MM-DD',
    showClear: true,
    showClose: true
});

$('#fecha_vencimiento').datetimepicker({
    format: 'YYYY-MM-DD',
    showClear: true,
    showClose: true
});


var validator = $("#SerieForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		resolucion:{
			required: true,
		},

		serie: {
			required : true
		},

		estado_id: {
			required : true
		},
		documento_id: {
			required : true
		},
		inicio:{
			required: true
		},
		fin:{
			required : true
		},
		

	},
	messages: {
		resolucion:{
			required: "Debe ingresar El Número de Resolución",
		},

		serie: {
			required : "Debe Ingresar La Serie"
		},

		estado_id: {
			required : "Seleccione Un Estado"
		},
		documento_id: {
			required : "Seleccione Un Documento"
		},
		inicio:{
			required: "Debe Ingresar un número de Inicio"
		},
		fin:{
			required : "Debe Ingresar un número de Fin"
		},
	

	}
});


var db = {};

window.db = db;
db.detalle = [];

$("#ButtonSerie").click(function(event) {
	if ($('#SerieForm').valid()) {
		saveContact();
	} else {
		validator.focusInvalid();
	}
});

function saveContact(button) {
	$("#ButtonSerie").attr('disabled', 'disabled');
	var l = Ladda.create(document.querySelector("#ButtonSerie"));
	l.start();
	var formData = $("#SerieForm").serialize();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		url: "/series/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			window.location = "/series" 
		},
		always: function() {
			l.stop();
		},
		error: function() {
			alert("Ha ocurrido un problema, contacte a su administrador!!");
		}
		
	});
}