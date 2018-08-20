var validator = $("#VouchersUpdateForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		no_lote: {
			required : true,
		},
		total: {
			required : true
		},
		fecha_corte: {
			required: true
		}
	},
	messages: {
		no_lote: {
			required: "Por favor, ingresar número de lote"
		},
		total: {
			required : "Por favor, ingrese el total del voucher"
		},
		fecha_corte: {
			required: "Por favor, ingrese la fecha de corte"
		}
	}
});


$('#fecha_corte').datetimepicker({
    format: 'YYYY-MM-DD',
    showClear: true,
    showClose: true
});