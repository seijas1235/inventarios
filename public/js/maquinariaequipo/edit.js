
var validator = $("#VehiculoUpdateForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		placa: {
			required : true,
		},
		tipo_vehiculo_id: {
			required : true,
		},
		aceite: {
			required : true,
		},
		kilometraje: {
			required : true,
		},
		año: {
			required : true
		}
	},
	messages: {
		placa: {
			required: "Por favor, ingrese el numero de placa"
		},
		tipo_vehiculo_id: {
			required : "Por favor, seleccione el tipo de vehiculo"
		},
		aceite: {
			required : "Por favor, ingrese el aceite del vehiculo"
		},
		kilometraje: {
			required : "Por favor, ingrese el ultimo kilometraje del vehiculo"
		},
		año: {
			required : "Por favor, ingrese el año del vehiculo"
		}
	}
});

