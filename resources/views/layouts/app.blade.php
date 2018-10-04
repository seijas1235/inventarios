<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>SFI</title>

<script
  src="https://code.jquery.com/jquery-3.3.1.js"
  integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
  crossorigin="anonymous"></script>

	{{--<script src="{{ URL::to("js/jquery.min.js")  }}"></script>--}}
	<script src="{{ URL::to("js/bootstrap.min.js")  }}"></script>
	<script src="{{ URL::to("js/jquery.validate.js")  }}"></script>
	<script src="{{ URL::to("js/moment.min.js")  }}"></script>
	<script src="{{ URL::to("js/bootstrap-select.min.js")  }}"></script>
	<script src="{{ URL::to("js/bootstrap-datetimepicker.min.js")  }}"></script>

	<!--    <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script> -->

	<script src="{{ URL::to("js/datatable/initialize.js")  }}"></script>
	<script src="{{ URL::to("js/datatable/custom_render.js")  }}"></script>
	<script src="{{ URL::to("js/datatable/jquery.dataTables.min.js")  }}"></script>
	<script src="{{ URL::to("js/datatable/dataTables.bootstrap.min.js")  }}"></script>
	<script src="{{ URL::to("js/datatable/dataTables.responsive.min.js")  }}"></script>
    <script src="{{ URL::to("js/datatable/responsive.bootstrap.min.js")  }}"></script>
    {!! HTML::script('/js/jsgrid.min.js') !!}
	{!! HTML::style('/css/jsgrid.css') !!}
    {!! HTML::style('/css/theme.css') !!}
    
    <script src="{{ URL::to("js/dataTables.buttons.min.js")  }}"></script>
	<script src="{{ URL::to("js/buttons.html5.min.js")  }}"></script>
	<script src="{{ URL::to("js/pdfmake.min.js")  }}"></script>
	<script src="{{ URL::to("js/vfs_fonts.js")  }}"></script>
	<script src="{{ URL::to("js/jszip.min.js")  }}"></script>
	<script src="{{ URL::to("js/bootstrap-toggle.min.js")  }}"></script>

	

	<link rel="stylesheet" href="/css/bootstrap.min.css">
	<link rel="stylesheet" href="/css/bootstrap-responsive.min.css">
	<link rel="stylesheet" href="/css/fullcalendar.css">
	<link rel="stylesheet" href="/css/matrix-style.css">
	<link rel="stylesheet" href="/css/matrix-media.css">
	<link href="/css/font-awesome.min.css" rel="stylesheet">
	<link href="/css/font_awesome.css" rel="stylesheet">
	<link rel="stylesheet" href="/css/jquery.gritter.css">
	<link rel="stylesheet" href="/css/responsive.css">

	<link rel="stylesheet" href="/css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="/css/responsive.bootstrap.min.css"">
	<link rel="stylesheet" href="/css/morris-0.4.3.min.css">
	<link rel="stylesheet" href="/css/custom-styles.css">
	<link rel="stylesheet" href="/css/bootstrap-select.min.css">
	<link rel="stylesheet" href="/css/bootstrap-datetimepicker.min.css">
	<link rel="stylesheet" href="/css/buttons.dataTables.min.css">
	<link rel="stylesheet" href="/css/bootstrap-toggle.min.css">
	<link rel="stylesheet" href="/css/theme.css">
	<link rel="stylesheet" href="/css/ladda-themeless.min.css">
	<link rel="stylesheet" href="/css/style.css">

	<link rel="stylesheet" href="/css/select2.min.css">

	<script src="/js/excanvas.min.js"></script> 

	<script src="/js/jquery.ui.custom.js"></script> 
	<script src="/js/jquery.flot.min.js"></script> 
	<script src="/js/jquery.flot.resize.min.js"></script> 
	<script src="/js/jquery.peity.min.js"></script> 
	<script src="/js/fullcalendar.min.js"></script> 
	<script src="/js/matrix.js"></script> 
	<script src="/js/matrix.dashboard.js"></script> 
	<script src="/js/jquery.gritter.min.js"></script> 
	<script src="/js/matrix.interface.js"></script> 
	<script src="/js/matrix.chat.js"></script> 
	<script src="/js/matrix.form_validation.js"></script> 
	<script src="/js/jquery.wizard.js"></script> 
	<!--<script src="/js/jquery.uniform.js"></script> --> 
	<script src="/js/matrix.popover.js"></script> 
	<script src="/js/matrix.tables.js"></script> 
	<script src="/js/typehead.js"></script> 
	<script src="/js/box.min.js"></script> 
	<script src="/js/loadingoverlay.min.js"></script> 
	<script src="/js/loadingoverlay_progress.min.js"></script> 

	<script src="/js/select2.full.min.js"></script> 

	<script src="{{ URL::to("/js/jquery.metisMenu.js")  }}"></script>
	<script src="{{ URL::to("/js/raphael-2.1.0.min.js")  }}"></script>
	<script src="{{ URL::to("/js/morris.js")  }}"></script>
	<script src="{{ URL::to("/js/custom-scripts.js")  }}"></script>
	<script src="/js/spin.min.js"></script>
	<script src="/js/ladda.jquery.min.js"></script> 
	<script src="/js/ladda.min.js"></script> 


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
			<li class="{{request()->is('home')? 'active': ''}}"><a href="/home"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>
			@endif
			
			@if ( Auth::user()->is("superadmin|administrator|finanzas|operador") )
			<li class="submenu"> <a href="#"><i class="fa fa-cogs"></i> <span>Procesos</span> <span class="label label-important"></span></a>
				@endif
				<ul>
					@if ( Auth::user()->is("superadmin|administrator|finanzas") )
					<li><a href="/factura"><i class="icon icon-th"></i> <span>Facturas</span></a></li>
					<li><a href="/series"><i class="icon icon-th"></i> <span>Series</span></a></li>
					<li><a href="/compras"><i class="icon icon-th"></i> <span>Compras</span></a></li>
					<li><a href="/ventas"><i class="icon icon-th"></i> <span>Ventas</span></a></li>
					@endif
				</ul>
			</li>

			@if ( Auth::user()->is("superadmin|administrator|finanzas|operador") )
			<li class="submenu {{request()->is('tipos_cliente*', 'clientes*','maquinarias_equipo*' ,'tipos_vehiculo*','marcas*','vehiculos*','puestos*', 'empleados*','proveedores*')? 'open active': ''}}">
				<a href="#"><i class="icon icon-file"></i> <span>Catálogos Generales</span> <span class="label label-important"></span></a>
				@endif
				<ul>

					<li class="{{request()->is('documentos*')? 'active': ''}}"><a href="/documentos">Documentos</a></li>

					<li class="{{request()->is('tipos_cliente*')? 'active': ''}}"><a href="/tipos_cliente">Tipos de cliente</a></li>
					
					<li class="{{request()->is('clientes*')? 'active': ''}}"><a href="/clientes">Clientes</a></li>

					<li class="{{request()->is('tipos_vehiculo*')? 'open active': ''}}"><a href="/tipos_vehiculo">Tipos de Vehiculo</a></li>

					<li class="{{request()->is('marcas*')? 'open active': ''}}"><a href="/marcas">Marcas</a></li>

					<li class="{{request()->is('vehiculos*')? 'open active': ''}}"><a href="/vehiculos">Vehiculos</a></li>
					
					<li class="{{request()->is('puestos*')? 'open active': ''}}"><a href="/puestos">Puestos</a></li>
					
					<li class="{{request()->is('empleados*')? 'open active': ''}}"><a href="/empleados">Empleados</a></li>

					<li class="{{request()->is('proveedores*')? 'open active': ''}}"><a href="/proveedores">Proveedores</a></li>

					<li class="{{request()->is('unidades_de_medida*')? 'open active': ''}}"><a href="/unidades_de_medida">Unidades de medida</a></li>

					<li class="{{request()->is('productos*')? 'open active': ''}}"><a href="/productos">Productos</a></li>

					<li class="{{request()->is('precios_producto*')? 'open active': ''}}"><a href="/precios_producto">Precios de Producto</a></li>

					<li class="{{request()->is('maquinarias_equipo*')? 'open active': ''}}"><a href="/maquinarias_equipo">Maquinarias y equipos</a></li>

					<li class="{{request()->is('mantto_equipo*')? 'open active': ''}}"><a href="/mantto_equipo">Mantenimientos</a></li>

					<li class="{{request()->is('servicios*')? 'open active': ''}}"><a href="/servicios">Servicios</a></li>

					@if ( Auth::user()->is("superadmin|administrator|finanzas") )
					<li><a href="/bancos">Bancos</a></li>
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
					
				</ul>
			</li>

			@if ( Auth::user()->is("superadmin|administrator|finanzas") )
			<li class="submenu"> <a href="#"><i class="icon icon-file"></i> <span>Corte de Caja</span> <span class="label label-important"></span></a>
				@endif
				<ul>
					@if ( Auth::user()->is("superadmin|administrator|finanzas") )
					<li><a href="/corte_caja">Registrar Corte Diario</a></li>
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

	<script src="{{ URL::to("/js/users/update.js")  }}"></script>
	<script src="{{ URL::to("/js/users/update-information.js")  }}"></script>

	@yield('scripts')

</body>
</html>
