
var validator = $("#SaldosClientesUpdateForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		mes_id: {
			required : true,
		},
		cliente_id: {
			required : true
		},
		saldo: {
			required : true,
		}
	},
	messages: {
		mes_id: {
			required: "Por favor, seleccione un mes"
		},
		cliente_id: {
			required : "Por favor, seleccione un cliente"
		},
		saldo: {
			required : "Por favor, ingrese el saldo para el cliente y mes seleccionado"
		}
	}
});