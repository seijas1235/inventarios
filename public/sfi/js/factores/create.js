$(document).ready(function() {

	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});
});




var validator = $("#FactoresCreateForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		factor_calc: {
			required:true
		},
		indice: {
			required : true
		}
	},
	messages: {
		factor_calc: {
			required: "Por favor, ingrese un nombre de identificación del factor"
		},
		indica: {
			required : "Por favor, ingrese un indice en formato numérico"
		}
	}
});


var db = {};

window.db = db;
db.detalle = [];

$("#ButtonFactores").click(function(event) {
	if ($('#FactoresForm').valid()) {
		saveContact();
	} else {
		validator.focusInvalid();
	}
});

function saveContact(button) {
	$("#ButtonFactores").attr('disabled', 'disabled');
	var l = Ladda.create(document.querySelector("#ButtonFactores"));
	l.start();
	var formData = $("#FactoresForm").serialize();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		url: "/sfi_tecu/factores/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			window.location = "/sfi_tecu/factores"; 
		},
		always: function() {
			l.stop();
		},
		error: function() {
			alert("Un error ha ocurrido, contacte al administrador del sistema!");
		}
	});
}
