var validator = $("#VehiculoClienteUpdateForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		vehiculo_id: {
			required : true
		},

		cliente_id: {
			required : true
		}
	},
	messages: {
		vehiculo_id: {
			required: "Por favor, seleccione vehiuclo del cliente"
		},

		cliente_id: {
			required: "Por favor, seleccione cliente"
		}
	}
});
