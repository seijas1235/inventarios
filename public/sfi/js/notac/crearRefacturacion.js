$('#CreateNota').click( function (e) {
    	e.preventDefault();
    	saveNota();
    } );



    function saveNota() {

     $.LoadingOverlay("show");
    	var cliente_id = $("#cliente_id").val();
    	var monto = $("input[name='total").val();
    	var valores = $("#selected").val();
    	var token = $("#token").val();

    	var formData = {
    		monto: monto, cliente_id: cliente_id, detalle : valores
    	} 
    	$.ajax({
    		type: "GET",
    		url: "/nota_credito/refacturacion/save",
    		data: formData,
    		async: false,
    		dataType: 'json',
    		success: function(data) {
    				window.location = "/nota_credito";
    			},
    			error: function() {
    				alert("Ha ocurrido un error");
                    $.LoadingOverlay("hide");
    			}
    		});

    }
