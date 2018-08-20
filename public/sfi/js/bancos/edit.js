var validator = $("#BancoUpdateForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		nombre: {
			required:true
		}
	},
	messages: {
		nombre: {
			required: "Por favor, ingrese un nombre para el banco"
		}
	}
});


function save(button, dialog) {
	getCustomFields();
	$("#ButtonUpdateBanco']").attr('disabled', 'disabled');
	var l = Ladda.create(document.querySelector("#ButtonUpdateBanco']"));
	l.start();
	var formData = $("#BancoUpdateForm").serialize();
	$.ajax({
		type: "POST",
		url: "/sfi/banco/" + id + "/update",
		data: formData,
		dataType: "json",
		success: function(data) {
			window.location = "/sfi/bancos"
		},
		always: function() {
			l.stop();
		},
		error: function() {
			alert("Un error ha ocurrido por favor contacte a su proveedor de servicios!");
		}
	});

}