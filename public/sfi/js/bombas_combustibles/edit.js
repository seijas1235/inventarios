var validator = $("#BombaCombustibleUpdateForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		bomba_id: {
			required:true
		},
		combustible_id: {
			required:true
		}
	},
	messages: {
		bomba_id: {
			required: "Por favor, seleccione una bomba"
		},
		combustible_id: {
			required: "Por favor, seleccione un combustible"
		}
	}
});


function save(button, dialog) {
	getCustomFields();
	$("#ButtonUpdateBombaCombustible']").attr('disabled', 'disabled');
	var l = Ladda.create(document.querySelector("#ButtonUpdateBombaCombustible']"));
	l.start();
	var formData = $("#BombaCombustibleUpdateForm").serialize();
	$.ajax({
		type: "POST",
		url: "/sfi/bombas_combustibles/" + id + "/update",
		data: formData,
		dataType: "json",
		success: function(data) {
			window.location = "/sfi/bombas_combustibles"
		},
		always: function() {
			l.stop();
		},
		error: function() {
			alert("Un error ha ocurrido por favor contacte a su proveedor de servicios!");
		}
	});

}