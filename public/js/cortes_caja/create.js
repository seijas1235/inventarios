$(document).ready(function() {

	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});
});


$.validator.addMethod("corteUnico", function(value, element) {
	var valid = false;
	$.ajax({
		type: "GET",
		async: false,
		url: "/cortes_caja/corteUnico",
		data: "fecha=" + value,
		dataType: "json",
		success: function(msg) {
			valid = !msg;
		}
	});
	return valid;
}, "El corte de la fecha seleccionada ya existe");


var validator = $("#CorteCajaForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		fecha:{
			required: true,
			corteUnico: true
		}
	},
	messages: {
		fecha: {
			required: "Por favor, ingrese la fecha"
		}
	}
});


var db = {};

window.db = db;
db.detalle = [];

$("#ButtonCorte").click(function(event) {
	if ($('#CorteCajaForm').valid()) {
		saveContact();
	} else {
		validator.focusInvalid();
	}
});

$("input[name='fecha']").change(function () {
	$("#ButtonCorte").prop('disabled', false);
});

$("#ButtonCalcular").click(function(event) {
	var l = Ladda.create(document.querySelector("#ButtonCalcular"));
	l.start();

	var fecha = $("input[name='fecha'] ").val();
	var url1 = "/cortes_caja/getEfectivo/?data=" + fecha;    
		$.getJSON( url1 , function ( result ) {
			if (result == 0 ) {
				$("input[name='efectivo'] ").val("");
			}
			else {
				$("input[name='efectivo'] ").val(result[0].efectivo);
			}
		});

	var url2 = "/cortes_caja/getTarjeta/?data=" + fecha;
		$.getJSON( url2 , function ( result ) {
			if (result == 0 ) {
				$("input[name='voucher'] ").val("");
			}
			else {
				$("input[name='voucher'] ").val(result[0].tarjeta);
			}
		});

	var url3 = "/cortes_caja/getCredito/?data=" + fecha;
		$.getJSON( url3 , function ( result ) {
			if (result == 0 ) {
				$("input[name='credito'] ").val("");
			}
			else {
				$("input[name='credito'] ").val(result[0].credito);
			}
		});

	var url4 = "/cortes_caja/getTotal/?data=" + fecha;
		$.getJSON( url4 , function ( result ) {
			if (result == 0 ) {
				$("input[name='total'] ").val("");
			}
			else {
				$("input[name='total'] ").val(result[0].total);
			}
		});

		
});

function saveContact(button) {
	$("#ButtonCorte").attr('disabled', 'disabled');
	var l = Ladda.create(document.querySelector("#ButtonCorte"));
	l.start();
	//var formData = $("#CorteCajaForm").serialize();

	var fecha = $("input[name='fecha").val();
	var efectivo = $("input[name='efectivo").val();
	var credito = $("input[name='credito").val();
	var voucher = $("input[name='voucher").val();
	var total = $("input[name='total").val();
	var factura_inicial = $("input[name='factura_inicial").val();
	var factura_final = $("input[name='factura_final").val();

	var formData = {fecha:fecha, efectivo:efectivo, credito: credito, voucher:voucher, total:total, factura_final: factura_final, factura_inicial:factura_inicial} 

	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#tokenGuardar').val()},
		url: "/cortes_caja/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			window.location = "/cortes_caja" 
		},
		always: function() {
			l.stop();
		},
		error: function() {
			alert("Ha ocurrido un problema, contacte a su administrador!!");
		}
		
	});
}
