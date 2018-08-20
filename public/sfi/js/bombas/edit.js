$.validator.addMethod("ntel", function(value, element) {
	var valor = value.length;
	if (valor == 8)
	{
		return true;
	}
	else
	{
		return false;
	}
}, "Debe ingresar el número de teléfono con 8 dígitos, en formato ########");


var validator = $("#BombaUpdateForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		bomba: {
			required:true
		},
		combustible_id: {
			required:true
		}
	},
	messages: {
		bomba: {
			required: "Por favor, ingrese un nombre para la bomba"
		},
		combustible_id: {
			required: "Por favor, seleccione un combustible"
		}
	}
});


function save(button, dialog) {
	getCustomFields();
	$("#ButtonUpdateBomba']").attr('disabled', 'disabled');
	var l = Ladda.create(document.querySelector("#ButtonUpdateBomba']"));
	l.start();
	var formData = $("#BombaUpdateForm").serialize();
	$.ajax({
		type: "POST",
		url: "/sfi/bomba/" + id + "/update",
		data: formData,
		dataType: "json",
		success: function(data) {
			window.location = "/sfi/bombas"
		},
		always: function() {
			l.stop();
		},
		error: function() {
			alert("Un error ha ocurrido por favor contacte a su proveedor de servicios!");
		}
	});

}