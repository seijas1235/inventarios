$('#fecha_adquisicion').datetimepicker({
    format: 'YYYY-MM-DD',
    showClear: true,
    showClose: true
});



var validator = $("#MaquinariaEquipoForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		nombre: {
			required : true
		},
		marca: {
			required : true
		},

		labadas_limite: {
			required : true
		}

	},
	messages: {
		nombre: {
			required: "Por favor, ingrese el nombre del Equipo"
		},
		apellido: {
			required: "Por favor, ingrese La marca del Equipo"
		},

		direccion: {
			required: "Por favor, ingrese el numero limite de labadas del equipo"
		},
	}
})
