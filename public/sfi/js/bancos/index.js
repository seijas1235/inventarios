var banco_table = $('#banco-table').DataTable({
    "ajax": "/sfi/bancos/getJson",
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
            columns: [ 0, 1, 2, 3, 4, 5, 6]
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
        "title": "Código",
        "data": "id",
        "width" : "10%",
        "responsivePriority": 1,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data);
        },
    }, {
        "title": "Banco",
        "data": "banco",
        "width" : "25%",
        "responsivePriority": 5,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data);
        },
    },{
        "title": "Acciones",
        "orderable": false,
        "width" : "10%",
        "render": function(data, type, full, meta) {
            if (full.estado_empleado != "Inactivo") {
               return "<div id='" + full.id + "' class='text-center'>" + 
               "<div class='float-left col-lg-6'>" + 
               "<a href='/sfi/bancos/edit/"+ full.id +"' class='edit-banco'>" + 
               "<i class='fa fa-btn fa-edit' title='Editar'></i>" + 
               "</div>" + "<div class='float-right col-lg-6'>" + 
               "<a href='/sfi/bancos/remove/"+ full.id +"' class='remove-banco'>" + 
               "<i class='fa fa-btn fa-trash' title='Desactivar'></i>" + 
               "</a>" + "</div>";;
           }
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