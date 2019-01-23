var validator = $("#DetalleUpdateForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		cantidad: {
			required : true
		},
		precio_venta: {
			required : true
		}
	},
	messages: {
		cantidad: {
			required: "Por favor, ingrese la cantidad"
		},
		precio_venta: {
			required: "Por favor, Ingrese precio de venta"
		}
	}
});

$("input[name='cantidad']").focusout(function() {
    var cantidad = $("input[name='cantidad']").val();
    var precio_venta = $("input[name='precio_venta']").val();

    if(cantidad == ""){
        cantidad = 0;
    }

    if(precio_venta == ""){
        precio_venta = 0;
    }

    $("input[name='subtotal']").val(precio_venta * cantidad);

});

$("input[name='precio_venta']").focusout(function() {
    var cantidad = $("input[name='cantidad']").val();
    var precio_venta = $("input[name='precio_venta']").val();

    if(cantidad == ""){
        cantidad = 0;
    }

    if(precio_venta == ""){
        precio_venta = 0;
    }

    $("input[name='subtotal_venta']").val(precio_venta * cantidad);

});