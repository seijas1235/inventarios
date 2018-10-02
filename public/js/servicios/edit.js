$('.select2').select2({
});

var validator = $("#PuestoUpdateForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		nombre: {
			required : true
		},
		precio: {
			required : true
		}
	},
	messages: {
		nombre: {
			required: "Por favor, ingrese el nombre de un Puesto"
		},
		precio: {
			required: "Por favor, ingrese el precio"
		}
	}
});