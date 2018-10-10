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

$(document).on("keypress", '#addDetalleMaquina', function (e) {
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
    var url = "/productos/get/?data=" + codigo;    
        $.getJSON( url , function ( result ) {
            if (result == 0 ) {
                $("input[name='nombre'] ").val("");
            }
            else {
                $("input[name='nombre'] ").val(result[0].nombre);
                $("input[name='producto_id'] ").val(result[0].producto_id);
            }
        });
    });

$("input[name='codigo_maquina']").focusout(function() {
    var codigo = $("input[name='codigo_maquina'] ").val();
    var url = "/maquinarias_equipo/get/?data=" + codigo;    
        $.getJSON( url , function ( result ) {
            if (result == 0 ) {
                $("input[name='nombre_maquina'] ").val("");
            }
            else {
                $("input[name='nombre_maquina'] ").val(result[0].nombre_maquina);
                $("input[name='maquinaria_equipo_id'] ").val(result[0].maquina_id);
            }
        });
    });


/*$("input[name='efectivo']").focusout(function() {
    var total = $("input[name='total'] ").val();
    var efectivo = $("input[name='efectivo']").val();
    var cambio = efectivo - total;
    $("input[name='cambio'] ").val("Q."+ cambio);
});*/

$("input[name='cantidad']").focusout(function() {
    var cantidad = $("input[name='cantidad'] ").val();
    var precio_compra = $("input[name='precio_compra'] ").val();

    var subtotal = cantidad * precio_compra;
    if (cantidad != 0 ) {
        $("input[name='subtotal'] ").val(subtotal);
    }
    else 
        $("input[name='subtotal'] ").val("0");
    return false;
})

$("input[name='cantidad_maquina']").focusout(function() {
    var cantidad = $("input[name='cantidad_maquina'] ").val();
    var precio_compra = $("input[name='precio_compra_maquina'] ").val();

    var subtotal = cantidad * precio_compra;
    if (cantidad != 0 ) {
        $("input[name='subtotalmaquina'] ").val(subtotal);
    }
    else 
        $("input[name='subtotalmaquina'] ").val("0");
    return false;
})

$('body').on('click', '#addDetalle', function(e) {

    var detalle = new Object();
    var cantidad = $("input[name='cantidad'] ").val();
    var precio_venta = $("input[name='precio_venta'] ").val();
    var precio_compra = $("input[name='precio_compra'] ").val();
    var id = $("input[name='producto_id'] ").val(); 
    var subtotal = cantidad * precio_compra;

    if (cantidad != "" && precio_venta != "" && precio_compra != "" && id != "")
    {
        $("input[name='subtotal'] ").val(subtotal);
        detalle.cantidad = $("input[name='cantidad'] ").val();
        detalle.precio_venta = $("input[name='precio_venta'] ").val();
        detalle.precio_compra = $("input[name='precio_compra'] ").val();
        detalle.subtotal_venta = $("input[name='subtotal'] ").val();
        detalle.producto_id  = $("input[name='producto_id'] ").val();
        detalle.codigo_barra = $("input[name='codigo_barra'] ").val();
        detalle.nombre = $("input[name='nombre'] ").val();
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
        $("input[name='producto_id'] ").val("");
        $("input[name='codigo_barra'] ").val("");
        $("input[name='nombre'] ").val("");
        $("input[name='precio_venta'] ").val("");
        $("input[name='precio_compra'] ").val("");
        $("input[name='cantidad'] ").val([""]);
        var cantidad = $("input[name='cantidad'] ").val();
        var precio_venta = $("input[name='precio_venta'] ").val();
        var subtotal = cantidad * precio_compra;
        $("input[name='subtotal'] ").val(subtotal);
        $("#compradetalle-grid .jsgrid-search-button").trigger("click");    
    }
    else 
    {
        alert("Verifique que el nombre del producto, la cantidad, el precio de compra y el precio de venta no esten vacios");
    }
    
});

