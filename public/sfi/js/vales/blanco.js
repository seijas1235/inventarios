$(document).ready(function() {

	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});



});

var validator = $("#ValeForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		cliente_id: {
			required : true,
		},
		cantidad:  {
			required : true,
		}
	},
	messages: {
		cliente_id: {
			required: "Por favor, seleccione un cliente"
		},
		cantidad: {
			required: "Por favor escriba una cantidad"
		}
	}
});



$("#ButtonVale").click(function(e) {

	if ($('#ValeForm').valid()) {

		chooseOption();
	} else {
		validator.focusInvalid();
	}
});

function chooseOption() {

	var cantidad = parseInt($("input[name='cantidad").val());
	var cliente = $("#cliente_id").val();
	$("#ButtonVale").attr('disabled', 'disabled');
	var l = Ladda.create(document.querySelector("#ButtonVale"));
	l.start();


	var formData = {
		cliente_id: cliente, cantidad: cantidad
	} 
	$.ajax({
		type: "POST",
		url: "/vales/saveBlanco",
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		data: formData,
		dataType: "json",
		success: function(data) {
			window.location = "/vales" 
		},
		always: function() {
			l.stop();
		},
		error: function() {
			alert("Something went wrong, please try again!");
		}
	});

}

