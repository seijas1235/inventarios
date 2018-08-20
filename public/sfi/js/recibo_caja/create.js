$(document).on("keypress", 'form', function (e) {
	var code = e.keyCode || e.which;
	if (code == 13) {
		e.preventDefault();
		return false;
	}
});



var tabla = $('#example').DataTable({
	"ajax": "/sfi/facturas_clientes/0/GetJson",
	"responsive": true,
	"processing": true,
	"serverSide": true,
	"paging":   false,
    "ordering": false,
	"info": true,
	"select": {
		"style": 'multi'
	},
	"showNEntries": true,
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
	"columns": [ {
			"title": "Vale",
			"data": "no_vale",
			"width" : "5%",
			"responsivePriority": 1,
			"render": function( data, type, full, meta ) {
				return CustomDatatableRenders.fitTextHTML(data);
			},
		}, {
			"title": "Total Vale",
			"data": "total_vale",
			"width" : "10%",
			"responsivePriority": 2,
			"render": function( data, type, full, meta ) {
				return CustomDatatableRenders.fitTextHTML("Q." + parseFloat(Math.round(data * 100) / 100).toFixed(2));

			},
		}, {
			"title": "Total Pagado",
			"data": "total_pagado",
			"width" : "10%",
			"responsivePriority": 2,
			"render": function( data, type, full, meta ) {
				return CustomDatatableRenders.fitTextHTML("Q." + parseFloat(Math.round(data * 100) / 100).toFixed(2));

			},
		}, {
			"title": "Total por Pagar",
			"data": "total_por_pagar",
			"width" : "10%",
			"responsivePriority": 2,
			"render": function( data, type, full, meta ) {
				return CustomDatatableRenders.fitTextHTML("Q." + parseFloat(Math.round(data * 100) / 100).toFixed(2));

			},
		}, {
			"title": "Estado Vale",
			"data": "estado",
			"width" : "10%",
			"responsivePriority": 2,
			"render": function( data, type, full, meta ) {
				return CustomDatatableRenders.fitTextHTML(data);

			},
	}]
});



$('#example tbody').on( 'click', 'tr', function () {
	$(this).toggleClass('selected');
} );



$("#cliente_id").change(function () {
	getVales();

});


function getVales() {

	var selected = [];

	tabla = $("#example").DataTable({
		'destroy': true
	});

	$('#example').dataTable().fnClearTable();


	tabla = $('#example').DataTable({
		'destroy': true,
		"ajax": "/sfi/facturas_clientes/" + $("#cliente_id").val() + "/GetJson",
		"responsive": true,
		"processing": true,
		"serverSide": true,
		"info": true,
	    "paging":   false,
    	"ordering": false,
		"select": {
			"style": 'multi'
		},
		"showNEntries": true,
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
			"columns": [ {
			"title": "Vale",
			"data": "no_vale",
			"width" : "5%",
			"responsivePriority": 1,
			"render": function( data, type, full, meta ) {
				return CustomDatatableRenders.fitTextHTML(data);
			},
		}, {
			"title": "Total Vale",
			"data": "total_vale",
			"width" : "10%",
			"responsivePriority": 2,
			"render": function( data, type, full, meta ) {
				return CustomDatatableRenders.fitTextHTML("Q." + parseFloat(Math.round(data * 100) / 100).toFixed(2));

			},
		}, {
			"title": "Total Pagado",
			"data": "total_pagado",
			"width" : "10%",
			"responsivePriority": 2,
			"render": function( data, type, full, meta ) {
				return CustomDatatableRenders.fitTextHTML("Q." + parseFloat(Math.round(data * 100) / 100).toFixed(2));

			},
		}, {
			"title": "Total por Pagar",
			"data": "total_por_pagar",
			"width" : "10%",
			"responsivePriority": 2,
			"render": function( data, type, full, meta ) {
				return CustomDatatableRenders.fitTextHTML("Q." + parseFloat(Math.round(data * 100) / 100).toFixed(2));

			},
		}, {
			"title": "Estado Vale",
			"data": "estado",
			"width" : "10%",
			"responsivePriority": 2,
			"render": function( data, type, full, meta ) {
				return CustomDatatableRenders.fitTextHTML(data);

			},
		}]
	});



	$('#example tbody').on( 'click', 'tr', function () {

		var d = tabla.row( this ).data();

		var id = d.id;
		var index = $.inArray(id, selected);

		if ( index === -1 ) {
			selected.push( id );
		} else {
			selected.splice( index, 1 );
		}

	} );


	$("#siguientePaso").click(function(e) {


		if (selected.length == 0) {

			bootbox.alert("Debe de seleccionar como mìnimo un  vale");
		}

		else {
			var form = document.createElement("form");
			var element1 = document.createElement("input");  
			var element2 = document.createElement("input");  
			var element3 = document.createElement("input");  



			form.method = "POST";
			form.action = "/sfi/recibo_caja/generar";   

			element1.value=selected;
			element1.name="selected";
			form.appendChild(element1); 


			element2.value= $("#token").val();
			element2.name="_token";
			form.appendChild(element2); 


			element3.value= $("#cliente_id").val();
			element3.name="cliente_id";
			form.appendChild(element3); 

			document.body.appendChild(form);

			form.submit();


		}
	});
}