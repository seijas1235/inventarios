var validator = $("#GastosUpdateForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		documento: {
			required : true,
		},
		no_documento: {
			required : true
		},
		fecha_corte: {
			required : true
		},
		codigo_corte: {
			required : true
		},
		descripcion: {
			required : true
		},
		monto: {
			required: true
		}
	},
	messages: {
		documento: {
			required: "Por favor, ingrese el documento"
		},
		no_documento: {
			required : "Por favor, ingrese un no de documento del gasto"
		},
		fecha_corte: {
			required : "Por favor, seleccione una fecha para corte del gasto"
		},
		codigo_corte: {
			required : "Por favor, ingrese un codigo para corte"
		},
		descripcion: {
			required : "Por favor, ingrese una descripcion del gasto"
		},
		monto: {
			required: "Por favor, ingrese el monto del gasto"
		}
	}
});


$('#fecha_corte').datetimepicker({
    format: 'YYYY-MM-DD',
    showClear: true,
    showClose: true
});