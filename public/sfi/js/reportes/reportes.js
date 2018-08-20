$(document).ready(function() {

	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});
});

var db = {};

window.db = db;
db.detalle = [];


$('#fechasccf').datetimepicker({
    format: 'DD-MM-YYYY',
    showClear: true,
    showClose: true
});


$('#fechainiciocb').datetimepicker({
    format: 'DD-MM-YYYY',
    showClear: true,
    showClose: true
});

$('#fechafinalcb').datetimepicker({
    format: 'DD-MM-YYYY',
    showClear: true,
    showClose: true
});

$('#fechav').datetimepicker({
    format: 'DD-MM-YYYY',
    showClear: true,
    showClose: true
});


$('#fechacp').datetimepicker({
    format: 'DD-MM-YYYY',
    showClear: true,
    showClose: true
});

$('#fechaas').datetimepicker({
    format: 'DD-MM-YYYY',
    showClear: true,
    showClose: true
});

$('#fechafed').datetimepicker({
    format: 'DD-MM-YYYY',
    showClear: true,
    showClose: true
});

$('#fecha1lbgrf').datetimepicker({
    format: 'DD-MM-YYYY',
    showClear: true,
    showClose: true
});

$('#fecha2lbgrf').datetimepicker({
    format: 'DD-MM-YYYY',
    showClear: true,
    showClose: true
});

$('#fecha1lbgvf').datetimepicker({
    format: 'DD-MM-YYYY',
    showClear: true,
    showClose: true
});

$('#fecha2lbgvf').datetimepicker({
    format: 'DD-MM-YYYY',
    showClear: true,
    showClose: true
});

$('#fecha1lbgcf').datetimepicker({
    format: 'DD-MM-YYYY',
    showClear: true,
    showClose: true
});

$('#fecha2lbgcf').datetimepicker({
    format: 'DD-MM-YYYY',
    showClear: true,
    showClose: true
});

$('#fecha1lbgsf').datetimepicker({
    format: 'DD-MM-YYYY',
    showClear: true,
    showClose: true
});

$('#fecha2lbgsf').datetimepicker({
    format: 'DD-MM-YYYY',
    showClear: true,
    showClose: true
});


$('#fechainicioece').datetimepicker({
    format: 'DD-MM-YYYY',
    showClear: true,
    showClose: true
});

$('#fechafinalece').datetimepicker({
    format: 'DD-MM-YYYY',
    showClear: true,
    showClose: true
});


$('#fechainiciordf').datetimepicker({
    format: 'DD-MM-YYYY',
    showClear: true,
    showClose: true
});

$('#fechafinalrdf').datetimepicker({
    format: 'DD-MM-YYYY',
    showClear: true,
    showClose: true
});

$(".pdf-button").click(function(event) {
	
	var fecha = $('input[name="fecha"]').val();

	window.open("/sfi/pdf_lad?fecha="+ fecha);
});



$(".pdf_lvd-button").click(function(event) {
	
	var fechav = $('input[name="fechav"]').val();

	window.open("/sfi/pdf_lvd?fecha="+ fechav);
});


$(".pdf_sccf-button").click(function(event) {
	
	var fechasccf = $('input[name="fechasccf"]').val();

	window.open("/sfi/pdf_sccf?fecha="+ fechasccf);
});



$(".pdf_lcp-button").click(function(event) {
	
	var fecha = $('input[name="fechacp"]').val();

	window.open("/sfi/pdf_lcp?fecha="+ fecha);
});



$(".pdf_lgd-button").click(function(event) {
	
	var fecha = $('input[name="fechag"]').val();

	window.open("/sfi/pdf_lgd?fecha="+ fecha);
});



$(".pdf_lvsd-button").click(function(event) {
	
	var fecha = $('input[name="fechav"]').val();

	window.open("/sfi/pdf_lvsd?fecha="+ fecha);
});


