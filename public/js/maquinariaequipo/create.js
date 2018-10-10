$('#fecha_adquisicion').datetimepicker({
    format: 'YYYY-MM-DD',
    showClear: true,
    showClose: true
});



var validator = $("#MaquinariaEquipoForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		nombre_maquina: {
			required : true
		},
		codigo_maquina:{
			required : true
		},
		marca: {
			required : true
		},
		descripcion:{
			required : true
		},
		labadas_limite: {
			required : true
		}

	},
	messages: {
		nombre_maquina: {
			required: "Por favor, ingrese el nombre del Equipo"
		},
		apellido: {
			required: "Por favor, Seleccione La marca del Equipo"
		},
		descripcion :{
			required :"Por favor ingrese la Descripcion del equipo"
		},
		direccion: {
			required: "Por favor, ingrese el numero limite de labadas del equipo"
		},
		codigo_maquina:{
			required:"Debe Ingresar un codigo de maquinaria"
		}
	}
});


var db = {};

window.db = db;
db.detalle = [];

$("#ButtonMaquinariaEquipo").click(function(event) {
	if ($('#MaquinariaEquipoForm').valid()) {
		saveContact();
	} else {
		validator.focusInvalid();
	}
});

function saveContact(button) {
	$("#ButtonMaquinariaEquipo").attr('disabled', 'disabled');
	var l = Ladda.create(document.querySelector("#ButtonMaquinariaEquipo"));
	l.start();
	var formData = $("#MaquinariaEquipoForm").serialize();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		url: "/maquinarias_equipo/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			window.location = "/maquinarias_equipo" 
		},
		always: function() {
			l.stop();
		},
		error: function() {
			alert("Ha ocurrido un problema, contacte a su administrador!!");
		}
		
	});
}