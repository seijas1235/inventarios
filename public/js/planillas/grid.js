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


$(document).on("keypress", '#ButtonDetalle', function (e) {
    var code = e.keyCode || e.which;
    if (code == 13) {
        e.preventDefault();
        return false;
    }
});


$("input[name='empleado_id']").focusout(function() {
    var codigo = $("input[name='empleado_id'] ").val();
    var url = "/empleados/get/?data=" + codigo;    
        $.getJSON( url , function ( result ) {
            if (result == 0 ) {
                $("input[name='nombre'] ").val("");
                $("input[name='apellido'] ").val("");
                $("input[name='sueldo'] ").val("");
                $("input[name='igss'] ").val("");
            }
            else {
                $("input[name='nombre'] ").val(result[0].nombre);
                $("input[name='apellido'] ").val(result[0].apellido);
                $("input[name='sueldo'] ").val(result[0].sueldo);
                var igss = $("input[name='sueldo'] ").val() *4.83/100;
                $("input[name='igss'] ").val(igss);
            }
        });
    });


/*$("input[name='cantidad']").focusout(function() {
    var cantidad = $("input[name='cantidad'] ").val();
    var precio_compra = $("input[name='precio_compra'] ").val();

    var subtotal = cantidad * precio_compra;
    if (cantidad != 0 ) {
        $("input[name='subtotal'] ").val(subtotal);
    }
    else 
        $("input[name='subtotal'] ").val("0");
    return false;
})*/


$('body').on('click', '#addDetalle', function(e) {

    var detalle = new Object();
    var sueldo = $("input[name='sueldo'] ").val();
    var horas_extra = $("input[name='horas_extra'] ").val();
    var bono_incentivo = $("input[name='bono_incentivo'] ").val();
    var id = $("input[name='empleado_id'] ").val();
    var igss = sueldo * 4.83/100;
    var monto_hora_extra = horas_extra * (sueldo/30*1.5); 
    var subtotal = sueldo + bono_incentivo+ monto_hora_extra - igss;

    if (sueldo != ""  && id != "")
    {
        $("input[name='subtotal'] ").val(subtotal);
        $("input[name='monto_hora_extra'] ").val(monto_hora_extra);
        detalle.sueldo = $("input[name='sueldo'] ").val();
        detalle.monto_hora_extra = $("input[name='monto_hora_extra'] ").val();
        detalle.subtotal_planilla = $("input[name='subtotal'] ").val();
        detalle.empleado_id  = $("input[name='empleado_id'] ").val();
        detalle.nombre = $("input[name='nombre'] ").val();
        detalle.apellido = $("input[name='apellido'] ").val();
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
        $("input[name='empleado_id'] ").val("");
        $("input[name='nombre'] ").val("");
        $("input[name='horas_extra'] ").val("");
        $("input[name='apellido'] ").val("");
        $("input[name='monto_hora_extra'] ").val("");
        $("input[name='subtotal'] ").val("");
        $("#planilla-grid .jsgrid-search-button").trigger("click");    
    }
    else 
    {
        alert("Verifique que el nombre del empleado no este en blanco");
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
            var subtotal = parseFloat(deletingLink.subtotal_planilla);
            var total = total2 - subtotal;
            var total3 = $("input[name='total'] ").val(total);
            this.links.splice(linkIndex, 1);
        }

    };
    window.db = db;
    db.links = [];

    function saveDetalle(button) {
        var total_planilla = $("input[name='total'] ").val();
        var fecha = $("#fecha").val();
        if ( fecha != '') 
        {
            var formData = {total_planilla: total_planilla, fecha: fecha} 
                $.ajax({
                    type: "GET",
                    /*url: "../pos_v2/compras/save/",*/
                    url: "/planillas/save/",
                    data: formData,
                    dataType: "json",
                    success: function(data) {
                        var detalle = data;
                        $.ajax({
                            /*url: "/pos_v2/compras-detalle/" + detalle.id,*/
                            url: "/planillas-detalle/" + detalle.id,
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

            $("#planilla-grid").jsGrid({
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
                { title: "Codigo", name: "empleado_id", type: "text", visible:false},
                { title: "Codigo2", name: "maquinaria_equipo_id", type: "text", visible:false},
                { title: "Cantidad", name: "cantidad", type: "text"},
                { title: "Precio Compra", name: "precio_compra", type: "text"},
                { title: "Precio Venta", name: "horas_extra", type: "text"},
                { title: "Subtotal", name: "subtotal_planilla", type: "text"},
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