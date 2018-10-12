$(document).on("keypress", 'form', function (e) {
    var code = e.keyCode || e.which;
    if (code == 13) {
        e.preventDefault();
        return false;
    }
});

$(document).on("keypress", '#addDetalle', function (e) {
    var code = e.keyCode || e.which;
    if (code == 13) {
        e.preventDefault();
        return false;
    }
});

$(document).on("keypress", '#addDetalleServicio', function (e) {
	var code = e.keyCode || e.which;
	if (code == 13) {
		e.preventDefault();
		return false;
	}
});



$(document).on("keypress", '#ButtonDetalle', function (e) {
    var code = e.keyCode || e.which;
    if (code == 13) {
        e.preventDefault();
        return false;
    }
});



$("input[name='codigo_barra']").focusout(function() {
    var codigo = $("input[name='codigo_barra'] ").val();
    /*var url = "../pos_v2/venta/get/?data=" + codigo;*/
    var url = "/../venta/get/?data=" + codigo;
        $.getJSON( url , function ( result ) {
            if (result == 0 ) {
                $("input[name='descripcion'] ").val("");
                $("input[name='precio_venta'] ").val("");
                $("input[name='precio_compra'] ").val("");
                $("input[name='cantidad'] ").val(1);
                $("#total_existencia").text("El producto no existe, está agotado, en existencia mínima o desactivado");
            }
            else {
                $("input[name='descripcion'] ").val(result[0].nombre);
                $("input[name='precio_venta'] ").val(result[0].precio_venta);
                $("input[name='precio_compra'] ").val(result[0].precio_compra);
                $("input[name='existencias'] ").val(result[0].existencias);
                $("input[name='cantidad'] ").val(1);
                $("input[name='producto_id'] ").val(result[0].prod_id);
                $("input[name='movimiento_id'] ").val(result[0].producto_id);
                $("#total_existencia").text("La existencia del producto con el precio Q." + result[0].precio_venta + " es de:" + result[0].existencias);
            }
        });
    });


$("input[name='efectivo']").focusout(function() {
    var total = $("input[name='total'] ").val();
    var efectivo = $("input[name='efectivo']").val();
    var cambio = efectivo - total;
    $("input[name='cambio'] ").val("Q."+ cambio);
});

$("input[name='cantidad']").focusout(function() {
    var cantidad = $("input[name='cantidad'] ").val();
    var precio_venta = $("input[name='precio_venta'] ").val();

    var subtotal = cantidad * precio_venta;
    if (cantidad != 0 ) {
        $("input[name='subtotal'] ").val(subtotal);
    }
    else 
        $("input[name='subtotal'] ").val("0");
    return false;
})

$('body').on('click', '#addDetalle', function(e) 
{
    var l = Ladda.create( document.querySelector( '#addDetalle' ) );
    l.start();
    l.setProgress( 0.5 );
    if($("input[name='venta_maestro']").val() == "") 
    {
        var total_venta = $("input[name='total'] ").val();
        var tipo_pago_id = $("#tipo_pago_id").val();
        var cliente_id = $("#cliente_id").val();
        var formData = {total_venta: total_venta, tipo_pago_id : tipo_pago_id,cliente_id : cliente_id}  
        $.ajax({
            type: "GET",
            /*url: "../pos_v2/venta/save/",*/
            url: "/venta/save/",
            data: formData,
            async:false,
            dataType: 'json',
            success: function(data) {
                var detalle = data;
                $("input[name='venta_maestro'] ").val(data.id);
            },
            error: function() {
                alert("Something went wrong, please try again!");
            }
        });
    }
   
    if (parseInt($("input[name='existencias'] ").val()) >= parseInt($("input[name='cantidad'] ").val()))
    {

        if ($("input[name='descripcion'] ").val() != "" && $("input[name='cantidad'] ").val() != "")
        {

            var detalle = new Object();
            var cantidad = $("input[name='cantidad'] ").val();
            var precio_venta = $("input[name='precio_venta'] ").val();
            var subtotal = cantidad * precio_venta;
            $("input[name='subtotal'] ").val(subtotal);
            detalle.cantidad = $("input[name='cantidad'] ").val();
            detalle.precio_venta = $("input[name='precio_venta'] ").val();
            detalle.subtotal_venta = $("input[name='subtotal'] ").val();
            detalle.producto_id  = $("input[name='producto_id'] ").val();
            detalle.movimiento_id  = $("input[name='movimiento_id'] ").val();
            detalle.codigoballa = $("input[name='codigo_barra'] ").val();
            detalle.nombre = $("input[name='descripcion'] ").val();
            detalle.precio_compra = $("input[name='precio_compra'] ").val();
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

            dbs.detalles.push(detalle);
            $("input[name='producto_id'] ").val("");
            $("input[name='codigo_barra'] ").val("");
            $("input[name='descripcion'] ").val("");
            $("input[name='precio_venta'] ").val("");
            $("input[name='precio_compra'] ").val("");
            $("input[name='cantidad'] ").val(1);
            var cantidad = $("input[name='cantidad'] ").val();
            var precio_venta = $("input[name='precio_venta'] ").val();
            var subtotal = cantidad * precio_venta;
            $("input[name='subtotal'] ").val(subtotal);
            var venta_maestro = $("input[name='venta_maestro'] ").val();
            if($("input[name='venta_maestro']").val() != "") {       
                $.ajax({
                    /*url: "/pos_v2/venta-detalle/" + venta_maestro,*/
                    url: "/venta-detalle/" + venta_maestro,
                    type: "POST",
                    contentType: "application/json",
                    data: JSON.stringify(dbs.detalles),
                    success: function(addressResponse) {
                        detalle.venta_detalle = addressResponse.id
                        db.links.push(detalle);
                        $("#detalle-grid .jsgrid-search-button").trigger("click");
                        dbs.detalles = "";
                        window.dbs = dbs;
                        dbs.detalles = [];
                    },
                    always: function() {
                    }
                });
            }
            $("#detalle-grid .jsgrid-search-button").trigger("click");
        }
        else {
            alert("Especifique un producto valido o cantidad");
        }
    }
    else {
        alert("No se puede realizar la venta, revise las existencias del producto");
    }
    l.stop();
});
//obtener nit y direccion de cliente
function changeCliente() {
    var cliente_id = $("#cliente_id").val();
    
    var url = "/cliente/datos/" + cliente_id ;
    if (cliente_id != "") {
        $.getJSON( url , function ( result ) {
            $("input[name='nit_c'] ").val(result.nit);
            $("input[name='direccion']").val(result.direccion);			
        });
    }
}
    

