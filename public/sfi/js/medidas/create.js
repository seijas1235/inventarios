$(document).ready(function() {

	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});
});


$.validator.addMethod("medidaunica", function(value, element) {
	var valid = false;
	$.ajax({
		type: "GET",
		async: false,
		url: "/sfi_tecu/medida-disponible",
		data: "fecha_medida=" + value,
		dataType: "json",
		success: function(msg) {
			valid = !msg;
		}
	});
	return valid;
}, "La información correspondiente a la fecha seleccionada, ya se ha ingresado, ingrese la información correspondiente a otra fecha");


var validator = $("#MedidasForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		fecha_medida: {
			required:true,
			medidaunica:true
		},
		empleado_id: {
			required:true
		},
		med_regla_super: {
			required : true
		},
		med_regla_regular: {
			required : true
		},
		med_regla_diesel: {
			required : true
		},
		med_tabla_super: {
			required : true
		},
		med_tabla_regular: {
			required : true
		},
		med_tabla_diesel: {
			required : true,
		}
	},
	messages: {
		fecha_medida: {
			required: "Por favor, seleccione una fecha para ingresar la información"
		},
		empleado_id: {
			required: "Por favor, seleccione el empleado que tomo las medidas"
		},
		med_regla_super: {
			required : "Por favor, ingrese la medida de super según la regla"
		},
		med_regla_regular: {
			required : "Por favor, ingrese la medida de regular según la regla"
		},
		med_regla_diesel: {
			required : "Por favor, ingrese la medida de diesel según la regla"
		},
		med_tabla_super: {
			required : "Por favor, ingrese la medida de super según la tabla"
		},  
		med_tabla_regular: {
			required : "Por favor, ingrese la medida de regular según la tabla"
		},      
		med_tabla_diesel: {
			required : "Por favor, ingrese la medida de diesel según la tabla"
		}
	}
});




$('#fecha_medida').datetimepicker({
    format: 'YYYY-MM-DD',
    showClear: true,
    showClose: true
});


var db = {};

window.db = db;
db.detalle = [];

$("#ButtonMedidas").click(function(event) {
	if ($('#MedidasForm').valid()) {
		saveContact();
	} else {
		validator.focusInvalid();
	}
});

function saveContact(button) {
	$("#ButtonMedidas").attr('disabled', 'disabled');
	var l = Ladda.create(document.querySelector("#ButtonMedidas"));
	l.start();
	var formData = $("#MedidasForm").serialize();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		url: "/sfi_tecu/medidas/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			window.location = "/sfi_tecu/medidas"; 
		},
		always: function() {
			l.stop();
		},
		error: function() {
			alert("Something went wrong, please try again!");
		}
	});
}
