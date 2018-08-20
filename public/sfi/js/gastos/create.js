$(document).ready(function() {

	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});
});


var validator = $("#GastosForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		documento: {
			required : true,
		},
		no_documento: {
			required : true
		},
		fecha_corte: {
			required : true
		},
		codigo_corte: {
			required : true
		},
		descripcion: {
			required : true
		},
		monto: {
			required: true
		}
	},
	messages: {
		documento: {
			required: "Por favor, ingrese el documento"
		},
		no_documento: {
			required : "Por favor, ingrese un no de documento del gasto"
		},
		fecha_corte: {
			required : "Por favor, seleccione una fecha para corte del gasto"
		},
		codigo_corte: {
			required : "Por favor, ingrese un codigo para corte"
		},
		descripcion: {
			required : "Por favor, ingrese una descripcion del gasto"
		},
		monto: {
			required: "Por favor, ingrese el monto del gasto"
		}
	}
});


$('#fecha_corte').datetimepicker({
    format: 'YYYY-MM-DD',
    showClear: true,
    showClose: true
});


var db = {};

window.db = db;
db.detalle = [];

$("#ButtonGastos").click(function(event) {
	if ($('#GastosForm').valid()) {
		saveContact();
	} else {
		validator.focusInvalid();
	}
});

function saveContact(button) {
	$("#ButtonGastos").attr('disabled', 'disabled');
	var l = Ladda.create(document.querySelector("#ButtonGastos"));
	l.start();
	var formData = $("#GastosForm").serialize();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		url: "/sfi_tecu/gastos/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			window.location = "/sfi_tecu/gastos" 
		},
		always: function() {
			l.stop();
		},
		error: function() {
			alert("Un error ha ocurrido, ´por favor contacte a su administrador!");
		}
		
	});
}