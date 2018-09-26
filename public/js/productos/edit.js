var validator = $("#ProductoUpdateForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		codigo_barra: {
			required : true
		},
		nombre: {
			required : true
		},
		minimo: {
			required : true
		}
	},
	messages: {
		codigo_barra: {
			required: "Por favor, ingrese el codigo de barra del producto"
		},
		nombre: {
			required : "Por favor, ingrese el nombre del producto"
		},
		minimo: {
			required : "Por favor, ingrese el stock minimo del producto"
		}
	}
});
