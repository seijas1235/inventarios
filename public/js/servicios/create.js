$(document).on("keypress", 'form', function (e) {
    var code = e.keyCode || e.which;
    if (code == 13) {
        e.preventDefault();
        return false;
    }
});

/*function changeProducto() {
    var producto_id = $("#producto_id").val();
    var url = "/producto/precio/" + producto_id ;
    if (producto_id != "") {
        $.getJSON( url , function ( result ) {
            $("input[name='costo_producto'] ").val(result.id);
			
        });
    }
}

$("#producto_id").change(function () {
    changeProducto();
});*/

$("input[name='codigo']").focusout(function() {
    var codigo = $("input[name='codigo'] ").val();
    var url = "/codigo-disponible-servicio/?data=" + codigo;

        $.getJSON( url , function ( result ) {
            if(result == 0 ){
                $('#ButtonServicio').attr("disabled", false);
                $(".error").remove();
            }

            else{
                $("input[name='codigo'] ").after("<label class='error'>El codigo ya se encuentra registrado en el sistema</label>");
                $('#ButtonServicio').attr("disabled", true);                
            }

        });
    });
	
function changeUnidad() {
    var unidad_de_medida_id = $("#unidad_de_medida_id").val();
    var url = "/unidad_de_medida/cantidad/" + unidad_de_medida_id ;
    if (unidad_de_medida_id != "") {
        $.getJSON( url , function ( result ) {
            $("input[name='unidad_cantidad'] ").val(result.cantidad);
			
        });
    }
}

$("#unidad_de_medida_id").change(function () {
    changeUnidad();
});

$(document).on("keypress", '#addProducto', function (e) {
    var code = e.keyCode || e.which;
    if (code == 13) {
        e.preventDefault();
        return false;
    }
});

$(document).on("keypress", '#addMaquinaria', function (e) {
    var code = e.keyCode || e.which;
    if (code == 13) {
        e.preventDefault();
        return false;
    }
});


$(document).on("keypress", '#ButtonServicio', function (e) {
    var code = e.keyCode || e.which;
    if (code == 13) {
        e.preventDefault();
        return false;
    }
});

$('body').on('click', '#addMaquinaria', function(e) {

    var detalle = new Object();
    var costo_maquinaria = $("input[name='costo_maquinaria'] ").val();
    var maquinaria_equipo_id  = $("#maquinaria_equipo_id").val();
	var cantidad = $("input[name='cantidad_maquina'] ").val();
    var subtotal = parseFloat(cantidad) * parseFloat(costo_maquinaria);
    var unidad =  $("#unidad_de_medida_id2").val();

    if (cantidad != "" && maquinaria_equipo_id != "" && costo_maquinaria != "" && unidad != "")
    {
        $("input[name='subtotal'] ").val(subtotal);
        detalle.costo = $("input[name='costo_maquinaria'] ").val();
        detalle.subtotal_servicio = $("input[name='subtotal'] ").val();
		detalle.maquinaria_equipo_id  = $("#maquinaria_equipo_id").val();
		detalle.cantidad  = $("input[name='cantidad_maquina'] ").val();
		detalle.nombre =  $("#maquinaria_equipo_id").find("option:selected").text();
		detalle.unidad_de_medida =  $("#unidad_de_medida_id2").find("option:selected").text();
        var total2 = $("input[name='total'] ").val();
        if (total2 != "") {
            var total2 =parseFloat(total2);
            var subtotal = parseFloat(subtotal);
            var total = total2 + subtotal;
            var total3 = $("input[name='total'] ").val(total);
        }
        else {
            var subtotal = parseFloat(subtotal);
            var total3 = $("input[name='total'] ").val(subtotal);
        }

        db.links.push(detalle);
        $('#maquinaria_equipo_id').val('');
        $('#maquinaria_equipo_id').change();
        $('#unidad_de_medida_id2').val('');
        $('#unidad_de_medida_id2').change();
		$("input[name='costo_maquinaria'] ").val("");
		$("input[name='cantidad_maquina'] ").val("");
        var precio = $("input[name='costo_maquinaria'] ").val();
        var subtotal = precio;
        $("input[name='subtotal'] ").val(subtotal);
        $("#servicio-grid .jsgrid-search-button").trigger("click");    
    }
    else 
    {
        alert("Verifique que este seleccionado almenos una maquinaria y/o equipo");
    }
    
});


