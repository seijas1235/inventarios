$(document).ready(function() {

	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});
});
var validator = $("#SerieUpdateForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		resolucion:{
			required: true,
		},
		serie: {
			required : true
		},
		documento_id: {
			required : true
		},
		inicio:{
			required: true
		},
		fin:{
			required : true
		},
		fecha_resolucion:{
			required: true
		},
		fecha_vencimiento:{
			required: true
		},
		estado_id:{
			required:true
		},

	},
	messages: {
		resolucion:{
			required: "Debe ingresar El Número de Resolución",
		},

		serie: {
			required : "Debe Ingresar La Serie"
		},

		documento_id: {
			required : "Seleccione Un Documento"
		},
		inicio:{
			required: "Debe Ingresar un número de Inicio"
		},
		fin:{
			required : "Debe Ingresar un número de Fin"
		},
		fecha_resolucion:{
			required: "ingrese La Fecha de Autorizacion de Resolucion"
		},
		fecha_vencimiento:{
			required: "Seleccione La Fecha de Vencimiento"
		},
		estado_id:{
			required:"Debe seleccionar el estado"
		},
	

	}
});

