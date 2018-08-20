
var validator = $("#MarcaUpdateForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		marca: {
			required : true,
		}
	},
	messages: {
		marca: {
			required: "Por favor, ingrese una marca"
		}
	}
});
