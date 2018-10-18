$(document).ready(function() {

	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});
});
/*$('#fecha').datetimepicker({
    format: 'DD/MM/YYYY',

});*/


var validator = $("#FacturaForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		serie_id: {
			required : true
		},

		total: {
			required : true
		},
		fecha:{
			required: true
		},
		numero:{
			required: true
		},
		tipo_pago_id:{
			required: true
		},
	

	},
	messages: {
		
		serie_id: {
			required : "Debe Seleccionar La Serie"
		},
		total:{
			required: "Debe Ingresar el total"
		},
		fecha:{
			required : "Debe Seleccionar Fecha"
		},
		numero:{
			required: "Debe ingresar el numero de factura"
		},
		tipo_pago_id:{
			required: "Seleccione el tipo de pago"
		},
	

	}
});
