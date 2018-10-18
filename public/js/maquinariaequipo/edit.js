/*$('#fecha_adquisicion').datetimepicker({
    format: 'YYYY-MM-DD',
    showClear: true,
    showClose: true
});*/



var validator = $("#MaquinariaEquipoForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		nombre_maquina: {
			required : true
		},
		codigo_maquina:{
			required : true
		},
		marca: {
			required : true
		},
		descripcion:{
			required : true
		},
		labadas_limite: {
			required : true
		}

	},
	messages: {
		nombre_maquina: {
			required: "Por favor, ingrese el nombre del Equipo"
		},
		apellido: {
			required: "Por favor, Seleccione La marca del Equipo"
		},
		descripcion :{
			required :"Por favor ingrese la Descripcion del equipo"
		},
		direccion: {
			required: "Por favor, ingrese el numero limite de labadas del equipo"
		},
		codigo_maquina:{
			required:"Debe Ingresar un codigo de maquinaria"
		}
	}
});
