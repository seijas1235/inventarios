$(document).ready(function() {

  $(document).on("keypress", 'form', function (e) {
    var code = e.keyCode || e.which;
    if (code == 13) {
      e.preventDefault();
      return false;
    }
  });
});


var validator = $("#CorteCForm").validate({
  ignore: [],
  onkeyup:false,
  rules: {
    fecha_corte: {
      required : true,
    },
    observaciones: {
      required : true,
    }
  },
  messages: {
    fecha_corte: {
      required: "Por favor, seleccione la fecha a la que pertenece el corte"
    },
    observaciones: {
      required : "Por favor, ingrese los números de boleta de depósito"
    }
  }
});



$('#fecha_corte').datetimepicker({
    format: 'YYYY-MM-DD',
    showClear: true,
    showClose: true
});


$(".btn-calcular").click(function(event) {

  $("input[name='galones']").val(parseFloat($("input[name='gal_super']").val()) + parseFloat($("input[name='gal_regular']").val()) + parseFloat($("input[name='gal_diesel']").val()));
  $("input[name='combustible']").val(parseFloat($("input[name='total_super']").val()) + parseFloat($("input[name='total_regular']").val()) + parseFloat($("input[name='total_diesel']").val()));
  $("input[name='total_efectivo']").val(parseFloat($("input[name='deposito_grande']").val()) + parseFloat($("input[name='deposito_colas']").val()) + parseFloat($("input[name='deposito_posterior']").val()));
  $("input[name='total_ventas']").val(parseFloat($("input[name='combustible']").val()));
  $("input[name='total_ventas_turno']").val(parseFloat($("input[name='total_efectivo']").val()) + parseFloat($("input[name='vales']").val()) + parseFloat($("input[name='tarjeta']").val()) + parseFloat($("input[name='gastos']").val()) + parseFloat($("input[name='anticipo_empleado']").val()) + parseFloat($("input[name='gastos_bg']").val()) + parseFloat($("input[name='faltantes']").val()) + parseFloat($("input[name='cupones']").val()) + parseFloat($("input[name='devoluciones']").val()) + parseFloat($("input[name='calibraciones']").val()));

  var totalv = parseFloat($("input[name='total_ventas']").val()).toFixed(2);
  var totalvt = parseFloat($("input[name='total_ventas_turno']").val()).toFixed(2);

  var res = totalv - totalvt;

  if (res > 0){
    $("input[name='resultado_turno']").val("Faltante");
    $("input[name='resultado_q']").val(parseFloat(res).toFixed(2));    
  }else if (res < 0){
    $("input[name='resultado_turno']").val("Sobrante");
    $("input[name='resultado_q']").val(parseFloat(res).toFixed(2));
  }else if (res == 0){
    $("input[name='resultado_turno']").val("Cuadrado");
    $("input[name='resultado_q']").val(parseFloat(res).toFixed(2));
  }
});


$("#ButtonCorte").click(function(event) {
  if ($('#CorteCForm').valid()) {
    event.preventDefault();
    saveFac();
  } else {
    validator.focusInvalid();
  }
});


function saveFac() {
  var fecha_corte = $("input[name='fecha_corte").val();
  var fecha_inventario = $("input[name='fecha_corte").val();
  var codigo_corte = $("input[name='codigo_corte").val();
  var lubricantes = $("input[name='lubricantes").val();
  var gal_super = $("input[name='gal_super").val();
  var total_super = $("input[name='total_super").val();
  var gal_regular = $("input[name='gal_regular").val();
  var total_regular = $("input[name='total_regular").val();
  var gal_diesel = $("input[name='gal_diesel").val();
  var total_diesel = $("input[name='total_diesel").val();
  var combustible = $("input[name='combustible").val();
  var total_ventas = $("input[name='total_ventas").val();
  var deposito_grande = $("input[name='deposito_grande").val();
  var deposito_colas = $("input[name='deposito_colas").val();
  var deposito_posterior = $("input[name='deposito_posterior").val();
  var total_efectivo = $("input[name='total_efectivo").val();
  var tarjeta = $("input[name='tarjeta").val();
  var vales = $("input[name='vales").val();
  var gastos = $("input[name='gastos").val();
  var devoluciones = $("input[name='devoluciones").val();
  var faltantes = $("input[name='faltantes").val();
  var anticipo_empleado = $("input[name='anticipo_empleado").val();
  var calibraciones = $("input[name='calibraciones").val();
  var cupones = $("input[name='cupones").val();
  var observaciones = $("input[name='observaciones").val();
  var gastos_bg = $("input[name='gastos_bg").val();
  var total_ventas_turno = $("input[name='total_ventas_turno").val();
  var resultado_turno = $("input[name='resultado_turno").val();
  var resultado_q = $("input[name='resultado_q").val();


  var formData = {
    fecha_corte: fecha_corte,
    fecha_inventario: fecha_inventario,
    codigo_corte: codigo_corte,
    lubricantes: lubricantes,
    gal_super : gal_super,
    total_super : total_super,
    gal_regular : gal_regular,
    total_regular : total_regular,
    gal_diesel : gal_diesel,
    total_diesel : total_diesel,
    combustible : combustible,
    total_ventas : total_ventas,
    deposito_grande : deposito_grande,
    deposito_colas : deposito_colas,
    deposito_posterior : deposito_posterior,
    total_efectivo : total_efectivo,
    tarjeta : tarjeta,
    vales : vales,
    gastos : gastos,
    devoluciones : devoluciones,
    faltantes : faltantes,
    cupones : cupones,
    anticipo_empleado : anticipo_empleado,
    calibraciones : calibraciones,
    observaciones : observaciones,
    gastos_bg : gastos_bg,
    total_ventas_turno : total_ventas_turno,
    resultado_turno : resultado_turno,
    resultado_q : resultado_q
  } 

  $.ajax({
    type: "POST",
    headers: {'X-CSRF-TOKEN': $('#token').val()},
    url: "/sfi_tecu/corte_caja/save",
    data: formData,
    async: false,
    dataType: 'json',
    success: function(data) {
      window.location = "/sfi_tecu/corte_caja";
    },
    error: function() {
      alert("Ha ocurrido un error, comuniquese con su administrador");
    }
  });
}

