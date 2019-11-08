@extends('layouts.app')
@section('content')

<!--Header-part-->

<!--sidebar-menu-->

<!--main-container-part-->
<!-- <link rel="stylesheet" href="http://cdn.oesmith.co.uk/morris-0.4.3.min.css"> -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<!-- <script src="http://cdn.oesmith.co.uk/morris-0.4.3.min.js"></script> -->
<div id="content">
	<!--breadcrumbs-->
	<div id="content-header">
		<div id="breadcrumb"> <a href="/home" class="tip-bottom" data-original-title="Go to Home"><i class="icon-home"></i> Home</a></div>
	</div>
	@if ( Auth::user()->is("superadmin|administrator|consulta_central") )
	<!--End-breadcrumbs-->

	<!--Action boxes-->
	<div class="container-fluid">
		<div class="quick-actions_homepage">
			<ul class="quick-actions">
					<li class="bg_ly"> <a href=/venta/new> <i class="icon-inbox"></i><span class="label label-important"></span>Nueva Venta </a> </li>
					<li class="bg_lb"> <a href=/cuentas_por_cobrar> <i class="icon-user"></i> Cuentas por Cobrar</a> </li>
				<li class="bg_lg"> <a href=/cortes_caja> <i class="icon-file"></i> Corte de caja</a> </li>
				<li class="bg_lb"> <a href=/existencias/producto> <i class="icon-user"></i> Existencias de Productos</a> </li>
					<li class="bg_ly"> <a href=/ventas> <i class="icon-money"></i>Facturas y Traslados</a> </li>

				</ul>
			</div>
			<!--End-Action boxes-->    


			<hr>
			</div>

				<div class="row">
			

				</div>
				@endif
				@if ( Auth::user()->is("operador") )
				<div class="quick-actions_homepage">
					<ul class="quick-actions">

						
						</ul>
					</div>
					@endif
				</div>

				<!--end-main-container-part-->

				<!--Footer-part-->

				<div class="row-fluid">
					<div id="footer" class="span12">Copyright © 2019 <a target="blank" href="https://technovation.com.gt">Technovation.com.gt</a>
                        . All rights reserved.</div>
				</div>

				<!--end-Footer-part-->


				@include("users.delete-modal")
				<script type="text/javascript">
	// This function is called from the pop-up menus to transfer to
	// a different page. Ignore if the value returned is a null string:
	function goPage (newURL) {

			// if url is empty, skip the menu dividers and reset the menu selection to default
			if (newURL != "") {

					// if url is "-", it is this page -- reset the menu:
					if (newURL == "-" ) {
						resetMenu();            
					} 
					// else, send page to designated URL            
					else {  
						document.location.href = newURL;
					}
				}
			}

// resets the menu selection upon entry to this page:
function resetMenu() {
	document.gomenu.selector.selectedIndex = 2;
}



</script>

<ul class="typeahead dropdown-menu"></ul>
@endsection
