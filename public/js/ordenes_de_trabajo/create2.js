
var db = {};

window.db = db;
db.detalle = [];

$("#ButtonOrdenDeTrabajo2").click(function(event) {
		saveDescription();
	
});

function saveDescription(button) {
	$("#ButtonOrdenDeTrabajo2").attr('disabled', 'disabled');
	var l = Ladda.create(document.querySelector("#ButtonOrdenDeTrabajo2"));
	l.start();
	var formData = $("#OrdenDeTrabajoForm2").serialize();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		url: "/ordenes_de_trabajo/save2",
		data: formData,
		dataType: "json",
		success: function(data) {
			window.location = "/home/" 
		},
		always: function() {
			l.stop();
		},
		error: function() {
			alert("Ha ocurrido un problema, contacte a su administrador!!");
		}
		
	});
}