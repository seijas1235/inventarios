
var validator = $("#CEUpdateForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		cargo_empleado: {
			required : true,
		}
	},
	messages: {
		cargo_empleado: {
			required: "Por favor, ingrese un cargo de Empleado"
		}
	}
});