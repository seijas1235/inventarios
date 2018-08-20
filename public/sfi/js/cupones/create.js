$(document).ready(function() {

	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});
});


var validator = $("#CuponesForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		fecha_corte: {
			required:true
		},
		codigo_corte: {
			required : true
		},
		no_cupon: {
			required : true
		},
		codigo_cliente: {
			required : true
		},
		nombre_cliente: {
			required : true
		},
		monto: {
			required : true,
		}
	},
	messages: {
		fecha_corte: {
			required: "Por favor, seleccione la fecha del corte al que pertenece éste cupón PUMA"
		},
		codigo_corte: {
			required : "Por favor, ingrese el código de corte al que pertenece éste cupón PUMA"
		},
		no_cupon: {
			required : "Por favor, ingrese el número del cupon PUMA"
		},
		codigo_cliente: {
			required : "Por favor, ingrese el código de cliente qe aparece en el cupón PUMA"
		},
		nombre_cliente: {
			required : "Por favor, ingrese el nombre del cliente que aparece en el cupón PUMA"
		},  
		monto: {
			required : "Por favor, ingrese el total del cupon PUMA"
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

$("#ButtonCupones").click(function(event) {
	if ($('#CuponesForm').valid()) {
		saveContact();
	} else {
		validator.focusInvalid();
	}
});

function saveContact(button) {
	$("#ButtonCupones").attr('disabled', 'disabled');
	var l = Ladda.create(document.querySelector("#ButtonCupones"));
	l.start();
	var formData = $("#CuponesForm").serialize();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		url: "/sfi_tecu/cupones/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			window.location = "/sfi_tecu/cupones"; 
		},
		always: function() {
			l.stop();
		},
		error: function() {
			alert("Something went wrong, please try again!");
		}
	});
}