$(".pdf_lfed-button").click(function(event) {
	
	var fecha = $('input[name="fechafed"]').val();

	window.open("/sfi/pdf_lfed?fecha="+ fecha);
});



$(".pdf_lasd-button").click(function(event) {
	
	var fecha = $('input[name="fechaas"]').val();

	window.open("/sfi/pdf_lasd?fecha="+ fecha);
});



$(".pdf_lvc-button").click(function(event) {
	
	var fechainicio = $('input[name="fechainicio"]').val();
	var fechafinal = $('input[name="fechafinal"]').val();
	var cliente = $('#cliente_id').val();

	window.open("/sfi/pdf_lvc?fechainicio="+ fechainicio +"&fechafinal="+ fechafinal +"&cliente="+ cliente);
});


$(".pdf_ecb-button").click(function(event) {
	
	var fechainicio = $('input[name="fechainiciocb"]').val();
	var fechafinal = $('input[name="fechafinalcb"]').val();
	var cuenta = $('#cuenta_id').val();

	window.open("/sfi/pdf_ecb?fechainicio="+ fechainicio +"&fechafinal="+ fechafinal +"&cuenta="+ cuenta);
});


$(".pdf_lbgrf-button").click(function(event) {
	
	var fechainicio = $('input[name="fecha1lbgrf"]').val();
	var fechafinal = $('input[name="fecha2lbgrf"]').val();

	window.open("/sfi/pdf_lbgrf?fechainicio="+ fechainicio +"&fechafinal="+ fechafinal);
});


$(".pdf_lbgvf-button").click(function(event) {
	
	var fechainicio = $('input[name="fecha1lbgvf"]').val();
	var fechafinal = $('input[name="fecha2lbgvf"]').val();

	window.open("/sfi/pdf_lbgvf?fechainicio="+ fechainicio +"&fechafinal="+ fechafinal);
});


$(".pdf_lbgcf-button").click(function(event) {
	
	var fechainicio = $('input[name="fecha1lbgcf"]').val();
	var fechafinal = $('input[name="fecha2lbgcf"]').val();

	window.open("/sfi/pdf_lbgcf?fechainicio="+ fechainicio +"&fechafinal="+ fechafinal);
});



$(".pdf_lbgsf-button").click(function(event) {
	
	var fechainicio = $('input[name="fecha1lbgsf"]').val();
	var fechafinal = $('input[name="fecha2lbgsf"]').val();

	window.open("/sfi/pdf_lbgsf?fechainicio="+ fechainicio +"&fechafinal="+ fechafinal);
});



$(".pdf_rdf-button").click(function(event) {
	
	var fechainicio = $('input[name="fechainiciordf"]').val();
	var fechafinal = $('input[name="fechafinalrdf"]').val();
	var combustible = $('#combustible_id').val();

	window.open("/sfi/pdf_rdf?fechainicio="+ fechainicio +"&fechafinal="+ fechafinal +"&combustible="+ combustible);
});



$(".pdf_ecc-button").click(function(event) {
	
	var fechainicio = $('input[name="fechainiciocc"]').val();
	var fechafinal = $('input[name="fechafinalcc"]').val();
	var cliente = $('#cliente_id').val();

	window.open("/sfi/pdf_ecc?fechainicio="+ fechainicio +"&fechafinal="+ fechafinal +"&cliente="+ cliente);
});


$(".pdf_ece-button").click(function(event) {
	
	var fechainicio = $('input[name="fechainicioece"]').val();
	var fechafinal = $('input[name="fechafinalece"]').val();
	var empleado = $('#empleado_id').val();

	window.open("/sfi/pdf_ece?fechainicio="+ fechainicio +"&fechafinal="+ fechafinal +"&empleado="+ empleado);
});


$(".pdf_rcm-button").click(function(event) {

	var mes = $('#mes_id').val();
	var anio = $('#anio_id').val();

	window.open("/sfi/pdf_rcm?mes="+ mes +"&anio="+ anio);
});
