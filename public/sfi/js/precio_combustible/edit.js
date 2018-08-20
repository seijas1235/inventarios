
var validator = $("#PrecioCombustibleUpdateForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		precio_venta: {
			required:true
		},
		precio_compra: {
			required : true
		},
		combustible_id: {
			required : true
		}
	},
	messages: {
		precio_venta: {
			required: "Por favor, ingrese el precio de venta"
		},
		precio_compra: {
			required : "Por favor, ingrese el precio de compra"
		},
		combustible_id: {
			required : "Por favor, seleccione un combustible"
		}
	}
});
