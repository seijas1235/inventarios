$('#fecha_vencimiento').datetimepicker({
	format: 'YYYY-MM-DD',
	showClear: true,
	showClose: true
});


$('#fecha_resolucion').datetimepicker({
	format: 'YYYY-MM-DD',
	showClear: true,
	showClose: true
});

$(document).ready(function() {

	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});
});

var validator = $("#Series2Form").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		serie: {
			required:true
		},
		resolucion: {
			required : true
		},
		fecha_resolucion: {
			required : true
		},
		documento_id: {
			required : true
		}
	},
	messages: {
		serie: {
			required: "Por favor, ingrese la serie de factura a registrar"
		},
		resolucion: {
			required : "Por favor, ingrese el n¨²mero de factura que se va a utilizar"
		},
		fecha_resolucion: {
			required : "Por favor, ingrese un rango de numeraci¨®n de factura"
		},
		documento_id: {
			required : "Por favor, seleccione una tienda"
		}
	}
});



var db = {};

window.db = db;
db.detalle = [];


$("#ButtonSerie2").click(function(event) {
	if ($('#Series2Form').valid()) {
		saveContact();
	} else {
		validator.focusInvalid();
	}
});

function saveContact(button) {
	$("#ButtonSerie2").attr('disabled', 'disabled');
	var l = Ladda.create(document.querySelector("#ButtonSerie2"));
	l.start();
	var formData = $("#Series2Form").serialize();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		url: "/sfi/series2/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			window.location = "/sfi/series2" 
		},
		always: function() {
			l.stop();
		},
		error: function() {
			alert("Something went wrong, please try again!");
		}
		
	});
}