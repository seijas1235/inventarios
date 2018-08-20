$(document).ready(function() {

	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});
});


var validator = $("#VouchersForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		no_lote: {
			required : true,
		},
		total: {
			required : true
		},
		fecha_corte: {
			required: true
		}
	},
	messages: {
		no_lote: {
			required: "Por favor, ingresar número de lote"
		},
		total: {
			required : "Por favor, ingrese el total del voucher"
		},
		fecha_corte: {
			required: "Por favor, ingrese la fecha de corte"
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

$("#ButtonVouchers").click(function(event) {
	if ($('#VouchersForm').valid()) {
		saveContact();
	} else {
		validator.focusInvalid();
	}
});

function saveContact(button) {
	$("#ButtonVouchers").attr('disabled', 'disabled');
	var l = Ladda.create(document.querySelector("#ButtonVouchers"));
	l.start();
	var formData = $("#VouchersForm").serialize();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		url: "/sfi/vouchers/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			window.location = "/sfi/vouchers" 
		},
		always: function() {
			l.stop();
		},
		error: function() {
			alert("Un error ha ocurrido, ´por favor contacte a su administrador!");
		}
		
	});
}