<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>SFI</title>

	<link rel="stylesheet" href="/sfi/css/bootstrap.min.css">
	<link rel="stylesheet" href="/sfi/css/bootstrap-responsive.min.css">
	<link rel="stylesheet" href="/sfi/css/fullcalendar.css">
	<link rel="stylesheet" href="/sfi/css/matrix-style.css">
	<link rel="stylesheet" href="/sfi/css/matrix-media.css">
	<link href="/sfi/css/font-awesome.min.css" rel="stylesheet">
	<link href="/sfi/css/font_awesome.css" rel="stylesheet">
	<link rel="stylesheet" href="/sfi/css/jquery.gritter.css">
	<link rel="stylesheet" href="/sfi/css/responsive.css">

	<link rel="stylesheet" href="/sfi/css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="/sfi/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="/sfi/css/responsive.bootstrap.min.css"">
	<link rel="stylesheet" href="/sfi/css/morris-0.4.3.min.css">
	<link rel="stylesheet" href="/sfi/css/custom-styles.css">
	<link rel="stylesheet" href="/sfi/css/bootstrap-select.min.css">
	<link rel="stylesheet" href="/sfi/css/bootstrap-datetimepicker.min.css">
	<link rel="stylesheet" href="/sfi/css/buttons.dataTables.min.css">
	<link rel="stylesheet" href="/sfi/css/bootstrap-toggle.min.css">
	<link rel="stylesheet" href="/sfi/css/jsgrid.css">
	<link rel="stylesheet" href="/sfi/css/theme.css">
	<link rel="stylesheet" href="/sfi/css/ladda-themeless.min.css">
	<link rel="stylesheet" href="/sfi/css/style.css">

	<script src="/sfi/js/jquery.min.js"></script> 

	{{-- <script src="{{ elixir('js/app.js') }}"></script> --}}

	<script src="/sfi/js/excanvas.min.js"></script> 
	<script src="/sfi/js/moment.min.js"></script> 
	<script src="/sfi/js/bootstrap-datetimepicker.min.js"></script> 


	<script src="/sfi/js/jquery.ui.custom.js"></script> 
	<script src="/sfi/js/bootstrap.min.js"></script> 
	<script src="/sfi/js/bootstrap-select.min.js"></script> 
	<script src="/sfi/js/bootstrap-toggle.min.js"></script> 
	<script src="/sfi/js/jquery.flot.min.js"></script> 
	<script src="/sfi/js/jquery.flot.resize.min.js"></script> 
	<script src="/sfi/js/jquery.peity.min.js"></script> 
	<script src="/sfi/js/fullcalendar.min.js"></script> 
	<script src="/sfi/js/matrix.js"></script> 
	<script src="/sfi/js/matrix.dashboard.js"></script> 
	<script src="/sfi/js/jquery.gritter.min.js"></script> 
	<script src="/sfi/js/matrix.interface.js"></script> 
	<script src="/sfi/js/matrix.chat.js"></script> 
	<script src="/sfi/js/jquery.validate.js"></script> 
	<script src="/sfi/js/matrix.form_validation.js"></script> 
	<script src="/sfi/js/jquery.wizard.js"></script> 
	<script src="/sfi/js/jquery.uniform.js"></script> 
	<script src="/sfi/js/select2.min.js"></script> 
	<script src="/sfi/js/matrix.popover.js"></script> 
	<script src="/sfi/js/jquery.dataTables.min.js"></script> 
	<script src="/sfi/js/matrix.tables.js"></script> 
	<script src="/sfi/js/typehead.js"></script> 
	<script src="/sfi/js/box.min.js"></script> 
	<script src="/sfi/js/loadingoverlay.min.js"></script> 
	<script src="/sfi/js/loadingoverlay_progress.min.js"></script> 

	<script src="{{ URL::to("/sfi/js/jquery.metisMenu.js")  }}"></script>
	<script src="{{ URL::to("/sfi/js/raphael-2.1.0.min.js")  }}"></script>
	<script src="{{ URL::to("/sfi/js/morris.js")  }}"></script>
	<script src="{{ URL::to("/sfi/js/custom-scripts.js")  }}"></script>

	<script src="/sfi/js/dataTables.bootstrap.min.js"></script> 
	<script src="/sfi/js/dataTables.buttons.min.js"></script> 
	<script src="/sfi/js/dataTables.responsive.min.js"></script> 
	<script src="/sfi/js/custom_render.js"></script> 
	<script src="/sfi/js/spin.min.js"></script>
	<script src="/sfi/js/ladda.jquery.min.js"></script> 
	<script src="/sfi/js/ladda.min.js"></script> 

	<script src="{{ URL::to("/sfi/js/buttons.html5.min.js")  }}"></script>
	<script src="{{ URL::to("/sfi/js/datatable/jszip.min.js")  }}"></script>
	<script src="{{ URL::to("/sfi/js/datatable/pdfmake.min.js")  }}"></script>
	<script src="{{ URL::to("/sfi/js/datatable/vfs_fonts.js")  }}"></script>


	<script src="/sfi/js/jsgrid.js"></script>