$('body').on('click', '#addProducto', function(e) {

    var detalle = new Object();
	var costo_producto = $("input[name='costo_producto'] ").val();
    var cantidad = $("input[name='cantidad'] ").val();
    var producto_id  = $("#producto_id").val();
	//var unidad_cantidad = $("input[name='unidad_cantidad'] ").val();
	var subtotal = parseFloat(cantidad) * parseFloat(costo_producto);
	var unidad = $("#unidad_de_medida_id").val();
    

    if (cantidad != "" && producto_id != "" && costo_producto != "" && unidad != "")
    {
        $("input[name='subtotal'] ").val(subtotal);
        detalle.costo = $("input[name='costo_producto'] ").val();
        detalle.subtotal_servicio = $("input[name='subtotal'] ").val();
		detalle.producto_id  = $("#producto_id").val();
		detalle.cantidad  = $("input[name='cantidad'] ").val();
		detalle.nombre =  $("#producto_id").find("option:selected").text();
		detalle.unidad_de_medida =  $("#unidad_de_medida_id").find("option:selected").text();
        var total2 = $("input[name='total'] ").val();
        if (total2 != "") {
            var total2 =parseFloat(total2);
            var subtotal = parseFloat(subtotal);
            var total = total2 + subtotal;
            var total3 = $("input[name='total'] ").val(total);
        }
        else {
            var subtotal = parseFloat(subtotal);
            var total3 = $("input[name='total'] ").val(subtotal);
        }

        db.links.push(detalle);
        //$("input[name='producto_id'] ").val("");
        $('#producto_id').val('');
        $('#producto_id').change();
        $('#unidad_de_medida_id').val('');
        $('#unidad_de_medida_id').change();
		$("input[name='costo_producto'] ").val("");
		$("input[name='cantidad'] ").val("");
        $('#producto_id option').removeAttr('selected');
        var precio = $("input[name='costo_producto'] ").val();
        var subtotal = precio;
        $("input[name='subtotal'] ").val(subtotal);
        $("#servicio-grid .jsgrid-search-button").trigger("click");    
    }
    else 
    {
        alert("Verifique que este seleccionado almenos un producto");
    }
    
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
            this.links.push(insertingLink);
            console.log(insertingLink);
        },

        updateItem: function(updatingLink) {
            console.log(updatingLink);
        },

        deleteItem: function(deletingLink) {
            var linkIndex = $.inArray(deletingLink, this.links);
            var total2 = $("input[name='total'] ").val();
            var total2 =parseFloat(total2);
            var subtotal = parseFloat(deletingLink.subtotal_servicio);
            var total = total2 - subtotal;
            var total3 = $("input[name='total'] ").val(total);
            this.links.splice(linkIndex, 1);
        }

    };
    window.db = db;
    db.links = [];
	
	function saveDetalle(button) {
		var total = $("input[name='total'] ").val();
		var codigo = $("input[name='codigo'] ").val();
		var precio = $("input[name='precio'] ").val();
		var precio_costo = $("input[name='precio_costo'] ").val();
		var nombre = $("input[name='nombre'] ").val();
		var tipo_servicio_id = $("#tipo_servicio_id").val();

			if(codigo !="" && precio !="" && precio_costo !="" && nombre != "" && tipo_servicio_id !="")
			{
				
			var formData = {total: total,codigo:codigo, tipo_servicio_id : tipo_servicio_id, precio_costo:precio_costo, precio:precio, nombre:nombre } 
				$.ajax({
					type: "GET",
					url: "/servicios/save/",
					data: formData,
					dataType: "json",
					success: function(data) {
						var detalle = data;
						$.ajax({
							url: "/servicios-detalle/" + detalle.id,
							type: "POST",
							contentType: "application/json",
							data: JSON.stringify(db.links),
							success: function(addressResponse) {
								if (addressResponse.result == "ok") {
							window.location = "/servicios"
								}
							},
							always: function() {
							}
						});
					},
					error: function() {
						alert("Something went wrong, please try again!");
					}
				});
			}

			else{
				alert("Falta ingresar codigo, nombre, tipo de servicio");
			}
		}

		$("#ButtonServicio").click(function(event) {
            saveDetalle();
        });       


    $(document).ready(function () {

        $("#servicio-grid").jsGrid({
            width: "",
            filtering: false,
            editing: false,
            sorting: true,
            paging: true,
            autoload: true,
            inserting: false,
            pageSize: 20,
            pagerFormat: "Pages: {prev} {pages} {next} | {pageIndex} of {pageCount} |",
            pageNextText: '>',
            pagePrevText: '<',
            deleteConfirm: "Esta seguro de borrar el producto",
            controller: db,
            fields: [
            // { title: "Id", name: "id", type:"number", index:"id", filtering:false, editing:false, inserting:false},
			{ title: "Cod. Producto", name: "producto_id", type: "text", visible: false},
			{ title: "Cod. Maquinaria", name: "maquinaria_equipo_id", type: "text", visible: false},
			{ title: "Cantidad", name: "cantidad", type: "text"},
			{ title: "Unidad de Medida", name: "unidad_de_medida", type: "text"},
            { title: "Descripcion", name: "nombre", type: "text"},
            { title: "Costo", name: "costo", type: "text"},
            { title: "Subtotal", name: "subtotal_servicio", type: "text"},
            { type: "control" }
            ],
            onItemInserting: function (args) {
            },
            onItemUpdating: function (object) {
            },
            onRefreshed : function () {
                $('tbody').children('.jsgrid-insert-row').children('td').children('input').first().focus();
            }
        });
    });
}());

/*var validator = $("#ServicioForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		nombre: {
			required : true
		},
		precio: {
			required : true
		},
		precio_costo: {
			required : true
		},
		tipo_servicio_id:{
			required: true
		},
		codigo: {
			required : true
		}
	},
	messages: {
		nombre: {
			required: "Por favor, ingrese el nombre de un servicio"
		},
		precio: {
			required: "Por favor, ingrese el precio venta sin mano de obra"
		},
		precio_costo: {
			required: "Por favor, ingrese el precio costo sin mano de obra"
		},
		tipo_servicio_id: {
			required: "Por favor, seleccione tipo de servicio"
		},
		codigo: {
			required: "Por favor, ingrese codigo"
		}
	}
});*/
/*
var db = {};

window.db = db;
db.detalle = [];

$("#ButtonServicio").click(function(event) {
	if ($('#ServicioForm').valid()) {
		saveContact();
	} else {
		validator.focusInvalid();
	}
});

function saveContact(button) {
	$("#ButtonServicio").attr('disabled', 'disabled');
	var l = Ladda.create(document.querySelector("#ButtonServicio"));
	l.start();
	var formData = $("#ServicioForm").serialize();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		url: "/servicios/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			window.location = "/servicios" 
		},
		always: function() {
			l.stop();
		},
		error: function() {
			alert("Ha ocurrido un problema, contacte a su administrador!!");
		}
		
	});
}
*/