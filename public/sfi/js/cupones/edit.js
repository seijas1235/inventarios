var validator = $("#CuponesUpdateForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		fecha_corte: {
			required:true
		},
		codigo_corte: {
			required : true
		},
		no_cupon: {
			required : true
		},
		codigo_cliente: {
			required : true
		},
		nombre_cliente: {
			required : true
		},
		monto: {
			required : true,
		}
	},
	messages: {
		fecha_corte: {
			required: "Por favor, seleccione la fecha del corte al que pertenece éste cupón PUMA"
		},
		codigo_corte: {
			required : "Por favor, ingrese el código de corte al que pertenece éste cupón PUMA"
		},
		no_cupon: {
			required : "Por favor, ingrese el número del cupon PUMA"
		},
		codigo_cliente: {
			required : "Por favor, ingrese el código de cliente qe aparece en el cupón PUMA"
		},
		nombre_cliente: {
			required : "Por favor, ingrese el nombre del cliente que aparece en el cupón PUMA"
		},  
		monto: {
			required : "Por favor, ingrese el total del cupon PUMA"
		}
	}
});




$('#fecha_corte').datetimepicker({
    format: 'YYYY-MM-DD',
    showClear: true,
    showClose: true
});
