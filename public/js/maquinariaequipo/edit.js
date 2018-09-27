
var validator = $("#MaquinariaEquipo-tableUpdateForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		nombre: {
			required : true,
		},
		marca: {
			required : true,
		},
		labadas_limite: {
			required : true,
		},
		fecha_adquisicion: {
			required : true,
		},
		precio_coste: {
			required : true
		}
	},
	messages: {
		nombre: {
			required: "Por favor, ingrese nombre del Equipo"
		},
		marca: {
			required : "Por favor, ingrese la marca del equipo"
		},
		labadas_limite: {
			required : "Por favor, ingrese la cantidad de labadas que puede realizar el equipo"
		},
		fecha_adquisicion: {
			required : "Por favor, ingrese la fecha de adquisicion del equipo"
		},
		precio_coste: {
			required : "Por favor, ingrese el precio de compra del equipo"
		}
	}
});

