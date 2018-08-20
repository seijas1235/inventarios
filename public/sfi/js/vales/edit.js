$(document).on("keypress", 'form', function (e) {
	var code = e.keyCode || e.which;
	if (code == 13) {
		e.preventDefault();
		return false;
	}
});

$(document).on("keypress", '#ButtonVale', function (e) {
	var code = e.keyCode || e.which;
	if (code == 13) {
		e.preventDefault();
		return false;
	}
});


$(document).on("keypress", '#ButtonCombustible', function (e) {
	var code = e.keyCode || e.which;
	if (code == 13) {
		e.preventDefault();
		return false;
	}
});


$(document).on("keypress", '#ButtonProducto', function (e) {
	var code = e.keyCode || e.which;
	if (code == 13) {
		e.preventDefault();
		return false;
	}
});

function saveVale() {
	var bomba_id = $("#bomba_id").val();
	var cliente_id = $("#cliente_id").val();
	var total_vale = $("input[name='total_vale").val();
	var piloto = $("input[name='piloto").val();
	var placa = $("input[name='placa").val();
	var vale_id = $("input[name='vale_id").val();

	var formData = {
		total_vale: total_vale, bomba_id: bomba_id, cliente_id: cliente_id, detalle : db.links, piloto: piloto, placa: placa
	} 
	$.ajax({
		type: "GET",
		url: "/sfi/vales/saveedit/" + vale_id,
		data: formData,
		async: false,
		dataType: 'json',
		success: function(data) {
			window.location = "/sfi/vales";
			
		},
		error: function() {
			alert("Ha ocurrido un error");
		}
	});

}


$("#ButtonVale").click(function(e) {
	var bomba_id = $("#bomba_id").val();
	var cliente_id = $("#cliente_id").val();
	var total_vale = $("input[name='total_vale").val();
	e.preventDefault();

	if (bomba_id && cliente_id && total_vale != 0) {
		saveVale();
	} 
	else {
		bootbox.alert("Debe de seleccionar una bomba,un cliente y un producto");
	}
});



$("#SelecCliente").click(function(e) {
	var cliente_id = $("#cliente_id").val();
	e.preventDefault();

	if (cliente_id) {
		$(".botones").removeClass("hidden");
		$(".cliente").addClass("hidden");

	}
	
	else {
		bootbox.alert("Debe de seleccionar un cliente");
	}
});

$("#cambiarBomba").click(function(e) {
	e.preventDefault();

	$(".botones").removeClass("hidden");
	$(".cliente").addClass("hidden");
	$(".gasolina").addClass("hidden");
	
});


$(".gasolinaButton").click(function(e) {
	$('#bomba_id').val($(this).attr('id'));

	var bomba_id =$('#bomba_id').val();

	$.ajax({
		type: "GET",
		url: "/sfi/combustible/" + bomba_id,
		async:false,
		dataType: 'json',
		success: function(data) {
			$("#combustible_id").html("");
			$("#combustible_id").selectpicker('refresh')
			var opt = $('<option />');
			$.each(data, function (id, data) {
				var opt = $('<option />');
				opt.val(data.id);
				opt.text(data.combustible);
				$('#combustible_id').append(opt);
			});
			$("#combustible_id").selectpicker('refresh');
		},
		error: function() {
			alert("No se pudo crear la orden, verifique su conexión");
		}
	});

	$(".botones").addClass("hidden");
	$(".gasolina").removeClass("hidden");
});

$("#addProducto").click(function(e) {
	$(".gasolina").addClass("hidden");
	$(".producto").removeClass("hidden");
});



$("#ButtonProducto").click(function(e) {
	var producto_id = $("#producto_id").val();
	var cantidad = $("input[name='cantidad_p").val();
	e.preventDefault();

	if (producto_id && cantidad) {
		addProducto();
	} 
	else {
		bootbox.alert("Debe de seleccionar un producto");
	}
});

function addProducto() {
	$.LoadingOverlay("show");
	var detalle = new Object();
	detalle.producto_id = $("#producto_id").val();
	detalle.cantidad = $("input[name='cantidad_p").val();
	detalle.precio_venta = $("input[name='precio_p'] ").val();
	detalle.subtotal = $("input[name='subtotal_p']").val();
	detalle.tipo = 	1;
	detalle.prod_nombre = $("#producto_id").find("option:selected").text();
	detalle.precio_compra = $("input[name='precio_compra_p'] ").val();
	var total = $("input[name='total_vale']").val();
	var new_total = parseFloat(total) + parseFloat(detalle.subtotal);
	$("input[name='total_vale']").val(new_total);
	db.links.push(detalle);
	$("#detalle-grid .jsgrid-search-button").trigger("click");

	$("#producto_id").val("");
	$("#producto_id").selectpicker(0, '');

	$('#producto_id').selectpicker('render');

	$("input[name='cantidad_p").val(1);
	$("input[name='precio_p'] ").val(0);
	$("input[name='subtotal_p']").val(0);
	$("input[name='precio_compra_p'] ").val(0);


	$.LoadingOverlay("hide");
}



function getPrecio() {
	var combustible_id = $("#combustible_id").val();
	var cantidad = $("input[name='cantidad_c").val();

	if (combustible_id ) {

		var url = "/sfi/combustible/precio/" + combustible_id;
		if (bomba_id != "") {
			$.getJSON( url , function ( result ) {

				$("input[name='combustible_id'] ").val(result.combustible_id);
				$("input[name='precio_compra_c'] ").val(result.precio_compra);

				$("input[name='precio_c'] ").val(result.precio_venta);
				if ($("#quetzales").prop('checked') == true) 
				{
					$("input[name='subtotal_c']").val(cantidad);

				}
				else {

					$("input[name='subtotal_c']").val(result.precio_venta * cantidad);

				}
			});
		}
	}
	else {
		bootbox.alert("Debe de seleccionar un combustible");
	}


}


