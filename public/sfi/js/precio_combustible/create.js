$(document).ready(function() {

	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});
});




var validator = $("#PrecioCombustibleForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		precio_venta: {
			required:true
		},
		precio_compra: {
			required : true
		},
		combustible_id: {
			required : true
		}
	},
	messages: {
		precio_venta: {
			required: "Por favor, ingrese el precio de venta"
		},
		precio_compra: {
			required : "Por favor, ingrese el precio de compra"
		},
		combustible_id: {
			required : "Por favor, seleccione un combustible"
		}
	}
});

var db = {};

window.db = db;
db.detalle = [];

$("#ButtonPrecioCombustible").click(function(event) {
	if ($('#PrecioCombustibleForm').valid()) {
		saveContact();
	} else {
		validator.focusInvalid();
	}
});

function saveContact(button) {
	$("#ButtonPrecioCombustible").attr('disabled', 'disabled');
	var l = Ladda.create(document.querySelector("#ButtonPrecioCombustible"));
	l.start();
	var formData = $("#PrecioCombustibleForm").serialize();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		url: "/sfi/precio_combustible/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			window.location = "/sfi/precio_combustible"; 
		},
		always: function() {
			l.stop();
		},
		error: function() {
			alert("Un error ha ocurrido, contacte al administrador del sistema!");
		}
	});
}
