$('#fecha_inicio').datetimepicker({
    format: 'YYYY-MM-DD',
    showClear: true,
    showClose: true
});

$('#fecha_fin').datetimepicker({
    format: 'YYYY-MM-DD',
    showClear: true,
    showClose: true
});

var rptvalesf_table = $('#rptvalesf-table').DataTable({
    "ajax": "/sfi_tecu/rpt_valestotal/getJson",
    "responsive": true,
    "processing": true,
    "serverSide": true,
    "info": true,
    "showNEntries": true,
    "dom": 'Bfrtip',
    "buttons": [  ],
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
            "sLast":     "Ultimo",
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
        "title": "Fecha",
        "data": "fecha",
        "width" : "15%",
        "responsivePriority": 1,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data);
        },
    }, {
        "title": "No Vale",
        "data": "cod",
        "width" : "15%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data);
        },
    }, {
        "title": "Nombres",
        "data": "nombres",
        "width" : "20%",
        "responsivePriority": 5,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data);
        },
    },{
        "title": "Apellidos",
        "data": "apellidos",
        "width" : "20%",
        "responsivePriority": 5,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data);
        },
    },{
        "title": "Total",
        "data": "tot",
        "width" : "15%",
        "responsivePriority": 5,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data);
        },
    },{
        "title": "Estado",
        "data": "estado",
        "width" : "15%",
        "responsivePriority": 5,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data);
        },
    }],
    "createdRow": function(row, data, rowIndex) {
        $.each($('td', row), function(colIndex) {
            if (colIndex == 5) $(this).attr('id', data.id);
        });
    },
    "fnPreDrawCallback": function( oSettings ) {
    }
});
