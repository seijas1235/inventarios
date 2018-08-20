
var validator = $("#TVUpdateForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		tipo_vehiculo: {
			required : true,
		}
	},
	messages: {
		tipo_vehiculo: {
			required: "Por favor, ingrese un tipo de vehiculo"
		}
	}
});