var vale_table = $('#notac-table').DataTable({
    /*"ajax": "/pos_v2/venta/getJson",*/
    "ajax": "/nota_credito/getJson",
    "responsive": true,
    "processing": true,
    "serverSide": true,
    "info": true,
    "showNEntries": true,
    "dom": 'Bfrtip',
    "buttons": [
    {
        extend: 'pdfHtml5',
        exportOptions: {
            columns: [ 0, 1, 2, 3, 4, 5]
        }
    },
    'excelHtml5',
    'csvHtml5'
    ],
    "paging": true,
    "language": {
        "sProcessing":     "Procesando...",
        "sLengthMenu":     "Mostrar _MENU_ registros",
        "sZeroRecords":    "No se encontraron resultados",
        "sEmptyTable":     "Ningún dato disponible en esta tabla",
        "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix":    "",
        "sSearch":         "Buscar:",
        "sUrl":            "",
        "sInfoThousands":  ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
            "sFirst":    "Primero",
            "sLast":     "脷ltimo",
            "sNext":     "Siguiente",
            "sPrevious": "Anterior"
        },
        "oAria": {
            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        },
    },
    "order": [0, 'asc'],
    "columns": [ {
        "title": "Cod",
        "data": "no_nota",
        "width" : "5%",
        "responsivePriority": 1,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data);
        },
    }, {
        "title": "Cliente",
        "data": "cliente",
        "width" : "10%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data);
        },
    }, {
        "title": "Estado",
        "data": "estado_id",
        "width" : "20%",
        "responsivePriority": 5,
        "render": function( data, type, full, meta ) {
           if (full.estado_id == 1) {
            return CustomDatatableRenders.fitTextHTML('Generada');
        }
        if (full.estado_id == 2) {
            return CustomDatatableRenders.fitTextHTML('Anulada');
        }
    },
}, {
    "title": "Fecha",
    "data": "fecha",
    "width" : "10%",
    "responsivePriority": 5,
    "render": function( data, type, full, meta ) {
        return CustomDatatableRenders.fitTextHTML(data);
    },
},
{
    "title": "Tipo",
    "data": "tipo",
    "width" : "10%",
    "responsivePriority": 5,
    "render": function( data, type, full, meta ) {
        if (full.tipo == 1) {
            return CustomDatatableRenders.fitTextHTML('Descuento');
        }
        if (full.tipo == 2) {
            return CustomDatatableRenders.fitTextHTML('Pronto Pago');
        }
        if (full.tipo == 3) {
            return CustomDatatableRenders.fitTextHTML('Refacturación');
        }
    },
}, {
    "title": "Total Factura",
    "data": "monto",
    "width" : "10%",
    "responsivePriority": 5,
    "render": function( data, type, full, meta ) {
        return CustomDatatableRenders.fitTextHTML("Q." + parseFloat(Math.round(data * 100) / 100).toFixed(2));
    },
},  {
    "title": "Acciones",
    "orderable": false,
    "width" : "15%",
    "render": function(data, type, full, meta) {

        if (full.estado_id == 1) {
            return "<div id='" + full.id + "' class='text-center'>" + 
            "<div class='float-right col-lg-6'>" + 
            "<a target='_blank' href='/nota_credito/show/"+ full.no_nota +"' class='detalle-vale'>" + 
            "<i class='fa fa-btn fa-file-archive-o' title='Detalle'></i>" + 
            "</a>" + "</div>"
            + "<div class='float-right col-lg-6'>" + 
            "<a target='_blank' href='#' class='remove-producto'>" + 
            "<i class='fa fa-btn fa-trash' title='Anular Vale'></i>" + 
            "</a>" + "</div>";    
        }
        else {

            return "<div id='" + full.id + "' class='text-center'>" + 
            "<div class='float-right col-lg-6'>" + 
            "<a href='/nota_credito/show/"+ full.no_nota +"' class='detalle-vale'>" + 
            "<i class='fa fa-btn fa-file-archive-o' title='Detalle'></i>" + 
            "</a>" + "</div>";
        }
    },
    "responsivePriority": 2
}],
"createdRow": function(row, data, rowIndex) {
    $.each($('td', row), function(colIndex) {
        if (colIndex == 5) $(this).attr('id', data.no_nota);
    });
},
"fnPreDrawCallback": function( oSettings ) {
}
});


$('body').on('click', 'a.remove-producto', function(e) {
    $( ".confirm-delete" , "#userDeleteModal").removeAttr("field");
    var id = $(this).parent().parent().parent().attr("id");
    $("input[name='password_delete']").val("");
    unsetPasswordErrors("password_delete");
    var user = $(this).parent().parent().parent().parent().children().eq(0).text();
    $("#userDeleteModal").hide().show();
    $("#userDeleteModal").modal();
    
    $(".confirm-delete", "#userDeleteModal").attr("id", "delete-" + id);
});

function unsetPasswordErrors( input_name )
{
    $("#"+input_name+"-error").addClass("hidden");
    $("#"+input_name+"-error").text( "" );
    $("#"+input_name+"-error").parent().parent().removeClass("has-error");
}

function setPassworddErrors( input_name , text )
{
    $("#"+input_name+"-error").removeClass("hidden");
    $("#"+input_name+"-error").text( text );
    $("#"+input_name+"-error").parent().parent().addClass("has-error");
}

$('body').on('click', 'button.confirm-delete', function( e ) {
    e.preventDefault();
    var id  = $(this).attr("id").replace("delete-", "");

    var td  = $("#"+id);

    /*var url = "/pos_v2/venta/destroy/"+id;*/
    var url = "/nota_credito/remove/"+id;
    var password_delete = $("input[name='password_delete']").val().trim();
    data = {
        password_delete : password_delete
    };

    $("#user-created-message").addClass("hidden");

    $.ajax({
        method: "DELETE",
        url: url,
        data: JSON.stringify(data),
        headers: {'X-CSRF-TOKEN': $('#token').val()},
        contentType: "application/json",
    }).done(function (data){
        $(".user-created-message").removeClass("hidden");
        $(".user-created-message").addClass("alert-danger");
        $(".user-created-message").fadeIn();
        $(".user-created-message > p").text("Producto eliminado exitosamente!");
        vale_table.ajax.reload();
        $("#userDeleteModal").modal("hide");
    }).fail(function(errors) {
        var errors = JSON.parse(errors.responseText);
        if (errors.password_delete != null) setPassworddErrors("password_delete", errors.password_delete);
        else unsetPasswordErrors("password_delete");
    });
    return false;
});
