$(document).on("keypress", 'form', function (e) {
	var code = e.keyCode || e.which;
	if (code == 13) {
		e.preventDefault();
		return false;
	}
});



var tabla = $('#example').DataTable({
	
});

var selected = [];



$('#example tbody').on( 'click', 'tr', function () {
	$(this).toggleClass('selected');
} );




$('#example tbody').on( 'click', 'tr', function () {

	var d = tabla.row( this ).data();

	var id = d[0];
	var index = $.inArray(id, selected);

	if ( index === -1 ) {
		selected.push( id );
	} else {
		selected.splice( index, 1 );
	}

} );


$("#siguientePaso").click(function(e) {


	var form = document.createElement("form");
	var element1 = document.createElement("input");  
	var element2 = document.createElement("input");  
	var element3 = document.createElement("input"); 
	var element4 = document.createElement("input");   



	form.method = "POST";
	form.action = "/sfi/recibo_caja/generar";   

	element1.value=selected;
	element1.name="notas";
	form.appendChild(element1); 


	element2.value= $("#token").val();
	element2.name="_token";
	form.appendChild(element2); 


	element3.value= $("#cliente_id").val();
	element3.name="cliente_id";
	form.appendChild(element3); 

	element4.value= $("#selected").val();
	element4.name="selected";
	form.appendChild(element4);

	document.body.appendChild(form);

	form.submit();


		});