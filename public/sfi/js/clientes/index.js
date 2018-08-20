var cliente_table = $('#cliente-table').DataTable({
    "ajax": "/sfi/cliente/getJson",
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
            columns: [ 0, 1, 2, 3, 4, 5,6]
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
        "title": "NIT",
        "data": "nit",
        "width" : "10%",
        "responsivePriority": 1,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data);
        },
    }, {
        "title": "Nombres",
        "data": "nombres",
        "width" : "20%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data);
        },
    }, {
        "title": "Apellidos",
        "data": "apellidos",
        "width" : "20%",
        "responsivePriority": 3,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data);
        },
    }, {
        "title": "Teléfonos",
        "data": "telefonos",
        "width" : "10%",
        "responsivePriority": 4,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data);
        },
    }, {
        "title": "Dirección",
        "data": "direccion",
        "width" : "20%",
        "responsivePriority": 5,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data);
        },
    }, {
        "title": "Estado",
        "data": "estado_cliente",
        "width" : "10%",
        "responsivePriority": 6,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data);
        },
    },{
        "title": "Acciones",
        "orderable": false,
        "width" : "10%",
        "render": function(data, type, full, meta) {

            if (full.estado_cliente == 'Activo') {
            return "<div id='" + full.id + "' class='text-center'>" + 
            "<div class='float-left col-lg-4'>" + 
            "<a href='/sfi/clientes/edit/"+ full.id +"' class='edit-cliente'>" + 
            "<i class='fa fa-btn fa-edit' title='Editar Cliente'></i>" + 
            "</a>" + "</div>" + 
            "<div class='float-right col-lg-4'>" + 
            "<a href='#' class='remove-cliente'>" + 
            "<i class='fa fa-btn fa-thumbs-o-down' title='Desactivar Cliente'></i>" + 
            "</a>" + "</div>" +
            "<div class='float-right col-lg-4'>" + 
            "<a href='#' class='bloq-cliente'>" + 
            "<i class='fa fa-btn fa-ban' title='Bloquear Cliente'></i>" + 
            "</a>" + "</div>";;
            }
            else if (full.estado_cliente == 'Inactivo') {
                return "<div id='" + full.id + "' class='text-center'>" + 
            "<div class='float-left col-lg-4'>" + 
            "<a href='#' class='activa-cliente'>" + 
            "<i class='fa fa-btn fa-thumbs-o-up' title='Activar Cliente'></i>" + 
            "</a>" + "</div>";;
            }
            else if (full.estado_cliente == 'Moroso') {
            return "<div id='" + full.id + "' class='text-center'>" + 
            "<div class='float-left col-lg-4'>" + 
            "<a href='#' class='remove-cliente'>" + 
            "<i class='fa fa-btn fa-thumbs-o-down' title='Desactivar Cliente'></i>" + 
            "</a>" + "</div>" + 
            "<div class='float-right col-lg-4'>" + 
            "<a href='#' class='bloq-cliente'>" + 
            "<i class='fa fa-btn fa-ban' title='Bloquear Cliente'></i>" + 
            "</a>" + "</div>";;
            }
            else if (full.estado_cliente == 'Bloqueado') {
                return "<div id='" + full.id + "' class='text-center'>" + 
            "<div class='float-left col-lg-4'>" + 
            "<a href='#' class='activa-cliente'>" + 
            "<i class='fa fa-btn fa-check-circle-o' title='Desbloquear Cliente'></i>" + 
            "</a>" + "</div>";;
            }

        },
        "responsivePriority": 2
    }],
    "createdRow": function(row, data, rowIndex) {
        $.each($('td', row), function(colIndex) {
            if (colIndex == 6) $(this).attr('id', data.id);
        });
    },
    "fnPreDrawCallback": function( oSettings ) {
    }
});



