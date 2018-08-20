var validator = $("#FactoresUpdateForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		factor_calc: {
			required:true
		},
		indice: {
			required : true
		}
	},
	messages: {
		factor_calc: {
			required: "Por favor, ingrese un nombre de identificación del factor"
		},
		indica: {
			required : "Por favor, ingrese un indice en formato numérico"
		}
	}
});