</head>

<body id="app-layout">
	@if(Auth::guest())
	<nav class="navbar navbar-default navbar-static-top"> 
		<div class="container">
			<div class="navbar-header">
				<!-- Collapsed Hamburger -->
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<!-- Branding Image -->
				<a class="navbar-brand" href="{{ url('/') }}">
					SFI - La Nueva San José - Chiquimula
				</a>
			</div>
			<div class="collapse navbar-collapse" id="app-navbar-collapse">
				<!-- Left Side Of Navbar -->
				<ul class="nav navbar-nav">
					<li><a href="{{ url('/home') }}">Home</a></li>
				</ul>
				<!-- Right Side Of Navbar -->
				<ul class="nav navbar-nav navbar-right">
					<li><a href="{{ url('/login') }}">Login</a></li>
				</ul>
			</div>
		</div>
	</nav>
	@else
	<nav class="navbar navbar-default navbar-static-top"> 
		<div class="container">
			<div class="navbar-header">

				<!-- Collapsed Hamburger -->
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>

				<!-- Branding Image -->
				<a class="navbar-brand" href="{{ url('/') }}">
					SFI - La Nueva San José - Chiquimula
				</a>
			</div>
			<div class="collapse navbar-collapse" id="app-navbar-collapse">
				<!-- Left Side Of Navbar -->
				<ul class="nav navbar-nav ">
					>
				</ul>

				<!-- Right Side Of Navbar -->
				<ul class="nav navbar-nav navbar-right">
					@if ( Auth::user()->is("superadmin|administrator|consulta_central|finanzas|operador") )
					<li><a href="{{ url('/logout') }}"><i class="icon icon-share-alt"></i> <span class="text">Logout / Salir del Sistema</span></a></li>
					@endif
				</ul>
			</div>
		</div>
	</nav>

	<div id="header">
		<h1><a href="dashboard.html">SFI Admin</a></h1>
	</div>
	<!--close-Header-part--> 


	<!--top-Header-menu-->

	<!--close-top-Header-menu-->
	<!--start-top-serch-->
	<!--close-top-serch-->
	<!--sidebar-menu-->
	@if ( Auth::user()->is("superadmin|administrator|consulta_central|finanzas|operador") )
	<div id="sidebar"><a href="#" class="visible-phone"><i class="icon icon-home"></i> Dashboard</a>

		<ul style="display: block;">
			@if ( Auth::user()->is("superadmin|administrator|consulta_central") )
			<li class="active"><a href="/home"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>
			@endif
			
			@if ( Auth::user()->is("superadmin|administrator|finanzas|operador") )
			<li class="submenu"> <a href="#"><i class="fa fa-cogs"></i> <span>Procesos</span> <span class="label label-important"></span></a>
				@endif
				<ul>
					@if ( Auth::user()->is("superadmin|administrator|finanzas") )
					<li><a href="/factura"><i class="icon icon-th"></i> <span>Facturas</span></a></li>
					@endif
					@if ( Auth::user()->is("superadmin|administrator|finanzas") )
					<li><a href="/factura_cambiaria"><i class="icon icon-th"></i> <span>Facturas Cambiarias</span></a></li>
					@endif
					@if ( Auth::user()->is("superadmin|administrator|finanzas") )
					<li><a href="/nota_credito2"><i class="icon icon-th"></i> <span>Notas de Crédito</span></a></li>
					@endif
					@if ( Auth::user()->is("superadmin|administrator|finanzas") )
					<li><a href="/nota_debito2"><i class="icon icon-th"></i> <span>Notas de Débito</span></a></li>
					@endif
					@if ( Auth::user()->is("superadmin|administrator|finanzas") )
					<li><a href="/recibo_caja"><i class="icon icon-th"></i> <span>Recibos de Caja</span></a></li>
					@endif
					@if ( Auth::user()->is("superadmin|administrator|finanzas|operador") )
					<li> <a href="/vales"><i class="icon icon-signal"></i> <span>Vales</span></a> </li>
					@endif
				</ul>
			</li>

			@if ( Auth::user()->is("superadmin|administrator|finanzas|operador") )
			<li class="submenu"> <a href="#"><i class="icon icon-file"></i> <span>Catálogos Generales</span> <span class="label label-important"></span></a>
				@endif
				<ul>
					@if ( Auth::user()->is("superadmin|administrator|finanzas") )
					<li><a href="/bombas_combustibles">Asignar Combustible a Bombas</a></li>
					@endif
					@if ( Auth::user()->is("superadmin|administrator|finanzas") )
					<li><a href="/bancos">Bancos</a></li>
					@endif
					@if ( Auth::user()->is("superadmin|administrator|finanzas") )
					<li><a href="/bombas">Bomba</a></li>
					@endif
					@if ( Auth::user()->is("superadmin|administrator") )
					<li><a href="/cargos">Cargos de Empleados</a></li>
					@endif
					@if ( Auth::user()->is("superadmin|administrator|finanzas|operador") )
					<li><a href="/clientes">Clientes</a></li>
					@endif
					@if ( Auth::user()->is("superadmin|administrator") )
					<li><a href="/empleados">Empleados</a></li>
					@endif
					@if ( Auth::user()->is("superadmin|administrator|finanzas") )
					<li><a href="/idp">IDP</a></li>
					@endif
					@if ( Auth::user()->is("superadmin|administrator|finanzas|operador") )
					<li><a href="/marcas">Marcas de Productos</a></li>
					@endif
					@if ( Auth::user()->is("superadmin|administrator|finanzas") )
					<li><a href="/precio_combustible">Precio Combustible</a></li>
					@endif
					@if ( Auth::user()->is("superadmin|administrator|finanzas|operador") )
					<li><a href="/productos">Productos</a></li>
					@endif
					@if ( Auth::user()->is("superadmin|administrator|finanzas") )
					<li><a href="/saldos_clientes">Saldos Finales de Clientes por Mes</a></li>
					@endif
					@if ( Auth::user()->is("superadmin|administrator|finanzas") )
					<li><a href="/series2">Series de Documentos</a></li>
					@endif
					@if ( Auth::user()->is("superadmin|administrator") )
					<li><a href="/tipo_vehiculo">Tipo Vehículo</a></li>
					@endif
				</ul>
			</li>

			@if ( Auth::user()->is("superadmin|administrator|finanzas|operador") )
			<li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Reportes Generales</span> <span class="label label-important"></span></a>
				@endif
				<ul>
					@if ( Auth::user()->is("superadmin|administrator|finanzas|operador") )
					<li><a href="/rpt_estado_cuenta_cliente">Estado de Cuenta de Clientes</a></li> 
					@endif
					@if ( Auth::user()->is("superadmin|administrator|finanzas") )
					<li><a href="/rpt_listado_vale_cliente">Listado de Vales por Cliente</a></li>
					@endif
					@if ( Auth::user()->is("superadmin|administrator|finanzas") )
					<li><a href="/rpt_listado_vale_diario">Listado de Vales Diarios</a></li>
					@endif
					@if ( Auth::user()->is("superadmin|administrator|finanzas") )
					<li><a href="/rpt_listado_abono_diario">Listado de Abonos Diarios</a></li>
					@endif
					@if ( Auth::user()->is("superadmin|administrator|finanzas|operador") )
					<li><a href="/saldos_consolidado_cliente">Listado de Saldos de Clientes por Fecha</a></li>
					@endif
					@if ( Auth::user()->is("superadmin|administrator|finanzas|operador") )
					<li><a target="blank" href="/listado_clientes">Listado de Clientes</a></li>
					@endif
					@if ( Auth::user()->is("superadmin|administrator|finanzas|operador") )
					<li><a href="/rpt_cierre_mes">Reporte Saldos Cierre de Mes</a></li>
					@endif
				</ul>
			</li>

			@if ( Auth::user()->is("superadmin|administrator|finanzas") )
			<li class="submenu"> <a href="#"><i class="icon icon-file"></i> <span>Corte de Caja</span> <span class="label label-important"></span></a>
				@endif
				<ul>
					@if ( Auth::user()->is("superadmin|administrator|finanzas") )
					<li><a href="/corte_caja">Registrar Corte Diario</a></li>
					@endif
					@if ( Auth::user()->is("superadmin|administrator|finanzas") )
					<li><a href="/vouchers">Registro de Vouchers de Tarjeta</a></li>
					@endif
					@if ( Auth::user()->is("superadmin|administrator|finanzas") )
					<li><a href="/faltantes">Registro de Faltantes de Efectivo</a></li>
					@endif
					@if ( Auth::user()->is("superadmin|administrator|finanzas") )
					<li><a href="/cupones">Registro de Cupones Texaco</a></li>
					@endif
					@if ( Auth::user()->is("superadmin|administrator|finanzas") )
					<li><a href="/rpt_listado_vouchers_diario">Listado de Vouchers de Tarjeta</a></li>
					@endif
					@if ( Auth::user()->is("superadmin|administrator|finanzas") )
					<li><a href="/rpt_listado_faltantes_efectivo">Listado de Faltantes de Efectivo</a></li>
					@endif
					@if ( Auth::user()->is("superadmin|administrator|finanzas") )
					<li><a href="/rpt_listado_cupones">Listado de Cupones Texaco</a></li>
					@endif
				</ul>
			</li>


			@if ( Auth::user()->is("superadmin|administrator|finanzas|operador|consulta_central") )
			<li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Administración</span> <span class="label label-important"></span></a>
				@endif
				<ul>
					@if ( Auth::user()->is("superadmin|administrator") )
					<li><a href="{{ url('/user') }}">Gestión de Usuarios</a></li>
					@endif
					@if ( Auth::user()->is("superadmin|administrator|finanzas|operador|consulta_central") )
					<li><a class="edit-my-user" href="#"><i class="fa fa-key"></i> Cambiar Contraseña</a></li>
					@endif
					@if ( Auth::user()->is("superadmin|administrator|finanzas|operador|consulta_central") )
					<li><a href="{{ url('/logout') }}"><i class="icon icon-share-alt"></i> <span class="text">Logout / Salir del Sistema</span></a></li>
					@endif
				</ul>
			</li>
		</ul>
	</div>

	@endif
	@endif
	@yield('content')

	@if ( !Auth::guest())
	@include("users.delete-modal")
	@include("users.active-modal")
	@include("users.bloq-modal")
	@include("users.activar-modal")
	@include("users.edit-my-account")
	@include("users.edit-my-user")
	@include("users.delete-special")
	@endif

	<script src="{{ URL::to("/sfi/js/users/update.js")  }}"></script>
	<script src="{{ URL::to("/sfi/js/users/update-information.js")  }}"></script>

	@yield('scripts')

</body>
</html>
