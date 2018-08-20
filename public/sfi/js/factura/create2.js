$('#fecha_factura').datetimepicker({
  format: 'DD-MM-YYYY',
  showClear: true,
  showClose: true
});


$(document).ready(function() {

  $(document).on("keypress", 'form', function (e) {
    var code = e.keyCode || e.which;
    if (code == 13) {
      e.preventDefault();
      return false;
    }
  });
});


var validator = $("#Factura2Form").validate({
  ignore: [],
  onkeyup:false,
  rules: {
    fecha_factura: {
      required : true,
    },
    numero_factura: {
      required : true,
    },
    nit: {
      required : true,
    },
    cliente: {
      required : true,
    },
    serie_id: {
      required : true,
    }
  },
  messages: {
    fecha_factura: {
      required: "Por favor, ingrese una fecha"
    },
    numero_factura: {
      required: "Por favor, ingrese un No. de Factura"
    },
    nit: {
      required: "Por favor, ingrese el nit del cliente"
    },
    cliente: {
      required: "Por favor, ingrese el nombre del cliente"
    },
    serie_id: {
      required: "Por favor, seleccione una serie"
    }
  }
});


$("input[name='cant_super").change(function () {

  var old_total = $("input[name='total']").val();
  var precio = $("input[name='super']").val();

  if (old_total > 0) {
    $("input[name='total']").val(old_total - $("input[name='total_super']").val());
  }

  $("input[name='total_super']").val(precio * $("input[name='cant_super").val());

  var total = parseInt($("input[name='total']").val());

  $("input[name='total']").val(total +  parseInt($("input[name='total_super']").val()));
});


$("input[name='cant_regular").change(function () {

 var old_total = $("input[name='total']").val();
 var precio = $("input[name='regular']").val();

 if (old_total > 0) {
  $("input[name='total']").val(old_total - $("input[name='total_regular']").val());
}

$("input[name='total_regular']").val(precio * $("input[name='cant_regular").val());

var total = parseInt($("input[name='total']").val());

$("input[name='total']").val(total +  parseInt($("input[name='total_regular']").val()));
});


$("input[name='cant_disel").change(function () {

  var old_total = $("input[name='total']").val();
  var precio = $("input[name='disel']").val();

  if (old_total > 0) {
    $("input[name='total']").val(old_total - $("input[name='total_disel']").val());
  }

  $("input[name='total_disel']").val(precio * $("input[name='cant_disel").val());

  var total = parseInt($("input[name='total']").val());

  $("input[name='total']").val(total +  parseInt($("input[name='total_disel']").val()));
});


$("input[name='total_lubs").change(function () {

  var total = parseInt($("input[name='total']").val());

  $("input[name='total']").val(total +  parseInt($("input[name='total_lubs']").val()));
});


$("input[name='total_otros").change(function () {

  var total = parseInt($("input[name='total']").val());

  $("input[name='total']").val(total +  parseInt($("input[name='total_otros']").val()));
});


$('#ButtonFac2').click( function (e) {
 e.preventDefault();
 saveFac();
} );


function saveFac() {

  var detalle = [];

var nit = $("input[name='nit").val();
  var cliente = $("input[name='cliente").val();
  var direccion = $("input[name='direccion").val();
  var total = $("input[name='total").val();
  var serie_id = $("#serie_id").val();
  var no_factura = $("input[name='no_factura").val();
  var fecha_factura = $("input[name='fecha_factura").val();
  var cant_super = $("input[name='cant_super").val();
  var total_super = $("input[name='total_super").val();
  var cant_regular = $("input[name='cant_regular").val();
  var total_regular = $("input[name='total_regular").val();
  var total_disel = $("input[name='total_disel").val();
  var cant_disel = $("input[name='cant_disel").val();
  var total_lubs = $("input[name='total_lubs").val();
  var total_otros = $("input[name='total_otros").val();

  if (total_disel > 0) {
    detalle.push({ combustible_id: 4, tipo_producto_id: 1, cantidad: cant_disel, subtotal: total_disel});
  }
  
  if (total_super > 0) {
    detalle.push({ combustible_id: 5, tipo_producto_id: 1,cantidad: cant_super, subtotal: total_super});
  }
  
  if (total_regular > 0) {
    detalle.push({ combustible_id: 6, tipo_producto_id: 1, cantidad: cant_regular, subtotal: total_regular});
  }
  
  if (total_lubs > 0) {
    detalle.push({ combustible_id: 7, tipo_producto_id: 2, cantidad: 1, subtotal: total_lubs});
  }
  
  if (total_otros > 0) {
    detalle.push({ combustible_id: 8, tipo_producto_id: 3, cantidad: 1, subtotal: total_otros});
  }

var formData = {
  total: total,
  cliente: cliente, 
  nit: nit, 
  direccion: direccion, 
  fecha_factura: fecha_factura,
  serie_id: serie_id,
  no_factura: no_factura,
  detalle : detalle
} 

$.ajax({
  type: "POST",
  headers: {'X-CSRF-TOKEN': $('#token').val()},
  url: "/sfi_tecu/factura/save2",
  data: formData,
  async: false,
  dataType: 'json',
  success: function(data) {
    window.location = "/sfi_tecu/factura";
  },
  error: function() {
    alert("Ha ocurrido un error");
  }
});
}