$(document).ready(function() {

	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});
});


$.validator.addMethod("productounico", function(value, element) {
	var valid = false;
	$.ajax({
		type: "GET",
		async: false,
		url: "/sfi/producto-disponible",
		data: "codigobarra=" + value,
		dataType: "json",
		success: function(msg) {
			valid = !msg;
		}
	});
	return valid;
}, "El codigo de barra del Producto ya existe");


var validator = $("#ProductoForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		codigobarra: {
			required:true,
			productounico:true
		},
		nombre: {
			required : true
		},
		aplicacion: {
			required : true
		},
		marca_id: {
			required : true
		},
		precio_venta: {
			required : true
		},
		precio_compra: {
			required : true
		},
		tipo_producto_id: {
			required : true,
		}
	},
	messages: {
		codigobarra: {
			required: "Por favor, ingrese el código de barra del producto"
		},
		nombre: {
			required : "Por favor, ingrese un nombre para el producto"
		},
		aplicacion: {
			required : "Por favor, ingresar la aplicacion del producto"
		},
		marca_id: {
			required : "Por favor, seleccione una marca"
		},
		precio_venta: {
			required : "Por favor, ingrese un precio de venta del producto"
		},  
		precio_compra: {
			required : "Por favor, ingrese un precio de compra del producto"
		},      
		tipo_producto_id: {
			required : "Por favor, seleccione un tipo de producto"
		}
	}
});

var db = {};

window.db = db;
db.detalle = [];

$("#ButtonProducto").click(function(event) {
	if ($('#ProductoForm').valid()) {
		saveContact();
	} else {
		validator.focusInvalid();
	}
});

function saveContact(button) {
	$("#ButtonProducto").attr('disabled', 'disabled');
	var l = Ladda.create(document.querySelector("#ButtonProducto"));
	l.start();
	var formData = $("#ProductoForm").serialize();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		url: "/sfi/productos/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			window.location = "/sfi/productos"; 
		},
		always: function() {
			l.stop();
		},
		error: function() {
			alert("Something went wrong, please try again!");
		}
	});
}
