function unsetPasswordErrors( input_name )
{
	$("#"+input_name+"-error").addClass("hidden");
	$("#"+input_name+"-error").text( "" );
	$("#"+input_name+"-error").parent().parent().removeClass("has-error");
}

function setPassworddErrors( input_name , text )
{
	$("#"+input_name+"-error").removeClass("hidden");
	$("#"+input_name+"-error").text( text );
	$("#"+input_name+"-error").parent().parent().addClass("has-error");
}


$('body').on('click', 'a.remove-detallescompras', function(e) {
	$( ".confirm-delete" , "#userDeleteModal").removeAttr("field");
	var id = $(this).parent().parent().attr("id");
	$("input[name='password_delete']").val("");
	unsetPasswordErrors("password_delete");
	var user = $(this).parent().parent().parent().parent().children().eq(0).text();
	$("#userDeleteModal").hide().show();
	$("#userDeleteModal").modal();
	if (user.length = 1) {
		$("#message").text("este ingreso?");
		$(".variable").text("");
		$(".entity").text("");
	} else {
		$("#message").text("esta ingreso");
		$(".variable").text("");
		$(".entity").text("");
	}
	$(".confirm-delete", "#userDeleteModal").attr("id", "delete-" + id);
});


$('body').on('click', 'a.edit-detallescompras', function(e) {
	e.preventDefault();
	unsetFieldErrors("existencias");
	$("#detallescomprasUpdateModal").modal();
	$("#detallescomprasUpdateModal").hide().show();
	$("#password-changed").addClass("hidden");
	var id = $(this).parent().parent().attr("id");
	/*var url= "/pos_v2/detallescompras/name/"+id;*/
	var url= "detallescompras/name/"+id;
	$.getJSON( url , function ( data ) {
		$('#edit-compras-form').data("id", id);
		$("#edit-compras-form input[name='precio_costo']").val( data.precio_compra);
	});
	$('#fecha').datetimepicker({
		format: 'DD-MM-YYYY',
		showClear: true,
		showClose: true
	});

});

function unsetFieldErrors( input_name )
{
	$("#"+input_name+"-error").addClass("hidden");
	$("#"+input_name+"-error").text( "" );
	$("#"+input_name+"-error").parent().parent().removeClass("has-error");
}

function setFieldErrors( input_name , text )
{
	$("#"+input_name+"-error").removeClass("hidden");
	$("#"+input_name+"-error").text( text );
	$("#"+input_name+"-error").parent().parent().addClass("has-error");
}

$('body').on('click', 'button.confirm-delete', function( e ) {
	e.preventDefault();
	var id  = $(this).attr("id").replace("delete-", "");

	var td  = $("#"+id);

	/*var url = "/pos_v2/detallescompras/destroy/"+id;*/
	var url = "/detallescompras/destroy/"+id;
	var password_delete = $("input[name='password_delete']").val().trim();
	data = {
		password_delete : password_delete
	};

	$("#user-created-message").addClass("hidden");

	$.ajax({
		method: "DELETE",
		url: url,
		data: JSON.stringify(data),
		contentType: "application/json",
	}).done(function (data){
		$(".user-created-message").removeClass("hidden");
		$(".user-created-message").addClass("alert-success");
		$(".user-created-message").fadeIn();
		$(".user-created-message > p").text("Ingreso borrado exitosamente!");
		venta_detalle.ajax.reload();
		$("#userDeleteModal").modal("hide");
	}).fail(function(errors) {
		var errors = JSON.parse(errors.responseText);
		if (errors.password_delete != null) setPassworddErrors("password_delete", errors.password_delete);
		else unsetPasswordErrors("password_delete");
	});
	return false;
});