$(document).ready(function() {

	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});
});

$('#fecha_servicio').datetimepicker({
    format: 'YYYY-MM-DD',
    showClear: true,
    showClose: true
});

$('#fecha_proximo_servicio').datetimepicker({
    format: 'YYYY-MM-DD',
    showClear: true,
    showClose: true
});


var validator = $("#ManttoServicioUpdateForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		descripcion: {
			required : true,
			
		},
		maquinaria_id: {
			required : true,
			
		},

	},
	messages: {
		descripcion: {
			required: "Por favor, ingrese la descripcion del mantenimiento"
		},
		maquinaria_id: {
			required: "Por favor, Seleccione la maquinaria a la que se le realizo el mantenimiento"
		},
		
	}
});
