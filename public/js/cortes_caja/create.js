$(document).ready(function() {

	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});


});

window.onload = function() {
	formatoNumero();
  }

var formatNumber = {
	separador: ',', // separador para los miles
	sepDecimal: ".", // separador para los decimales
	formatear:function (num){
	num +='';
	var splitStr = num.split('.');
	var splitLeft = splitStr[0];
	var splitRight = splitStr.length > 1 ? this.sepDecimal + splitStr[1] : '';
	var regx = /(\d+)(\d{3})/;
	while (regx.test(splitLeft)) {
	splitLeft = splitLeft.replace(regx, '$1' + this.separador + '$2');
	}
	return this.simbol + splitLeft +splitRight;
	},
	new:function(num, simbol){
	this.simbol = simbol ||'';
	return this.formatear(num);
	}
   }
   
   function formatoNumero(){
   var numbers = document.querySelectorAll('.number');
   [].forEach.call(numbers, function (item) {
	var valor = item.value;
	item.value = formatNumber.new(valor);
  });
};


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
	$("#ButtonCalcular").prop('disabled', false);
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

	//Sin Factura
	var url5 = "/cortes_caja/getEfectivoSF/?data=" + fecha;    
		$.getJSON( url5 , function ( result ) {
			if (result == 0 ) {
				$("input[name='efectivoSF'] ").val("");
			}
			else {
				var efectivo = $("input[name='efectivo'] ").val();
				var efectivoV = result[0].efectivo;
				var efectivoSF = parseFloat(efectivoV)- parseFloat(efectivo);  
				$("input[name='efectivoSF'] ").val(efectivoSF);
			}
		});

	var url6 = "/cortes_caja/getTarjetaSF/?data=" + fecha;
		$.getJSON( url6 , function ( result ) {
			if (result == 0 ) {
				$("input[name='voucherSF'] ").val("");
			}
			else {
				var tarjeta = $("input[name='voucher'] ").val();
				var tarjetaV = result[0].tarjeta;
				var tarjetaSF = parseFloat(tarjetaV)- parseFloat(tarjeta);  
				$("input[name='voucherSF'] ").val(tarjetaSF);
			}
		});

	var url7 = "/cortes_caja/getCreditoSF/?data=" + fecha;
		$.getJSON( url7 , function ( result ) {
			if (result == 0 ) {
				$("input[name='creditoSF'] ").val("");
			}
			else {
				var credito = $("input[name='credito'] ").val();
				var creditoV = result[0].credito;
				var creditoSF = parseFloat(creditoV)- parseFloat(credito);  
				$("input[name='creditoSF'] ").val(creditoSF);
			}
		});

	var url8 = "/cortes_caja/getTotalSF/?data=" + fecha;
		$.getJSON( url8 , function ( result ) {
			if (result == 0 ) {
				$("input[name='totalSF'] ").val("");
			}
			else {
				var total = $("input[name='total'] ").val();
				var totalV = result[0].total;
				var totalSF = parseFloat(totalV)- parseFloat(total);  
				$("input[name='totalSF'] ").val(totalSF);
			}
		});

	var url9 = "/cortes_caja/getTotalSF/?data=" + fecha;
	$.getJSON( url8 , function ( result ) {
		if (result == 0 ) {
			$("input[name='total_venta'] ").val("");
		}
		else {
			$("input[name='total_venta'] ").val(result[0].total);
		}
	});

	var url9 = "/cortes_caja/getFacturas/?data=" + fecha;
	$.getJSON( url9 , function ( result ) {
		if (result == 0 ) {
			$("input[name='factura_inicial'] ").val("");
			$("input[name='factura_final'] ").val("");
		}
		else {
			$("input[name='factura_inicial'] ").val(result[0].factura_inicial);
			$("input[name='factura_final'] ").val(result[0].factura_final);
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
	var efectivoSF = $("input[name='efectivoSF").val();
	var creditoSF = $("input[name='creditoSF").val();
	var voucherSF = $("input[name='voucherSF").val();
	var totalSF = $("input[name='totalSF").val();
	var total_venta = $("input[name='total_venta']").val();
	var factura_inicial = $("input[name='factura_inicial").val();
	var factura_final = $("input[name='factura_final").val();

	var formData = {fecha:fecha, efectivo:efectivo, credito: credito, voucher:voucher, total:total, factura_final: factura_final, factura_inicial:factura_inicial,
		efectivoSF:efectivoSF, creditoSF: creditoSF, voucherSF:voucherSF, totalSF:totalSF, total_venta: total_venta} 

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
