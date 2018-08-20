$(document).on("keypress", 'form', function (e) {
	var code = e.keyCode || e.which;
	if (code == 13) {
		e.preventDefault();
		return false;
	}
});



$("#siguientePaso").click(function(e) {


	var form = document.createElement("form");
	var element1 = document.createElement("input");  
	var element2 = document.createElement("input");  
	var element3 = document.createElement("input");  


	form.method = "POST";
	form.action = "/factura_cambiaria/generar2";   


	element2.value= $("#token").val();
	element2.name="_token";
	form.appendChild(element2); 


	element3.value= $("#cliente_id").val();
	element3.name="cliente_id";
	form.appendChild(element3); 

	document.body.appendChild(form);

	form.submit();

		});