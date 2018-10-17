$(document).ready(function() {

	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});
});

/*$('#fecha_ultimo_servicio').datetimepicker({
    format: 'YYYY-MM-DD',
    showClear: true,
    showClose: true
});*/

function ValidaPlaca(valorPlaca){
  var digitos = valorPlaca.length;

  // Aqui esta el patron(expresion regular) a buscar en el input
  patronPlaca = /^(DIS|TE|P|A|C|U|TRC|M|TC|O|CD|CC|MI|0)+[A-Z0-9]{6}$/;
  
  if( patronPlaca.test(valorPlaca) )
  {
    return true;
  }
  else
  {
    return false;
  }
}


$.validator.addMethod("placa", function(value, element){
	var valor = value;

	if(ValidaPlaca(valor)==true)
	{
		return true;
	}

	else
	{
		return false;
	}
}, "Verfique, placa incorrecta o incompleta");


var validator = $("#VehiculoForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		placa: {
			required : true,
			placa: true
		},
		aceite_caja: {
			required : true
		},
		aceite_motor: {
			required : true
		},
		tipo_vehiculo_id: {
			required : true
		},
		marca_id: {
			required : true
		},
		kilometraje: {
			required : true
		},
		color: {
			required : true
		},
		año: {
			required : true
		},
		fecha_ultimo_servicio: {
			required : true
		},
		tipo_transmision_id: {
			required : true
		},
		linea: {
			required : true
		},
		cliente_id: {
			required : true
		}

	},
	messages: {
		placa: {
			required: "Por favor, ingrese el numero de placa"
		},
		aceite_caja: {
			required : "Por favor, ingrese el aceite de caja que utiliza el vehiculo"
		},
		aceite_motor: {
			required : "Por favor, ingrese el aceite de motor que utiliza el vehiculo"
		},
		tipo_vehiculo_id: {
			required : "Por favor, seleccione el tipo de vehiculo"
		},
		marca_id: {
			required : "Por favor, seleccione el tipo de vehiculo"
		},
		kilometraje: {
			required : "Por favor, ingrese el ultimo kilometraje del vehiculo"
		},
		color: {
			required : "Por favor, ingrese el color del vehiculo"
		},
		año: {
			required : "Por favor, ingrese el año del vehiculo"
		},
		fecha_ultimo_servicio: {
			required : "Por favor, ingrese la fecha del ultimo servicio"
		},
		tipo_transmision_id: {
			required : "Por favor, seleccione el tipo de transmision"
		},
		linea: {
			required : "Por favor, ingrese linea del vehiculo"
		},
		cliente_id: {
			required : "Por favor, seleccione cliente"
		}
		
	}
});


var db = {};

window.db = db;
db.detalle = [];

$("#ButtonVehiculo").click(function(event) {
	if ($('#VehiculoForm').valid()) {
		saveContact();
	} else {
		validator.focusInvalid();
	}
});

function saveContact(button) {
	$("#ButtonVehiculo").attr('disabled', 'disabled');
	var l = Ladda.create(document.querySelector("#ButtonVehiculo"));
	l.start();
	var formData = $("#VehiculoForm").serialize();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		url: "/vehiculos/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			window.location = "/vehiculos" 
		},
		always: function() {
			l.stop();
		},
		error: function() {
			alert("Ha ocurrido un problema, contacte a su administrador!!");
		}
		
	});
}