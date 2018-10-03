$(document).ready(function() {

	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});
});

$('#fecha').datetimepicker({
    format: 'YYYY-MM-DD',
    showClear: true,
    showClose: true
});

var validator = $("#CompraForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		nit:{
			required: true,
			nit:true,
			nitUnico: true
		},

		nombres: {
			required : true
		},

		apellidos: {
			required : true
		},
		tipo_cliente_id: {
			required : true
		}

	},
	messages: {
		nit: {
			required: "Por favor, ingrese el NIT del cliente"
		},

		nombres: {
			required: "Por favor, ingrese nombres del cliente"
		},

		apellidos: {
			required: "Por favor, ingrese apellidos del cliente"
		},
		tipo_cliente_id: {
			required: "Por favor, seleccione el tipo de cliente"
		}

	}
});


var db = {};

window.db = db;
db.detalle = [];

$("#ButtonCompra").click(function(event) {
	if ($('#CompraForm').valid()) {
		saveContact();
	} else {
		validator.focusInvalid();
	}
});

$("#ButtonCompra").click(function(event) {
	if ($('#CompraForm').valid()) {
		saveContact();
	} else {
		validator.focusInvalid();
	}
});


function saveContact(button) {
	$("#ButtonCompra").attr('disabled', 'disabled');
	var l = Ladda.create(document.querySelector("#ButtonCompra"));
	l.start();
	var formData = $("#CompraForm").serialize();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		url: "/clientes/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			window.location = "/clientes" 
		},
		always: function() {
			l.stop();
		},
		error: function() {
			alert("Ha ocurrido un problema, contacte a su administrador!!");
		}
		
	});
}

$("#BtnEnviar").click(function (e) {
	e.preventDefault();
	var codigo_barra=$('#codigo_barra').val();
	$.ajax({
		type: "GET",
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		url: "/compras/buscar",
		data: {
			codigo_barra:codigo_barra
		},
		dataType: "json",
		beforeSend: function() {
			$("#respuesta").html('Buscando producto...');
		 },
		 error: function() {
			$("#respuesta").html('<div> Ha surgido un error. </div>');
		 },
		success: function(data) {
			if (data) {
				var html = '<div>';
				html += '<ul>';
				html += '<li> Codigo de Barra: ' + data.productos['nombre'] + ' </li>';
				html += '<li> Nombre: ' + data + ' </li>';
				html += '</ul>';
				html += '</div>';
				$("#respuesta").html(html);
			 } else {
				$("#respuesta").html('<div> No hay ningún empleado con ese legajo. </div>');
			 }

		  }
	   });
});
