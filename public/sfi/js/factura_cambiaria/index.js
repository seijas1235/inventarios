var vale_table = $('#factura-table').DataTable({
    "ajax": "/factura_cambiaria/getJson",
    "responsive": true,
    "processing": true,
    "serverSide": true,
    "info": true,
    "showNEntries": true,
    "dom": 'Bfrtip',
    "buttons": [ ],
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
    "order": [0, 'desc'],
    "columns": [ {
        "title": "No. Factura",
        "data": "no_factura",
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

        if (full.estado_id == 3) {
            return CustomDatatableRenders.fitTextHTML('Pagada');
        }

    },
}, {
    "title": "Fecha",
    "data": "fecha_factura",
    "width" : "10%",
    "responsivePriority": 5,
    "render": function( data, type, full, meta ) {
        return CustomDatatableRenders.fitTextHTML(data);
    },
}, {
    "title": "Total",
    "data": "total",
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
            "<a target='_blank' href='/factura_cambiaria/show/"+ full.id +"' class='detalle-vale'>" + 
            "<i class='fa fa-btn fa-file-archive-o' title='Detalle'></i>" + 
            "</a>" + "</div>"
            + "<div class='float-right col-lg-6'>" + 
            "<a href='#' class='remove-producto'>" + 
            "<i class='fa fa-btn fa-trash' title='Anular Factura C'></i>" + 
            "</a>" + "</div>";    
        }
        else {

            return "<div id='" + full.id + "' class='text-center'>" + 
            "<div class='float-right col-lg-6'>" + 
            "<a target='_blank' href='/factura_cambiaria/show/"+ full.id +"' class='detalle-vale'>" + 
            "<i class='fa fa-btn fa-file-archive-o' title='Detalle'></i>" + 
            "</a>" + "</div>";
        }
    },
    "responsivePriority": 2
}],
"createdRow": function(row, data, rowIndex) {
    $.each($('td', row), function(colIndex) {
        if (colIndex == 4) $(this).attr('id', data.id);
    });
},
"fnPreDrawCallback": function( oSettings ) {
}
});


$('body').on('click', 'a.remove-producto', function(e) {
    $( ".confirm-delete" , "#userDeleteModal").removeAttr("field");
    var id = $(this).parent().parent().attr("id");
    $("input[name='password_delete']").val("");
    unsetPasswordErrors("password_delete");
    var user = $(this).parent().parent().parent().parent().children().eq(0).text();
    $("#userDeleteModal").hide().show();
    $("#userDeleteModal").modal();
    if (user.length = 1) {
        $("#message").text("este producto?");
        $(".variable").text("");
        $(".entity").text("");
    } else {
        $("#message").text("este producto");
        $(".variable").text("");
        $(".entity").text("");
    }
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

    var url = "/factura_cambiaria/remove/"+id;
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
        $(".user-created-message > p").text("Factura C. anulada exitosamente!");
        vale_table.ajax.reload();
        $("#userDeleteModal").modal("hide");
    }).fail(function(errors) {
        var errors = JSON.parse(errors.responseText);
        if (errors.password_delete != null) setPassworddErrors("password_delete", errors.password_delete);
        else unsetPasswordErrors("password_delete");
    });
    return false;
});
