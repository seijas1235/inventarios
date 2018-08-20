var validator = $("#NotasCreditosUpdateForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		fecha: {
			required : true,
		},
		cliente_id: {
			required : true
		},
		total: {
			required : true
		},
		descripcion: {
			required: true
		}
	},
	messages: {
		fecha: {
			required: "Por favor, seleccione una fecha"
		},
		cliente_id: {
			required : "Por favor, seleccione un cliente"
		},
		total: {
			required : "Por favor, ingrese un total de la nota de crédito"
		},
		descripcion: {
			required: "Por favor, ingrese una observación o razón de porque se genera la nota de crédito"
		}
	}
});


$('#fecha').datetimepicker({
    format: 'YYYY-MM-DD',
    showClear: true,
    showClose: true
});
