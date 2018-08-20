$(document).ready(function() {

	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});
});




var validator = $("#IDPCreateForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		combustible_id: {
			required:true
		},
		costo_idp: {
			required : true
		}
	},
	messages: {
		combustible_id: {
			required: "Por favor, seleccione un combustible"
		},
		costo_idp: {
			required : "Por favor, ingrese un costo por galón correspondiente al IDP"
		}
	}
});


var db = {};

window.db = db;
db.detalle = [];

$("#ButtonIDPCreate").click(function(event) {
	if ($('#IDPCreateForm').valid()) {
		saveContact();
	} else {
		validator.focusInvalid();
	}
});

function saveContact(button) {
	$("#ButtonIDPCreate").attr('disabled', 'disabled');
	var l = Ladda.create(document.querySelector("#ButtonIDPCreate"));
	l.start();
	var formData = $("#IDPCreateForm").serialize();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		url: "/sfi/idp/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			window.location = "/sfi/idp"; 
		},
		always: function() {
			l.stop();
		},
		error: function() {
			alert("Un error ha ocurrido, contacte al administrador del sistema!");
		}
	});
}
