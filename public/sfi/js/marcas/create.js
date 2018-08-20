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
		marca: {
			required : true,
		}
	},
	messages: {
		marca: {
			required: "Por favor, ingrese una marca"
		}
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
		url: "/sfi/marcas/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			window.location = "/sfi/marcas" 
		},
		always: function() {
			l.stop();
		},
		error: function() {
			alert("Something went wrong, please try again!");
		}
		
	});
}