$('body').on('click', 'a.bloq-cliente', function(e) {
    $( ".confirm-bloq" , "#userBloqModal").removeAttr("field");
    var id = $(this).parent().parent().attr("id");
    $("input[name='password_bloq']").val("");
    unsetPasswordErrors("password_bloq");
    var user = $(this).parent().parent().parent().parent().children().eq(0).text();
    $("#userBloqModal").hide().show();
    $("#userBloqModal").modal();
    if (user.length = 1) {
        $("#message").text("este cliente?");
        $(".variable").text("");
        $(".entity").text("");
    } else {
        $("#message").text("este cliente");
        $(".variable").text("");
        $(".entity").text("");
    }
    $(".confirm-bloq", "#userBloqModal").attr("id", "bloq-" + id);
});



$('body').on('click', 'a.remove-cliente', function(e) {
    $( ".confirm-delete" , "#userDeleteModal").removeAttr("field");
    var id = $(this).parent().parent().attr("id");
    $("input[name='password_delete']").val("");
    unsetPasswordErrors("password_delete");
    var user = $(this).parent().parent().parent().parent().children().eq(0).text();
    $("#userDeleteModal").hide().show();
    $("#userDeleteModal").modal();
    if (user.length = 1) {
        $("#message").text("este cliente?");
        $(".variable").text("");
        $(".entity").text("");
    } else {
        $("#message").text("este cliente");
        $(".variable").text("");
        $(".entity").text("");
    }
    $(".confirm-delete", "#userDeleteModal").attr("id", "delete-" + id);
});

$('body').on('click', 'a.activa-cliente', function(e) {
    $( ".confirm-active" , "#userActiveModal").removeAttr("field");
    var id = $(this).parent().parent().attr("id");
    $("input[name='password_active']").val("");
    unsetPasswordErrors("password_active");
    var user = $(this).parent().parent().parent().parent().children().eq(0).text();
    $("#userActiveModal").hide().show();
    $("#userActiveModal").modal();
    if (user.length = 1) {
        $("#message").text("este cliente?");
        $(".variable").text("");
        $(".entity").text("");
    } else {
        $("#message").text("este cliente");
        $(".variable").text("");
        $(".entity").text("");
    }
    $(".confirm-active", "#userActiveModal").attr("id", "active-" + id);
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

    var url = "/sfi/clientes/remove/"+id;
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
        $(".user-created-message > p").text("Cliente inhabilitado exitosamente!");
        cliente_table.ajax.reload();
        $("#userDeleteModal").modal("hide");
    }).fail(function(errors) {
        var errors = JSON.parse(errors.responseText);
        if (errors.password_delete != null) setPassworddErrors("password_delete", errors.password_delete);
        else unsetPasswordErrors("password_delete");
    });
    return false;
});


$('body').on('click', 'button.confirm-bloq', function( e ) {
    e.preventDefault();
    var id  = $(this).attr("id").replace("bloq-", "");

    var td  = $("#"+id);

    var url = "/sfi/clientes/bloquear/"+id;
    var password_bloq = $("input[name='password_bloq']").val().trim();
    data = {
        password_bloq : password_bloq
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
        $(".user-created-message > p").text("Cliente bloqueado exitosamente!");
        cliente_table.ajax.reload();
        $("#userBloqModal").modal("hide");
    }).fail(function(errors) {
        var errors = JSON.parse(errors.responseText);
        if (errors.password_bloq != null) setPassworddErrors("password_bloq", errors.password_bloq);
        else unsetPasswordErrors("password_bloq");
    });
    return false;
});



$('body').on('click', 'button.confirm-active', function( e ) {
    e.preventDefault();
    var id  = $(this).attr("id").replace("active-", "");
    var td  = $("#"+id);
    var url = "/sfi/clientes/active/"+id;
    var password_active = $("input[name='password_active']").val().trim();
    data = {
        password_active : password_active
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
        $(".user-created-message > p").text("Cliente activado o desbloqueado exitosamente!");
        cliente_table.ajax.reload();
        $("#userActiveModal").modal("hide");
    }).fail(function(errors) {
        var errors = JSON.parse(errors.responseText);
        if (errors.password_active != null) setPassworddErrors("password_active", errors.password_active);
        else unsetPasswordErrors("password_active");
    });
    return false;
});

