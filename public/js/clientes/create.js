$(document).ready(function() {

	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});
});


function ValidaNIT(txtN) {
	txtN = txtN.toUpperCase();
	var nit = txtN;
	var pos = nit.indexOf("-");

		if (pos < 0)
		{
			var correlativo = txtN.substr(0, txtN.length - 1);
			correlativo = correlativo + "-";

			var pos2 = correlativo.length - 2;
			var digito = txtN.substr(pos2 + 1);
			nit = correlativo + digito;
			pos = nit.indexOf("-");
			txtN = nit;
		}

		var Correlativo = nit.substr(0, pos);
		var DigitoVerificador = nit.substr(pos + 1);
		var Factor = Correlativo.length + 1;
		var Suma = 0;
		var Valor = 0;
		for (x = 0; x <= (pos - 1); x++) {
			Valor = eval(nit.substr(x, 1));
			var Multiplicacion = eval(Valor * Factor);
			Suma = eval(Suma + Multiplicacion);
			Factor = Factor - 1;
		}
		var xMOd11 = 0;
		xMOd11 = (11 - (Suma % 11)) % 11;
		var s = xMOd11;
		if ((xMOd11 == 10 && DigitoVerificador == "K") || (s == DigitoVerificador)) {
			return true;
		}
		else
		{
			return false; 
		}
}


$.validator.addMethod("nit", function(value, element){
	var valor = value;

	if(ValidaNIT(valor)==true)
	{
		return true;
	}

	else
	{
		return false;
	}
}, "El NIT ingresado es incorrecto o inválido, reviselo y vuelva a ingresarlo");

var validator = $("#ClienteForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		nit:{
			required: true,
			nit:true
		},

		nombre: {
			required : true
		},

		direccion: {
			required : true
		},

		telefono: {
			required : true
		},

		record_compra: {
			required : true
		},

		descuento: {
			required : true
		},

		tipo_cliente_id: {
			required : true
		}

	},
	messages: {
		nit: {
			required: "Por favor, ingrese el NIT del cliente"
		},

		nombre: {
			required: "Por favor, ingrese el nombre del cliente"
		},

		direccion: {
			required: "Por favor, ingrese la direccion del cliente"
		},

		telefono: {
			required: "Por favor, ingrese el telefono del cliente"
		},

		record_compra: {
			required: "Por favor, ingrese el record de compra del cliente"
		},

		descuento: {
			required: "Por favor, ingrese el porcentaje de decuento del cliente"
		},

		tipo_cliente_id: {
			required: "Por favor, seleccione el tipo de cliente"
		}

	}
});


var db = {};

window.db = db;
db.detalle = [];

$("#ButtonCliente").click(function(event) {
	if ($('#ClienteForm').valid()) {
		saveContact();
	} else {
		validator.focusInvalid();
	}
});

function saveContact(button) {
	$("#ButtonCliente").attr('disabled', 'disabled');
	var l = Ladda.create(document.querySelector("#ButtonCliente"));
	l.start();
	var formData = $("#ClienteForm").serialize();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		url: "/clientes/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			window.location = "/clientes" 
		},
		always: function() {
			l.stop();
		},
		error: function() {
			alert("Ha ocurrido un problema, contacte a su administrador!!");
		}
		
	});
}