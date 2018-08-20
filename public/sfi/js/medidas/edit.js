var validator = $("#MedidasUpdateForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		empleado_id: {
			required:true
		},
		med_regla_super: {
			required : true
		},
		med_regla_regular: {
			required : true
		},
		med_regla_diesel: {
			required : true
		},
		med_tabla_super: {
			required : true
		},
		med_tabla_regular: {
			required : true
		},
		med_tabla_diesel: {
			required : true,
		}
	},
	messages: {
		empleado_id: {
			required: "Por favor, seleccione el empleado que tomo las medidas"
		},
		med_regla_super: {
			required : "Por favor, ingrese la medida de super según la regla"
		},
		med_regla_regular: {
			required : "Por favor, ingrese la medida de regular según la regla"
		},
		med_regla_diesel: {
			required : "Por favor, ingrese la medida de diesel según la regla"
		},
		med_tabla_super: {
			required : "Por favor, ingrese la medida de super según la tabla"
		},  
		med_tabla_regular: {
			required : "Por favor, ingrese la medida de regular según la tabla"
		},      
		med_tabla_diesel: {
			required : "Por favor, ingrese la medida de diesel según la tabla"
		}
	}
});




$('#fecha_medida').datetimepicker({
    format: 'YYYY-MM-DD',
    showClear: true,
    showClose: true
});
