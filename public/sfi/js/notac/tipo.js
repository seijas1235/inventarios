$(document).ready(function() {

	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});
});




var validator = $("#NotaCForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		cliente_id: {
			required : true,
		},
		tipo_id: {
			required : true,
		}
	},
	messages: {
		cliente_id: {
			required: "Por favor, seleccione un cliente"
		},
		tipo_id: {
			required: "Por favor seleccione un tipo"
		}
	}
});


var db = {};

window.db = db;
db.detalle = [];


$("#ButtonTipoNota").click(function(event) {

	if ($('#NotaCForm').valid()) {
		chooseOption();
	} else {
		validator.focusInvalid();
	}
});

function chooseOption() {


	var tipo = $("#tipo_id").val();
	var cliente = $("#cliente_id").val();

	if ($("#tipo_id").val() == 1 ) 
	{

		window.location = String("/nota_credito/descuento/" +  tipo + "/" + cliente);
	}

	
	if ($("#tipo_id").val() == 3 ) 
	{
		window.location = "/nota_credito/prontopago/" +  tipo + "/" + cliente;
	}


	if ($("#tipo_id").val() == 4 ) 
	{
		window.location = "/nota_credito/refacturacion/" +  tipo + "/" + cliente;
	}
}
