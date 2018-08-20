$('#fecha_nc').datetimepicker({
    format: 'YYYY-MM-DD',
    showClear: true,
    showClose: true
});

$('#fecha').datetimepicker({
    format: 'DD-MM-YYYY',
    showClear: true,
    showClose: true
});


$('#fechav').datetimepicker({
    format: 'DD-MM-YYYY',
    showClear: true,
    showClose: true
});

$('#fechag').datetimepicker({
    format: 'DD-MM-YYYY',
    showClear: true,
    showClose: true
});

$('#fechainicio').datetimepicker({
    format: 'DD-MM-YYYY',
    showClear: true,
    showClose: true
});

$('#fechafinal').datetimepicker({
    format: 'DD-MM-YYYY',
    showClear: true,
    showClose: true
});

$('#fechainiciocc').datetimepicker({
    format: 'DD-MM-YYYY',
    showClear: true,
    showClose: true
});

$('#fechafinalcc').datetimepicker({
    format: 'DD-MM-YYYY',
    showClear: true,
    showClose: true
});

var rptncs_table = $('#rptncs-table').DataTable({
    "ajax": "/sfi/rpt_ncs/getJson",
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
        "title": "Nota Crédito",
        "data": "id",
        "width" : "10%",
        "responsivePriority": 1,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data);
        },
    }, {
        "title": "Fecha",
        "data": "fecha",
        "width" : "15%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data);
        },
    }, {
        "title": "Nombres",
        "data": "nombres",
        "width" : "15%",
        "responsivePriority": 5,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data);
        },
    },{
        "title": "Apellidos",
        "data": "apellidos",
        "width" : "25%",
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
