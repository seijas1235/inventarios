$(document).ready(function() {

	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});
});

var validator = $("#IDPUpdateForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		combustible_id: {
			required:true
		},
		costo_idp: {
			required : true
		}
	},
	messages: {
		combustible_id: {
			required: "Por favor, seleccione un combustible"
		},
		costo_idp: {
			required : "Por favor, ingrese un costo por galón correspondiente al IDP"
		}
	}
});
