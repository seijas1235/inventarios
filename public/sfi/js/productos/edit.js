$.validator.addMethod("productounicoedit", function (value, element) {
    var valid = false;
    $.ajax({
        type: "GET",
        async: false,
        url: "/sfi/producto-disponible-edit",
        data: "codigobarra=" + value + "&id=" + $("#producto-id-val").text(),
        dataType: "json",
        success: function (msg) {
            valid = !msg;
        }
    });
    return valid;
}, "El codigo de barra del Producto ya existe");


var validator = $("#ProductoUpdateForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		codigobarra: {
			required:true,
			productounicoedit:true
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
			required: "Por favor, ingrese el codigo de barra del producto"
		},
		nombre: {
			required : "Por favor, ingrese un nombre para el producto"
		},
		aplicacion: {
			required : "Por favor, ingresar la aplicaci贸n del producto"
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
