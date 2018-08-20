$(document).ready(function() {

	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});
});


var validator = $("#BancoForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		nombre: {
			required : true,
		}
	},
	messages: {
		nombre: {
			required: "Por favor, ingrese un identificador para el banco"
		}
	}
});


var db = {};

window.db = db;
db.detalle = [];

$("#ButtonBanco").click(function(event) {
	if ($('#BancoForm').valid()) {
		saveContact();
	} else {
		validator.focusInvalid();
	}
});

function saveContact(button) {
	$("#ButtonBanco").attr('disabled', 'disabled');
	var l = Ladda.create(document.querySelector("#ButtonBanco"));
	l.start();
	var formData = $("#BancoForm").serialize();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		url: "/sfi/bancos/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			window.location = "/sfi/bancos" 
		},
		always: function() {
			l.stop();
		},
		error: function() {
			alert("Un error ha ocurrido, ´por favoor contacte a su administrador!");
		}
		
	});
}