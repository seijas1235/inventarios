$('#fecha_ultimo_servicio').datetimepicker({
    format: 'YYYY-MM-DD',
    showClear: true,
    showClose: true
});
var validator = $("#VehiculoUpdateForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		placa: {
			required : true
		},
		aceite_caja: {
			required : true
		},
		aceite_motor: {
			required : true
		},
		tipo_vehiculo_id: {
			required : true
		},
		marca_vehiculo_id: {
			required : true
		},
		kilometraje: {
			required : true
		},
		color: {
			required : true
		},
		año: {
			required : true
		},
		fecha_ultimo_servicio: {
			required : true
		}

	},
	messages: {
		placa: {
			required: "Por favor, ingrese el numero de placa"
		},
		aceite_caja: {
			required : "Por favor, ingrese el aceite de caja que utiliza el vehiculo"
		},
		aceite_motor: {
			required : "Por favor, ingrese el aceite de motor que utiliza el vehiculo"
		},
		tipo_vehiculo_id: {
			required : "Por favor, seleccione el tipo de vehiculo"
		},
		marca_vehiculo_id: {
			required : "Por favor, seleccione el tipo de vehiculo"
		},
		kilometraje: {
			required : "Por favor, ingrese el ultimo kilometraje del vehiculo"
		},
		color: {
			required : "Por favor, ingrese el color del vehiculo"
		},
		año: {
			required : "Por favor, ingrese el año del vehiculo"
		},
		fecha_ultimo_servicio: {
			required : "Por favor, ingrese la fecha del ultimo servicio"
		}
	}
});

