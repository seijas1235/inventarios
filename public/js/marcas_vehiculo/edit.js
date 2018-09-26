var validator = $("#Marca_VehiculoUpdateForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		nombre: {
			required : true
		},
		},
	messages: {
		nombre: {
			required: "Por favor, ingrese una Marca de Vehiculo"
		},
	}
});