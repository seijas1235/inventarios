    var table = $('#example').DataTable();
    var db = {};
    db.selected = [];
    var sumaGalones = 0;
    var total = 0;

    $('#example tbody').on( 'click', 'tr', function () {
    	$(this).toggleClass('selected');

    	var galones = Number(this.attributes[0].value);
    	var tasa = $("#tasa").val();
    	var tasa1 = $("#tasa1").val();
    	var estado = this.cells[4].innerText;
    	if (estado == "Creado") {

    		var precio = parseFloat(galones).toFixed(2) * parseFloat(tasa).toFixed(2);
    	}

    	else {
    		var precio = parseFloat(galones).toFixed(2) * parseFloat(tasa1).toFixed(2);
    	}


    	var d = table.row( this ).data();

    	var id = d[0];
    	var index = $.inArray(id, db.selected);

    	var index = $.grep(db.selected, function(e){ return e.id == id; });
    	var data = new Object();
    	data.id = id;
    	data.cantidad= galones;
    	data.subtotal= precio;

    	if ( index.length == 0 ) {
    		db.selected.push( data );
    		sumaGalones = (sumaGalones) + parseFloat(galones.toPrecision(4));
    		total = total + precio;
    	} else {
    		db.selected.splice( index, 1 );
    		sumaGalones = (sumaGalones) - parseFloat(galones.toPrecision(4));
    		total = total - precio;
    	}
    	$("#descuento_vales").val(sumaGalones.toPrecision(4));
    	$("#dinero_descuento").val(total.toPrecision(4));

    } );

    $('#CreateNota').click( function (e) {
    	e.preventDefault();
    	saveVale();
    } );



    function saveVale() {


    	var cliente_id = $("#cliente_id").val();
    	var monto = $("input[name='dinero_descuento").val();
    	var mantener = $("#mantener").val();
    	var token = $("#token").val();
    	var tasa = $("#token").val();

    	var formData = {
    		monto: monto, mantener: mantener, cliente_id: cliente_id, detalle : db.selected, tasa: tasa
    	} 
    	$.ajax({
    		type: "GET",
    		url: "/nota_credito/descuento/save",
    		data: formData,
    		async: false,
    		dataType: 'json',
    		success: function(data) {
    				window.location = "/nota_credito";
    			},
    			error: function() {
    				alert("Ha ocurrido un error");
    			}
    		});

    }


