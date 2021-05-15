
var validator = $("#reporte-form").validate({
	ignore: [],
	onkeyup:false,
	rules: {

		inicial: {
			required : true
        },
        final: {
			required : true
		}
	},
	messages: {
		inicial: {
			required: "Por favor, Seleccione Fecha inicial"
        },
        final: {
			required: "Por favor, Seleccione Fecha final"
        },
	}
});

$("#btn-reporte").click(function(event) {
	event.preventDefault();
	if ($('#reporte-form').valid()) {
        $("#btn-reporte").attr("disabled", true);
		generarreporte();
	} else {
		validator.focusInvalid();
	}
});

function generarreporte() {
	var inicial=$('#inicial').val();
    var final=$('#final').val();
	var cortes_caja_table = $('#Reporte-table').DataTable({
		"ajax": "/kardex2/getJson/"+inicial+'/'+final ,
		"responsive": true,
		"processing": true,
		"info": true,
		"showNEntries": true,
		"dom": 'Bfrtip',
		lengthMenu: [
			[ 10, 25, 50, -1 ],
			[ '10 filas', '25 filas', '50 filas', 'Mostrar todo' ]
		],
	
		"buttons": [
		'pageLength',
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
        "order": [2, 'desc'],
        "columns": [ 
        {
            "title": "Codigo de Barra",
            "data": "codigo_barra",
            "width" : "20%",
            "responsivePriority": 3,
            "render": function( data, type, full, meta ) {
                return (data); },
        }, 
        {
            "title": "Nombre producto",
            "data": "nombre",
            "width" : "20%",
            "responsivePriority": 3,
            "render": function( data, type, full, meta ) {
                return (data); },
        }, 
        {
            "title": "Fecha",
            "data": "fecha",
            "width" : "20%",
            "responsivePriority": 3,
            "render": function( data, type, full, meta ) {
                return (data); },
        }, 
        {
            "title": "Transaccion",
            "data": "transaccion",
            "width" : "20%",
            "responsivePriority": 3,
            "render": function( data, type, full, meta ) {
                return (data); },
        }, 
        {
            "title": "Ubicación",
            "data": "ubicacion",
            "width" : "20%",
            "responsivePriority": 3,
            "render": function( data, type, full, meta ) {
                return (data); },
        }, 
        {
            "title": "Cantidad Entrada",
            "data": "cantidad_ingreso",
            "width" : "20%",
            "responsivePriority": 3,
            "render": function( data, type, full, meta ) {
                return (data); },
        }, 
        {
            "title": "Cantidad Salida",
            "data": "cantidad_salida",
            "width" : "20%",
            "responsivePriority": 3,
            "render": function( data, type, full, meta ) {
                return (data); },
        }, 
        {
            "title": "Existencia Anterior",
            "data": "existencia_anterior",
            "width" : "20%",
            "responsivePriority": 3,
            "render": function( data, type, full, meta ) {
                return (data); },
        }, 
        {
            "title": "saldo",
            "data": "saldo",
            "width" : "20%",
            "responsivePriority": 3,
            "render": function( data, type, full, meta ) {
                return (data); },
        }, 
      
		{
            "title": "Costo Unitario",
            "data": "ponderado",
            "width" : "20%",
            "responsivePriority": 3,
            "render": function( data, type, full, meta ) {
                return ((parseFloat(data)).toFixed(2)); },
        }, 
        {
            "title": "Costo Entrada",
            "data": "entrada",
            "width" : "20%",
            "responsivePriority": 3,
            "render": function( data, type, full, meta ) {
                return ((parseFloat(data)).toFixed(2)); },
        }, 
        {
            "title": "Costo Salida",
            "data": "salida",
            "width" : "20%",
            "responsivePriority": 3,
            "render": function( data, type, full, meta ) {
                return ((parseFloat(data)).toFixed(2)); },
        }, 
        {
            "title": "Costo Anterior",
            "data": "anterior",
            "width" : "20%",
            "responsivePriority": 3,
            "render": function( data, type, full, meta ) {
                return ((parseFloat(data)).toFixed(2)); },
        }, 
        {
            "title": "Costo Acumulado",
            "data": "acumulado",
            "width" : "20%",
            "responsivePriority": 3,
            "render": function( data, type, full, meta ) {
                return ((parseFloat(data)).toFixed(2)); },
        }, 
    
		   
		],
		"createdRow": function(row, data, rowIndex) {
			$.each($('td', row), function(colIndex) {
				if (colIndex == 6) $(this).attr('id', data.id);
			});
		},
		"fnPreDrawCallback": function( oSettings ) {
		}
	});


	
}
$('#nuevo').click(function (e) { 
	e.preventDefault();
	location.reload();
	
});