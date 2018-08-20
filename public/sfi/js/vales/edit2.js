$(document).on("keypress", 'form', function (e) {
	var code = e.keyCode || e.which;
	if (code == 13) {
		e.preventDefault();
		return false;
	}
});

$(document).on("keypress", '#ButtonVale', function (e) {
	var code = e.keyCode || e.which;
	if (code == 13) {
		e.preventDefault();
		return false;
	}
});


$(document).on("keypress", '#ButtonCombustible', function (e) {
	var code = e.keyCode || e.which;
	if (code == 13) {
		e.preventDefault();
		return false;
	}
});


$(document).on("keypress", '#ButtonProducto', function (e) {
	var code = e.keyCode || e.which;
	if (code == 13) {
		e.preventDefault();
		return false;
	}
});

$('#fecha_corte').datetimepicker({
    format: 'DD-MM-YYYY',
    showClear: true,
    showClose: true
});

function saveVale() {
	$.LoadingOverlay("show");
	var piloto = $("input[name='piloto").val();
	var placa = $("input[name='placa").val();
	var tipo_vehiculo_id = $("#tipo_vehiculo_id").val();
	var cliente_id = $("#cliente_id").val();
	var fecha_corte = $("input[name='fecha_corte").val();
	var codigo_corte = $("input[name='codigo_corte").val();
	var no_vale = $("input[name='no_vale").val();
	var total_vale = $("input[name='total_vale").val();
	var total_por_pagar = $("input[name='total_por_pagar").val();

	var vale_id = $("input[name='vale_id").val();

	var formData = {
		piloto: piloto, 
		total_vale: total_vale, 
		total_por_pagar: total_por_pagar, 
		placa: placa, 
		no_vale: no_vale, 
		cliente_id: cliente_id, 
		tipo_vehiculo_id : tipo_vehiculo_id,
		fecha_corte : fecha_corte,
		codigo_corte : codigo_corte
	}  
	$.ajax({
		type: "GET",
		url: "/sfi/vales/saveedit/" + vale_id,
		data: formData,
		async: false,
		dataType: 'json',
		success: function(data) {
			window.location = "/sfi/vales";
			
		},
		error: function() {
			alert("Ha ocurrido un error");
			$.LoadingOverlay("hide");
		}
	});

}

$("#ButtonVale").click(function(e) {
	var placa = $("input[name='placa").val();
	var tipo_v = $("#tipo_vehiculo_id").val();
	var fecha_corte = $("input[name='fecha_corte").val();
	var codigo_corte = $("input[name='codigo_corte").val();
	var piloto = $("input[name='piloto").val();


	e.preventDefault();

	if (placa && piloto && tipo_v && fecha_corte && codigo_corte) {
		saveVale();
	} 
	else {
		bootbox.alert("Debe de seleccionar una bomba,un cliente, placa, piloto, vehiculo y un producto");
	}
});