$("#cliente_id").change(function () {
    changeCliente();
});


// agregar servicio a modificar
function changeService() {
    var servicio_id = $("#servicio_id").val();
    var cantidad = $("input[name='cantidad_s").val();
    var url = "/servicio/precio/" + servicio_id ;
    if (servicio_id != "") {
        $.getJSON( url , function ( result ) {
            $("input[name='precio'] ").val(result.precio);
            $("input[name='subtotal_s']").val(result.precio * cantidad);			
        });
    }
}
    
$("input[name='cantidad_s").change(function () {

    var cantidad = $("input[name='cantidad_s").val();
    var precio = $("input[name='precio").val();
    $("input[name='subtotal_s']").val(precio * cantidad);
});
$("#servicio_id").change(function () {
    changeService();
});

$('body').on('click', '#addDetalleServicio', function(e) 
{
    var l = Ladda.create( document.querySelector( '#addDetalleServicio' ) );
    l.start();
    l.setProgress( 0.5 );
    if($("input[name='venta_maestro']").val() == "") 
    {
        var total_venta = $("input[name='total'] ").val();
        var tipo_pago_id = $("#tipo_pago_id").val();
        var cliente_id = $("#cliente_id").val();
        var formData = {total_venta: total_venta, tipo_pago_id : tipo_pago_id,cliente_id : cliente_id} 
       
        $.ajax({
            type: "GET",
            url: "/venta/save/",
            data: formData,
            async:false,
            dataType: 'json',
            success: function(data) {
                var detalle = data;
                $("input[name='venta_maestro'] ").val(data.id);
            },
            error: function() {
                alert("Something went wrong, please try again!");
            }
        });
    }
    
        
    if ($("input[name='precio'] ").val() != "" && $("input[name='cantidad_s'] ").val() != "")
    {
        var detalle = new Object();
        var cantidad = $("input[name='cantidad_s'] ").val();
        var precio_venta =$("input[name='precio'] ").val(); ;
        var precio_compra = 0;
        var id =  $("#servicio_id").val();
        var subtotal = cantidad * precio_venta; 
        $("input[name='subtotal_s'] ").val(subtotal);
        detalle.cantidad = $("input[name='cantidad_s'] ").val();
        detalle.precio_venta = $("input[name='precio'] ").val();;
        detalle.precio_compra = 0;
        detalle.subtotal_venta = $("input[name='subtotal_s'] ").val();
        detalle.servicio_id  = $("#servicio_id").val();
        detalle.nombre = $("#servicio_id").find("option:selected").text();
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

        dbs.detalles.push(detalle);
        $("#servicio_id").val("");
        $("#servicio_id").selectpicker(0, '');
        $('#servicio_id').selectpicker('render');
        $("input[name='nombre'] ").val("");
        $("input[name='precio'] ").val("");
        $("input[name='precio_compra'] ").val("");
        $("input[name='cantidad_s'] ").val([""]);
        var cantidad = $("input[name='cantidad_s'] ").val();
        var precio_compra = 0;
        var subtotal = cantidad * precio_venta;
        var venta_maestro = $("input[name='venta_maestro'] ").val();
        if($("input[name='venta_maestro']").val() != "") {       
            $.ajax({
                /*url: "/pos_v2/venta-detalle/" + venta_maestro,*/
                url: "/venta-detalle/" + venta_maestro,
                type: "POST",
                contentType: "application/json",
                data: JSON.stringify(dbs.detalles),
                success: function(addressResponse) {
                    detalle.venta_detalle = addressResponse.id
                    db.links.push(detalle);
                    $("#detalle-grid .jsgrid-search-button").trigger("click");
                    dbs.detalles = "";
                    window.dbs = dbs;
                    dbs.detalles = [];
                },
                always: function() {
                }
            });
        }$("#detalle-grid .jsgrid-search-button").trigger("click");
            
    }
    else {
    bootbox.alert("Debe de seleccionar un Servicio");
    }

});



