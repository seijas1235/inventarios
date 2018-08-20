var db = {};
window.db = db;
db.detalle = [];

var validator = $("#Series2UpdateForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		serie: {
			required:true
		},
		resolucion: {
			required : true
		},
		fecha_resolucion: {
			required : true
		},
		documento_id: {
			required : true
		}
	},
	messages: {
		serie: {
			required: "Por favor, ingrese la serie de factura a registrar"
		},
		resolucion: {
			required : "Por favor, ingrese el número de factura que se va a utilizar"
		},
		fecha_resolucion: {
			required : "Por favor, ingrese un rango de numeraci贸n de factura"
		},
		documento_id: {
			required : "Por favor, seleccione una tienda"
		}
	}
});