$('body').on('click', '#addDetalleMaquina', function(e) {

    var detalle = new Object();
    var cantidad = $("input[name='cantidad_maquina'] ").val();
    var precio_venta = 0;
    var precio_compra = $("input[name='precio_compra_maquina'] ").val();
    var id = $("input[name='maquinaria_equipo_id'] ").val(); 
    var subtotal = cantidad * precio_compra;

    if (cantidad != "" && precio_compra != "" && id != "")
    {
        $("input[name='subtotalmaquina'] ").val(subtotal);
        detalle.cantidad = $("input[name='cantidad_maquina'] ").val();
        detalle.precio_venta = 0;
        detalle.precio_compra = $("input[name='precio_compra_maquina'] ").val();
        detalle.subtotal_venta = $("input[name='subtotalmaquina'] ").val();
        detalle.maquinaria_equipo_id  = $("input[name='maquinaria_equipo_id'] ").val();
        detalle.codigo_maquina = $("input[name='codigo_maquina'] ").val();
        detalle.nombre = $("input[name='nombre_maquina'] ").val();
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
        $("input[name='maquinaria_equipo_id'] ").val("");
        $("input[name='codigo_maquina'] ").val("");
        $("input[name='nombre_maquina'] ").val("");
        $("input[name='precio_venta'] ").val("");
        $("input[name='precio_compra_maquina'] ").val("");
        $("input[name='cantidad_maquina'] ").val([""]);
        var cantidad = $("input[name='cantidad_maquina'] ").val();
        var precio_venta = 0;
        var subtotal = cantidad * precio_compra;
        $("input[name='subtotal'] ").val(subtotal);
        $("#compradetalle-grid .jsgrid-search-button").trigger("click");    
    }
    else 
    {
        alert("Verifique que el nombre del producto, la cantidad, el precio de compra y el precio de venta no esten vacios");
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
            var subtotal = parseFloat(deletingLink.subtotal_venta);
            var total = total2 - subtotal;
            var total3 = $("input[name='total'] ").val(total);
            this.links.splice(linkIndex, 1);
        }

    };
    window.db = db;
    db.links = [];

    function saveDetalle(button) {
        var total_factura = $("input[name='total'] ").val();
        var fecha_factura = $("#fecha_factura").val();
        var proveedor_id = $("#proveedor_id").val();
        var tipo_pago_id = $("#tipo_pago_id").val();
        var serie_factura = $("#serie_factura").val();
        var num_factura = $("#num_factura").val();
        if ( fecha_factura != '') 
        {
            var formData = {total_factura: total_factura, proveedor_id : proveedor_id, fecha_factura: fecha_factura,
                serie_factura : serie_factura, num_factura :num_factura, tipo_pago_id : tipo_pago_id} 
                $.ajax({
                    type: "GET",
                    /*url: "../pos_v2/compras/save/",*/
                    url: "/compras/save/",
                    data: formData,
                    dataType: "json",
                    success: function(data) {
                        var detalle = data;
                        $.ajax({
                            /*url: "/pos_v2/compras-detalle/" + detalle.id,*/
                            url: "/compras-detalle/" + detalle.id,
                            type: "POST",
                            contentType: "application/json",
                            data: JSON.stringify(db.links),
                            success: function(addressResponse) {
                                if (addressResponse.result == "ok") {
                            /*window.location = "/pos_v2/compras"*/
                            window.location = "/compras"
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
            else
            {
                alert ('Especifique la fecha de la factura');
            }

        }

        $("#ButtonDetalle").click(function(event) {
            saveDetalle();
        });


        $(document).ready(function () {

            $("#compradetalle-grid").jsGrid({
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
                { title: "Codigo", name: "producto_id", type: "text", visible:false},
                { title: "Codigo2", name: "maquinaria_equipo_id", type: "text", visible:false},
                { title: "Cantidad", name: "cantidad", type: "text"},
                { title: "Precio Compra", name: "precio_compra", type: "text"},
                { title: "Precio Venta", name: "precio_venta", type: "text"},
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