//funcion indefinida
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
            if(deletingLink.movimiento_id>0){
                $.ajax({
                    type: "DELETE",
                    /*url: "/pos_v2/ventadetalle2/destroy/"+ deletingLink.venta_detalle+ "/" + deletingLink.movimiento_id,*/
                    url: "/ventadetalle2/destroy/"+ deletingLink.venta_detalle+ "/" + deletingLink.movimiento_id,
                    data: deletingLink,
                    dataType: "json",
                    success: function(data) {
                        var detalle = data;
                    },
                    error: function() {
                        alert("Something went wrong, please try again!");
                    }
                }); 
            }else{
                $.ajax({
                    type: "DELETE",
                    /*url: "/pos_v2/ventadetalle2/destroy/"+ deletingLink.venta_detalle+ "/" + deletingLink.movimiento_id,*/
                    url: "/ventadetalle3/destroy/"+ deletingLink.venta_detalle,
                    data: deletingLink,
                    dataType: "json",
                    success: function(data) {
                        var detalle = data;
                    },
                    error: function() {
                        alert("Something went wrong, please try again!");
                    }
                }); 

            }
            var linkIndex = $.inArray(deletingLink, this.links);
            var total2 = $("input[name='total'] ").val();
            var total2 =parseFloat(total2);
            var subtotal = parseFloat(deletingLink.subtotal_venta);
            var total = total2 - subtotal;
            var total3 = $("input[name='total'] ").val(total);
            this.links.splice(linkIndex, 1);
        }

    };

    var dbs = {

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
            var total2 = $("input[name='total'] ").val();
            var total2 =parseFloat(total2);
            var subtotal = parseFloat(deletingLink.subtotal_venta);
            var total = total2 - subtotal;
            var total3 = $("input[name='total'] ").val(total);
            this.detalles.splice(linkIndex, 1);
        }

    };

    window.db = db;
    window.dbs = dbs;
    db.links = [];
    dbs.detalles = [];

    function saveDetalle(button) {
        var total_venta = $("input[name='total'] ").val();
        var tipo_pago_id = $("#tipo_pago_id").val();      
        var venta_maestro = $("input[name='venta_maestro'] ").val();
        var cliente_id = $("#cliente_id").val();
        var formData = {total_venta: total_venta, tipo_pago_id : tipo_pago_id, cliente_id : cliente_id} 
        if(tipo_pago_id==3){
            var fecha_venta= $("input[name='fecha_venta'] ").val();
            formData = {total_venta: total_venta, tipo_pago_id : tipo_pago_id, cliente_id : cliente_id,venta_maestro_id: venta_maestro,fecha_venta: fecha_venta}
            $.ajax({
                type: "GET",
                url: "/venta/savecpc/",
                data: formData,
                async:false,
                dataType: 'json',
                success: function(data) {
                    var detalle = data;
                    $("input[name='venta_maestro'] ").val(data.id);
                },
                error: function() {
                    alert("Something went wrong, please try again!");
                }
            });
        }
           
        $.ajax({
            type: "PATCH",
            /*url: "../pos_v2/venta/update-total/"+ venta_maestro+ "/",*/
            url: "/venta/update-total/"+ venta_maestro+ "/",
            data: formData,
            dataType: "json",
            success: function(data) {
                var detalle = data;
                /*window.location = "/pos_v2/ventas"*/
                window.location = "/ventas"
            },
            error: function() {
                alert("falla de guardado");
            }
        });
    }

    $("#ButtonDetalle").click(function(event) {
        saveDetalle();
    });



    
    $(document).ready(function () {

        $("#detalle-grid").jsGrid({
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
                { title: "Producto", name: "nombre", type: "text"},
                { title: "Código", name: "producto_id", type: "text", visible:false},
                { title: "Código2", name: "servicio_id", type: "text", visible:false},
                { title: "Precio2", name: "precio_compra", type: "text", visible:false},
                { title: "venta_detalle", name: "venta_detalle", type: "text", visible:false},
                { title: "movimiento", name: "movimiento_id", type: "text", visible:false},
                { title: "Cantidad", name: "cantidad", type: "text"},
                { title: "Precio", name: "precio_venta", type: "text"},
                { title: "Subtotal", name: "subtotal_venta", type: "text"},
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