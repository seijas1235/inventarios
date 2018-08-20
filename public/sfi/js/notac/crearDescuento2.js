$("input[name='galones_super").change(function () {


  var old_total = $("input[name='total']").val();
  var precio = $("input[name='super']").val();

  if (old_total > 0) {
    $("input[name='total']").val(old_total - $("input[name='total_super']").val());
  }


  $("input[name='total_super']").val(precio * $("input[name='galones_super").val());

  var total = parseInt($("input[name='total']").val());

  $("input[name='total']").val(total +  parseInt($("input[name='total_super']").val()));


});


$("input[name='super").change(function () {


  var old_total = $("input[name='total']").val();
  var galones = $("input[name='galones_super']").val();

  if (old_total > 0) {
    $("input[name='total']").val(old_total - $("input[name='total_super']").val());
  }


  $("input[name='total_super']").val(galones * $("input[name='super").val());

  var total = parseInt($("input[name='total']").val());

  $("input[name='total']").val(total +  parseInt($("input[name='total_super']").val()));


});




$("input[name='galones_regular").change(function () {

 var old_total = $("input[name='total']").val();
 var precio = $("input[name='regular']").val();

 if (old_total > 0) {
  $("input[name='total']").val(old_total - $("input[name='total_regular']").val());
}


$("input[name='total_regular']").val(precio * $("input[name='galones_regular").val());

var total = parseInt($("input[name='total']").val());

$("input[name='total']").val(total +  parseInt($("input[name='total_regular']").val()));

});



$("input[name='regular").change(function () {

 var old_total = $("input[name='total']").val();
 var regular = $("input[name='galones_regular']").val();

 if (old_total > 0) {
  $("input[name='total']").val(old_total - $("input[name='total_regular']").val());
}


$("input[name='total_regular']").val(regular * $("input[name='regular").val());

var total = parseInt($("input[name='total']").val());

$("input[name='total']").val(total +  parseInt($("input[name='total_regular']").val()));

});



$("input[name='galones_disel").change(function () {
  var old_total = $("input[name='total']").val();
  var precio = $("input[name='disel']").val();


  if (old_total > 0) {
    $("input[name='total']").val(old_total - $("input[name='total_disel']").val());
  }

  $("input[name='total_disel']").val(precio * $("input[name='galones_disel").val());

  var total = parseInt($("input[name='total']").val());

  $("input[name='total']").val(total +  parseInt($("input[name='total_disel']").val()));

});


$("input[name='disel").change(function () {
  var old_total = $("input[name='total']").val();
  var disel = $("input[name='galones_disel']").val();


  if (old_total > 0) {
    $("input[name='total']").val(old_total - $("input[name='total_disel']").val());
  }

  $("input[name='total_disel']").val(disel * $("input[name='galones_disel").val());

  var total = parseInt($("input[name='total']").val());

  $("input[name='total']").val(total +  parseInt($("input[name='total_disel']").val()));

});



$('#CreateNota').click( function (e) {
 e.preventDefault();
 saveVale();
} );



function saveVale() {

 var has_super =true;
 var has_regular = true;
 var has_disel = true;

 var cliente_id = $("#cliente_id").val();
 var monto = $("input[name='total").val();
 var galones_super = $("input[name='galones_super").val();
 if (galones_super == 0 || galones_super == null) {
  var has_super = false;
}

var total_super = $("input[name='total_super").val();
var total_regular = $("input[name='total_regular").val();


var galones_regular = $("input[name='galones_regular").val();
if (galones_regular == 0 || galones_regular == null) {
  var has_regular = false;
}

var total_disel = $("input[name='total_disel").val();
var galones_disel = $("input[name='galones_disel").val();
if (galones_disel == 0 || galones_disel == null) {
  var has_disel = false;
}


var detalle = [];


if (has_super) {
 detalle.push({ combustible_id: 5, cantidad: galones_super, subtotal: total_super});
}
if (has_regular) {
 detalle.push({ combustible_id: 6, cantidad: galones_regular, subtotal: total_regular});
}
if (has_disel) {
 detalle.push({ combustible_id: 4, cantidad: galones_disel, subtotal: total_disel});
}



var formData = {
  monto: monto,
  cliente_id: cliente_id, 
  detalle : detalle
} 


$.ajax({
  type: "GET",
  url: "/nota_credito/pronto/save",
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


