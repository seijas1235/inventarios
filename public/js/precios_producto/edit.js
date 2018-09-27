$('#fecha').datetimepicker({
    format: 'YYYY-MM-DD',
    showClear: true,
    showClose: true
});
var validator = $("#PrecioProductoUpdateForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		precio_venta:{
			required: true
		},

		producto_id: {
			required : true
		},

		fecha: {
			required : true
		}

	},
	messages: {
		precio_venta: {
			required: "Por favor, ingrese Precio de venta"
		},

		producto_id: {
			required: "Por favor, seleccione producto"
		},

		fecha: {
			required: "Por favor, ingrese fecha"
		}

	}
});
