var medidas_table = $('#medidas-table').DataTable({
    "ajax": "/sfi_tecu/medidas/getJson",
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
            columns: [ 0, 1, 2, 3, 4]
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
            "sLast":     "Último",
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
        "title": "No",
        "data": "id",
        "width" : "10%",
        "responsivePriority": 1,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data);
        },
    }, {
        "title": "Fecha",
        "data": "fecha_medida",
        "width" : "10%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data);
        },
    }, {
        "title": "Regla Super",
        "data": "med_regla_super",
        "width" : "10%",
        "responsivePriority": 5,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data);
        },
    },  {
        "title": "Regla Regular",
        "data": "med_regla_regular",
        "width" : "10%",
        "responsivePriority": 5,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data);
        },
    },  {
        "title": "Regla Diesel",
        "data": "med_regla_diesel",
        "width" : "10%",
        "responsivePriority": 5,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data);
        },
    },  {
        "title": "Tabla Super",
        "data": "med_tabla_super",
        "width" : "10%",
        "responsivePriority": 5,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML( parseFloat(Math.round(data * 100) / 100).toFixed(2));
        },
    },  {
        "title": "Tabla Regular",
        "data": "med_tabla_regular",
        "width" : "10%",
        "responsivePriority": 5,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(parseFloat(Math.round(data * 100) / 100).toFixed(2));
        },
    }, {
        "title": "Tabla Diesel",
        "data": "med_tabla_diesel",
        "width" : "10%",
        "responsivePriority": 5,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(parseFloat(Math.round(data * 100) / 100).toFixed(2));
        },
    },  {
        "title": "Acciones",
        "orderable": false,
        "width" : "20%",
        "render": function(data, type, full, meta) {

            return "<div id='" + full.id + "' class='text-center'>" + 
            "<div class='float-left col-lg-6'>" + 
            "<a href='/sfi_tecu/medidas/edit/"+ full.id +"' class='edit-medida'>" + 
            "<i class='fa fa-btn fa-edit' title='Editar Medida'></i>" + 
            "</div>" + "<div class='float-right col-lg-6'>" + 
            "<a href='#' class='remove-medida'>" + 
            "<i class='fa fa-btn fa-trash' title='Eliminar Medida'></i>" + 
            "</a>" + "</div>";;
        },
        "responsivePriority": 2
    }],
    "createdRow": function(row, data, rowIndex) {
        $.each($('td', row), function(colIndex) {
            if (colIndex == 7) $(this).attr('id', data.id);
        });
    },
    "fnPreDrawCallback": function( oSettings ) {
    }
});




$('body').on('click', 'a.remove-medida', function(e) {
    $( ".confirm-delete" , "#userDeleteModal").removeAttr("field");
    var id = $(this).parent().parent().attr("id");
    $("input[name='password_delete']").val("");
    unsetPasswordErrors("password_delete");
    var user = $(this).parent().parent().parent().parent().children().eq(0).text();
    $("#userDeleteModal").hide().show();
    $("#userDeleteModal").modal();
    if (user.length = 1) {
        $("#message").text("esta operacion?");
        $(".variable").text("");
        $(".entity").text("");
    } else {
        $("#message").text("esta operacion");
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

    var url = "/sfi_tecu/medidas/remove/"+id;
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
        $(".user-created-message > p").text("Medida de Tanque eliminada exitosamente!");
        medidas_table.ajax.reload();
        $("#userDeleteModal").modal("hide");
    }).fail(function(errors) {
        var errors = JSON.parse(errors.responseText);
        if (errors.password_delete != null) setPassworddErrors("password_delete", errors.password_delete);
        else unsetPasswordErrors("password_delete");
    });
    return false;
});