$("#ButtonCombustible").click(function(e) {
	var producto_id = $("#combustible_id").val();
	var cantidad = $("input[name='cantidad_c").val();
	e.preventDefault();

	if (producto_id && cantidad) {
		addCombustible();
	} 
	else {
		bootbox.alert("Debe de seleccionar un combustible");
	}

});



$("#quetzales").change(function () {
	getPrecio();
});


$("#producto_id").change(function () {
	changeProduct();
});


$("#combustible_id").change(function () {
	getPrecio();
});

$("input[name='cantidad_p").change(function () {

	var cantidad = $("input[name='cantidad_p").val();
	var precio = $("input[name='precio_p").val();
	var precio_compra =  $("input[name='precio_compra_p'] ").val();
	$("input[name='subtotal_p']").val(precio * cantidad);
});


function changeProduct() {
	var producto_id = $("#producto_id").val();
	var cantidad = $("input[name='cantidad_p").val();
	var url = "/sfi/producto/precio/" + producto_id ;
	if (producto_id != "") {
		$.getJSON( url , function ( result ) {
			$("input[name='precio_p'] ").val(result.precio_venta);
			$("input[name='precio_compra_p'] ").val(result.precio_compra);

			$("input[name='subtotal_p']").val(result.precio_venta * cantidad);
			
		});
	}
}


function addCombustible() {

	$.LoadingOverlay("show");
	var detalle = new Object();


	if ($("#quetzales").prop('checked') == true) 
	{
		var cantidad = parseFloat($("input[name='cantidad_c").val());
		var precio = parseFloat($("input[name='precio_c'] ").val());
		detalle.cantidad =  (cantidad / precio).toFixed(4);

	}
	else {
		detalle.cantidad = $("input[name='cantidad_c").val();
	}


	detalle.producto_id = $("#combustible_id").val();
	detalle.precio_venta = $("input[name='precio_c'] ").val();
	detalle.subtotal = $("input[name='subtotal_c']").val();
	detalle.tipo = 	2;
	detalle.prod_nombre = "Gasolina";
	detalle.precio_compra = $("input[name='precio_compra_c'] ").val();
	var total = $("input[name='total_vale']").val();
	var new_total = parseFloat(total) + parseFloat(detalle.subtotal);
	$("input[name='total_vale']").val(new_total);
	db.links.push(detalle);
	$("#detalle-grid .jsgrid-search-button").trigger("click");

	$("#combustible_id").val("");
	$("#combustible_id").selectpicker(0, '');

	$('#combustible_id').selectpicker('render');

	$("input[name='cantidad_c").val(1);
	$("input[name='precio_c'] ").val(0);
	$("input[name='subtotal_c']").val(0);
	$("input[name='precio_compra_c'] ").val(0);


	$.LoadingOverlay("hide");	
}




$("input[name='cantidad_p").change(function () {

	var cantidad = $("input[name='cantidad_p").val();
	var precio = $("input[name='precio_p").val();
	var precio_compra =  $("input[name='precio_compra_p'] ").val();
	$("input[name='subtotal_p']").val(precio * cantidad);
});


$("input[name='cantidad_c").change(function () {

	getPrecio();
});


(function() {

	var db = {

		loadData: function(filter) {
			return $.grep(this.links, function(link) {
				return (!filter.name || link.name.indexOf(filter.name) > -1)
				&& (!filter.url || link.url.indexOf(filter.url) > -1);
			});
		},

		insertItem: function(insertingLink) {
			this.detalles.push(insertingLink);
			console.log(insertingLink);
		},

		updateItem: function(updatingLink) {
			console.log(updatingLink);
		},

		deleteItem: function(deletingLink) {
			var linkIndex = $.inArray(deletingLink, this.links);
			var total2 = $("input[name='total_vale'] ").val();
			var total2 =parseFloat(total2);
			var subtotal = parseFloat(deletingLink.subtotal);
			var total = total2 - subtotal;
			var total3 = $("input[name='total_vale'] ").val(total);
			this.links.splice(linkIndex, 1);
		}

	};

	window.db = db;
	db.links = [];
	$("#detalle-grid").jsGrid({
		width: "",
		filtering: false,
		editing: false,
		sorting: true,
		paging: true,
		autoload: true,
		inserting: false,
		pageSize: 15,
		pagerFormat: "Pages: {prev} {pages} {next} | {pageIndex} of {pageCount} |",
		pageNextText: '>',
		pagePrevText: '<',
		deleteConfirm: "Esta seguro de borrar el registro?",
		controller: db,
		fields: [
								// { title: "Id", name: "id", type:"number", index:"id", filtering:false, editing:false, inserting:false},
								{ title: "Cantidad", name: "cantidad", type: "text"},
								{ title: "Producto", name: "prod_nombre", type: "text"},
								{ title: "Codigo", name: "producto_id", type: "text", visible:false},
								{ title: "precio_compra", name: "precio_compra", type: "text", visible:false},
								{ title: "Precio", name: "precio_venta", type: "text"},
								{ title: "Subtotal", name: "subtotal", type: "text"},
								{ title: "Tipo", name: "tipo", type: "text", visible:false},
								{ type: "control" }
								],onItemInserting: function (args) {
								},onItemUpdating: function (object) {
								},onRefreshed : function () {
									$('tbody').children('.jsgrid-insert-row').children('td').children('input').first().focus();
								}
							});
}());