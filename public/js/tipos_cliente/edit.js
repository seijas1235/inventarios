var validator = $("#TipoClienteUpdateForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		nombre: {
			required : true
		}
	},
	messages: {
		nombre: {
			required: "Por favor, ingrese el nombre de un tipo de cliente"
		}
	}
});