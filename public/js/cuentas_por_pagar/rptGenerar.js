/*$(document).ready(function() {
	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});
});*/
var validator = $("#ReporteForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		proveedor_id: {
			required : true
		},
		fecha_inicial: {
			required : true
        },
        fecha_final: {
			required : true
		}
	},
	messages: {
		proveedor_id: {
			required: "Por favor, Seleccione Proveedor"
		},
		fecha_inicial: {
			required: "Por favor, Seleccione Fecha inicial"
        },
        fecha_final: {
			required: "Por favor, Seleccione Fecha final"
        }
	}
});